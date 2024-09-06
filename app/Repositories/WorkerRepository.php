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

class WorkerRepository implements RecordsRepositoryInterface {

    public function index(Request $request){
        return WorkerResource::collection(Worker::all());
    }

    public function getById(Request $request, $id){
        return new WorkerResource(Worker::findOrFail($id));
    }

    public function store(Request $request){
        
        $request->validate([
            'name' => 'required',
            'second_name' => 'required',            
            'surname' => 'required',
            'phone' => 'numeric|regex:/^[0-9]{11}$/',
        ]);

        $worker = new Worker([
            'name' => $request->name,
            'second_name' => $request->second_name,
            'surname' => $request->surname,
            'phone' => $request->phone,
        ]);

        if($worker->save()) {
            return response()->json([
                'message' => 'Исполнитель успешно создан'
            ], 201);
        } else{
            return response()->json(['error'=>'Что-то пошло не так, данные не сохранены']);
        }
    }

    public function update(Request $request, $id){

        $request->validate([
            'phone' => 'numeric|regex:/^[0-9]{11}$/',
        ]);

        $worker = $this->getById($request, $id);

        $data = [
            'name' => $request->name ?? $worker->name,
            'second_name' => $request->second_name ?? $worker->second_name,
            'surname' => $request->surname ?? $worker->surname,
            'phone' => $request->phone ?? $worker->phone
        ];
        if($worker->update($data)
        ) {
            return response()->json([
                'message' => 'Данные об исполнителе успешно обновлены'
            ], 201);
        } else{
            return response()->json(['error'=>'Что-то пошло не так, данные не сохранены']);
        }
    }
    
    public function delete(Request $request, $id){

        $worker = $this->getById($request, $id);

        if($worker->delete()) {
            return response()->json([
                'message' => 'Данные об исполнителе удалены'
            ], 201);
        } else{
            return response()->json(['error'=>'Что-то пошло не так, данные не удалены']);
        }
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
            return response()->json(['error'=>'Исполнитель оказался от заказов этого типа']);
        } elseif ($exclude_order_query->find($request->order_id)) {
            if(!$worker->orders()->where('orders.id', $request->order_id)->exists()) {
                $worker->orders()->attach(
                    $order_query->find($request->order_id)->id, 
                    ['created_at' => Carbon::now(), 'updated_at' => Carbon::now()]
                );
            }
            $order_query->find($request->order_id)->update(['status' => "Назначен исполнитель"]);
            return response()->json(['message' => 'Исполнитель назначен на заказ'], 201);
        } else {
            return response()->json(['error'=>'Заказ не найден']);
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

        return response()->json(['message' => 'Исполнитель отказался от данного типа заказов'], 201);
    }

    // фильтр пользователей по заданному типу заказа
    public function filterByOrderType(Request $request) {
        $request->validate([
            'type_id' => 'required|array',
            'type_id.*' => 'numeric|exists:order_types,id',
        ]);
    
        $query = OrderType::whereIn("id", $request->type_id)
            ->whereNotIn('order_types.id', function ($subQuery) {
                $subQuery->select('workers_ex_order_types.order_type_id')
                ->from('workers_ex_order_types')
                ->whereColumn('workers_ex_order_types.worker_id', 'workers.id');
            }
        );

        $workers = Worker::whereExists($query)->get();
        
        return response()->json(WorkerResource::collection($workers));
    }
}
