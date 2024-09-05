<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\Partnership;
use App\Interfaces\RecordsRepositoryInterface;
use Illuminate\Contracts\Container\BindingResolutionException;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;
use App\Http\Resources\OrderResource;

class OrderRepository implements RecordsRepositoryInterface {

    public function getByUserId(Request $request) : Builder
    {
        return Order::where("user_id", $request->user()->id);
    }
    
    public function index(Request $request){
        return OrderResource::collection($this->getByUserId($request)->get());
    }

    public function getById(Request $request, $id){
        return new OrderResource($this->getByUserId($request)->findOrFail($id));
    }

    public function store(Request $request){

        $request->validate([
            'type_id' => 'required|numeric|exists:order_types,id',
            'description' => 'required',            
            'address' => 'required',
            'date' => 'required|date',
            'amount' => 'required|numeric'
        ]);

        $order = new Order([
            'type_id' => $request->type_id,
            'partnership_id' => User::find($request->user()->id)->partnership()->first()->id,
            'user_id' => $request->user()->id,
            'description' => $request->description,
            'address' => $request->address,
            'date' => $request->date,
            'amount' => $request->amount,
            'status' => "Создан",
        ]);

        if($order->save()) {
            return response()->json([
                'message' => 'Заказ успешно создан'
            ], 201);
        } else{
            return response()->json(['error'=>'Что-то пошло не так, данные не сохранены']);
        }
    }

    public function update(Request $request, $id){

        $request->validate([
            'type_id' => 'numeric|exists:order_types,id',
            'date' => 'date',
            'amount' => 'numeric',
            'status' => 'in:Создан,Назначен исполнитель,Завершен'
        ]);

        $order = $this->getById($request, $id);

        $data = [
            'type_id' => $request->type_id ?? $order->type_id,
            'description' => $request->description ?? $order->description,
            'address' => $request->address ?? $order->address,
            'date' => $request->date ?? $order->date,
            'amount' => $request->amount ?? $order->amount,
            'status' => $request->status ?? $order->status
        ];
        if($order->update($data)
        ) {
            return response()->json([
                'message' => 'Заказ успешно обновлен'
            ], 201);
        } else{
            return response()->json(['error'=>'Что-то пошло не так, данные не сохранены']);
        }
    }
    
    public function delete(Request $request, $id){

        $order = $this->getById($request, $id);

        if($order->delete()) {
            return response()->json([
                'message' => 'Данные о заказе удалены'
            ], 201);
        } else{
            return response()->json(['error'=>'Что-то пошло не так, данные не удалены']);
        }
    }
}
