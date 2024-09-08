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

    /**
    * @OA\Get(
    *   tags={"Заказы"},
    *   path="/api/orders",
    *   security={{"Bearer token":{}}},
    *   operationId="ordersIndex",
    *   summary="Все заказы",
    *   description="Получить список всех заказов", 
    *   @OA\RequestBody(
    *       @OA\JsonContent(),
    *       @OA\MediaType(
    *            mediaType="multipart/form-data",
    *       ),
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Данные получены",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Данные получены",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=422,
    *       description="Unprocessable Entity",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(response=400, description="Bad request"),
    *   @OA\Response(response=404, description="Resource Not Found"),
    * )
    */

    public function index(Request $request) {
        try {
            $orders = $this->orderService->getAll($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($orders,'',200);
    }

    /**
    * @OA\Get(
    *   tags={"Заказы"},
    *   path="/api/orders/{order}",
    *   security={{"Bearer token":{}}},
    *   operationId="orderShow",
    *   summary="Получить данные о заказе",
    *   description="Получить данные заказа по id", 
    *   @OA\Parameter(
    *       name="order",
    *       in="path",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\RequestBody(
    *       @OA\JsonContent(),
    *       @OA\MediaType(
    *            mediaType="multipart/form-data",
    *       ),
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Данные получены",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Данные получены",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=422,
    *       description="Unprocessable Entity",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(response=400, description="Bad request"),
    *   @OA\Response(response=404, description="Resource Not Found"),
    * )
    */

    public function show(Order $order, Request $request) {

        try {
            $order = $this->orderService->getById($request, $order->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($order,'',200);
    }

    /**
    * @OA\Post(
    *   tags={"Заказы"},
    *   path="/api/orders",
    *   security={{"Bearer token":{}}},
    *   operationId="orderStore",
    *   summary="Создать заказ",
    *   description="Создать новый заказ", 
    *   @OA\Parameter(
    *       name="type_id",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="description",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="address",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="date",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="string",
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="amount",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\RequestBody(
    *       @OA\JsonContent(),
    *       @OA\MediaType(
    *            mediaType="multipart/form-data",
    *       ),
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Заказ создан",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Заказ создан",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=422,
    *       description="Unprocessable Entity",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(response=400, description="Bad request"),
    *   @OA\Response(response=404, description="Resource Not Found"),
    * )
    */

    public function store(Request $request) {

        try {
            $created_order = $this->orderService->store($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($created_order,'Заказ создан',200);
    }

    /**
    * @OA\Put(
    *   tags={"Заказы"},
    *   path="/api/orders/{order}",
    *   security={{"Bearer token":{}}},
    *   operationId="orderUpdate",
    *   summary="Отредактировать заказ",
    *   description="Отредактировать заказ по id", 
    *   @OA\Parameter(
    *       name="order",
    *       in="path",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="type_id",
    *       in="query",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="description",
    *       in="query",
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="address",
    *       in="query",
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="date",
    *       in="query",
    *       @OA\Schema(
    *           type="string",
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="amount",
    *       in="query",
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="status",
    *       in="query",
    *       @OA\Schema(
    *           type="string",
    *           enum={"Создан", "Назначен исполнитель", "Завершен"}
    *       )
    *   ),
    *   @OA\RequestBody(
    *       @OA\JsonContent(),
    *       @OA\MediaType(
    *            mediaType="multipart/form-data",
    *       ),
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Заказ отредактирован",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Заказ отредактирован",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=422,
    *       description="Unprocessable Entity",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(response=400, description="Bad request"),
    *   @OA\Response(response=404, description="Resource Not Found"),
    * )
    */

    public function update(Order $order, Request $request) {

        try {
            $updated_order = $this->orderService->update($request, $order->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($updated_order,'Данные о заказе обновлены',200);
    }

    /**
    * @OA\Delete(
    *   tags={"Заказы"},
    *   path="/api/orders/{order}",
    *   security={{"Bearer token":{}}},
    *   operationId="orderDestroy",
    *   summary="Удалить заказ",
    *   description="Удалить заказ по id", 
    *   @OA\Parameter(
    *       name="order",
    *       in="path",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\RequestBody(
    *       @OA\JsonContent(),
    *       @OA\MediaType(
    *            mediaType="multipart/form-data",
    *       ),
    *   ),
    *   @OA\Response(
    *       response=201,
    *       description="Заказ удален",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Заказ удален",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=422,
    *       description="Unprocessable Entity",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(response=400, description="Bad request"),
    *   @OA\Response(response=404, description="Resource Not Found"),
    * )
    */

    public function destroy(Order $order, Request $request) {

        try {
            $deleted_order = $this->orderService->destroy($request, $order->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($deleted_order,'Заказ удален',200);
    }
}
