<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order;
use App\Services\OrderService;
use App\Classes\ApiResponseClass;
use Exception;

class OrderController extends Controller
{

    protected OrderService $orderService;
    
    public function __construct(OrderService $orderService) {
        $this->orderService = $orderService;
    }

    public function index(Request $request) {
        try {
            $orders = $this->orderService->getAll($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($orders,'',200);
    }

    public function show(Order $order, Request $request) {

        try {
            $order = $this->orderService->getById($request, $order->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($order,'',200);
    }

    public function store(Request $request) {

        try {
            $created_order = $this->orderService->store($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($created_order,'Заказ создан',200);
    }

    public function update(Order $order, Request $request) {

        try {
            $updated_order = $this->orderService->update($request, $order->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($updated_order,'Данные о заказе обновлены',200);
    }

    public function destroy(Order $order, Request $request) {

        try {
            $deleted_order = $this->orderService->destroy($request, $order->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($deleted_order,'Заказ удален',200);
    }
}
