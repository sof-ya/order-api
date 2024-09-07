<?php

namespace App\Services;

use App\Repositories\OrderRepository;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use Exception;

class OrderService
{
    private OrderRepository $orderRepository;
    
    public function __construct(OrderRepository $orderRepository) {
        $this->orderRepository = $orderRepository;
    }


    public function getAll(Request $request) {

        try {
            $orders = $this->orderRepository->index($request);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось получить данные о заказах");
        }

        return $orders;
    }

    public function getById(Request $request, $id) {

        try {
            $order = $this->orderRepository->getById($request, $id);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось получить данные о заказе");
        }

        return $order;
    }

    public function store(Request $request) {

        try {
            $order = $this->orderRepository->store($request);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось сохранить данные о заказе");
        }

        return $order;
    }

    public function update(Request $request, $id) {

        try {
            $order = $this->orderRepository->update($request, $id);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось обновить заказ");
        }

        return $order;
    }

    public function destroy(Request $request, $id) {

        try {
            $order = $this->orderRepository->delete($request, $id);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось удалить заказ");
        }

        return $order;

    }
}
