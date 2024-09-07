<?php

namespace App\Repositories;
use App\Models\Worker;
use App\Models\OrderType;
use App\Interfaces\RecordsRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\WorkerResource;
use Carbon\Carbon;
use DB;
use App\Classes\ApiResponseClass;
use Illuminate\Testing\Exceptions\InvalidArgumentException;

class WorkerRepository implements RecordsRepositoryInterface {

    public function __construct(Worker $worker) {
        $this->worker = $worker;
    }

    public function index(Request $request){
        return WorkerResource::collection($this->worker->all());
    }

    public function getById(Request $request, $id){
        return new WorkerResource($this->worker->findOrFail($id));
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required',
            'second_name' => 'required',            
            'surname' => 'required',
            'phone' => 'numeric|regex:/^[0-9]{11}$/|unique:workers,phone',
        ]);

        $worker = new Worker([
            'name' => $request->name,
            'second_name' => $request->second_name,
            'surname' => $request->surname,
            'phone' => $request->phone,
        ]);

        $worker->save();
        return ($worker);
    }

    public function update(Request $request, $id){

        $request->validate([
            'phone' => 'numeric|regex:/^[0-9]{11}$/|unique:workers,phone',
        ]);

        $worker = $this->getById($request, $id);

        $data = [
            'name' => $request->name ?? $worker->name,
            'second_name' => $request->second_name ?? $worker->second_name,
            'surname' => $request->surname ?? $worker->surname,
            'phone' => $request->phone ?? $worker->phone
        ];

        $worker->update($data);
        return ($worker);
    }
    
    public function delete(Request $request, $id){

        $worker = $this->getById($request, $id);
        
        $worker->delete();
        return ($worker);
    }

    /*  
    *   функция назначения исполнителя на заказ (с проверкой, 
    *   не отказался ли исполнитель от заказов соответствующего типа)
    */
    public function setOrder(Request $request, $id) {
        $request->validate([
            'order_id' => 'required|numeric|exists:orders,id',
        ]);

        $worker = $this->getById($request, $id);
        $orderRepository = new OrderRepository;
        $ex_ids = $this->getById($request, $id)->exclude_orders()->pluck('id')->toArray();

        $order_query = $orderRepository->getByUserId($request);

        $exclude_order_query = $orderRepository->getByUserId($request)->whereNotIn('type_id', $ex_ids);
        $include_order_query = $orderRepository->getByUserId($request)->whereIn('type_id', $ex_ids);

        if($include_order_query->find($request->order_id)) {
            throw new InvalidArgumentException('Исполнитель оказался от заказов этого типа');
        } elseif ($exclude_order_query->find($request->order_id)) {
            if(!$worker->orders()->where('orders.id', $request->order_id)->exists()) {
                $worker->orders()->attach(
                    $order_query->find($request->order_id)->id, 
                    ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
                );
            }
            $order_query->find($request->order_id)->update(['status' => "Назначен исполнитель"]);
            return response()->json([
                'order' => $worker->orders()->where('orders.id', $request->order_id)->first(),
                'worker' => $worker], 200);
        } else {
            throw new InvalidArgumentException('Заказ не найден');
        }
    }

    // функция для исключения типов заказов исполнителя
    public function excludeOrderType(Request $request, $id) {
        $request->validate([
            'type_id' => 'required|numeric|exists:order_types,id',
        ]);

        $worker = $this->getById($request, $id);
        $orderTypeRepository = new OrderTypeRepository;

        $order_type = $orderTypeRepository->getById($request, $request->type_id);
        
        if(!$worker->exclude_orders()->where('workers_ex_order_types.order_type_id', $request->type_id)->exists()) {
            $worker->exclude_orders()->attach(
                $order_type->id, 
                ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
            );
        } 

        return response()->json([
            'type' => $worker->exclude_orders()->where('workers_ex_order_types.order_type_id', $request->type_id)->first(),
            'worker' => $worker], 200);
    }

    // фильтр пользователей по заданному типу заказа
    public function filterByOrderType(Request $request) {
        $request->validate([
            'type_id' => 'required|array',
            'type_id.*' => 'numeric|exists:order_types,id',
        ]);
    
        $orderTypeRepository = new OrderTypeRepository;
        
        $query = OrderType::whereIn("id", $request->type_id)
            ->whereNotIn('order_types.id', function ($subQuery) {
                $subQuery->select('workers_ex_order_types.order_type_id')
                ->from('workers_ex_order_types')
                ->whereColumn('workers_ex_order_types.worker_id', 'workers.id');
            }
        );

        $array_types = [];

        foreach ($request->type_id as $item) {
            $type = $orderTypeRepository->getById($request, $item);
            array_push($array_types, $type);
        }

        $workers = $this->worker->whereExists($query)->get();
        
        return response()->json(["types" => $array_types, "workers" => WorkerResource::collection($workers)]);
    }
}
