<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Worker;
use App\Services\WorkerService;
use App\Classes\ApiResponseClass;
use Exception;


class WorkerController extends Controller
{
    protected WorkerService $workerService;
    
    public function __construct(WorkerService $workerService) {
        $this->workerService = $workerService;
    }

    /**
    * @OA\Get(
    *   tags={"Исполнители"},
    *   path="/api/workers",
    *   security={{"Bearer token":{}}},
    *   operationId="workersIndex",
    *   summary="Все исполнители",
    *   description="Получить данные всех исполнителей", 
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
            $workers = $this->workerService->getAll($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($workers,'',200);
    }

    /**
    * @OA\Get(
    *   tags={"Исполнители"},
    *   path="/api/workers/{worker}",
    *   security={{"Bearer token":{}}},
    *   operationId="workerShow",
    *   summary="Получить данные исполнителя",
    *   description="Получить данные исполнителя по id", 
    *   @OA\Parameter(
    *       name="worker",
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

    public function show(Worker $worker, Request $request) {

        try {
            $worker = $this->workerService->getById($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($worker,'',200);
    }

    /**
    * @OA\Post(
    *   tags={"Исполнители"},
    *   path="/api/workers",
    *   security={{"Bearer token":{}}},
    *   operationId="workerStore",
    *   summary="Создать исполнителя",
    *   description="Создать нового исполнителя", 
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="second_name",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="surname",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="phone",
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
    *       description="Исполнитель создан",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Исполнитель создан",
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
            $created_worker = $this->workerService->create($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($created_worker,'Исполнитель создан',200);
    }

    /**
    * @OA\Put(
    *   tags={"Исполнители"},
    *   path="/api/workers/{worker}",
    *   security={{"Bearer token":{}}},
    *   operationId="workerUpdate",
    *   summary="Отредактировать исполнителя",
    *   description="Отредактировать исполнителя по id", 
    *   @OA\Parameter(
    *       name="worker",
    *       in="path",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="name",
    *       in="query",
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="second_name",
    *       in="query",
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="surname",
    *       in="query",
    *       @OA\Schema(
    *           type="string"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="phone",
    *       in="query",
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
    *       description="Исполнитель отредактирован",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Исполнитель отредактирован",
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

    public function update(Worker $worker, Request $request) {

        try {
            $updated_worker = $this->workerService->update($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($updated_worker,'Данные об исполнителе обновлены',200);
    }

    /**
    * @OA\Delete(
    *   tags={"Исполнители"},
    *   path="/api/workers/{worker}",
    *   security={{"Bearer token":{}}},
    *   operationId="workerDestroy",
    *   summary="Удалить исполнителя",
    *   description="Удалить исполнителя по id", 
    *   @OA\Parameter(
    *       name="worker",
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
    *       description="Исполнитель удален",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Исполнитель удален",
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

    public function destroy(Worker $worker, Request $request) {

        try {
            $deleted_worker = $this->workerService->destroy($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($deleted_worker,'Данные об исполнителе удалены',200);
    }

    /**
    * @OA\Post(
    *   tags={"Исполнители"},
    *   path="/api/workers/{worker}/set_order",
    *   security={{"Bearer token":{}}},
    *   operationId="workerSetOrder",
    *   summary="Назначить исполнителя",
    *   description="Назначить выбранного исполнителя на заказ по id", 
    *   @OA\Parameter(
    *       name="worker",
    *       in="path",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="order_id",
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
    *       description="Исполнитель назначен на заказ",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Исполнитель назначен на заказ",
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

    public function setOrder(Worker $worker, Request $request) {

        try {
            $order_worker = $this->workerService->setOrder($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($order_worker,'Исполнитель назначен на заказ',200);
    }

    /**
    * @OA\Post(
    *   tags={"Исполнители"},
    *   path="/api/workers/{worker}/exclude_order_type",
    *   security={{"Bearer token":{}}},
    *   operationId="workerExcludeOrder",
    *   summary="Исключить типы заказов для исполнителя",
    *   description="Исключить возможность назначить заказы определенного типа на выбранного исполнителя", 
    *   @OA\Parameter(
    *       name="worker",
    *       in="path",
    *       required=true,
    *       @OA\Schema(
    *           type="integer"
    *       )
    *   ),
    *   @OA\Parameter(
    *       name="type_id",
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
    *       description="Исполнитель отказался от заказов данного типа",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Исполнитель отказался от заказов данного типа",
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

    public function excludeOrderType(Worker $worker, Request $request) {

        try {
            $exclude_order_type = $this->workerService->excludeOrderType($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($exclude_order_type,'Исполнитель отказался от заказов данного типа',200);
    }

    /**
    * @OA\Post(
    *   tags={"Исполнители"},
    *   path="/api/workers/filter_by_order_type",
    *   security={{"Bearer token":{}}},
    *   operationId="workerFilterByOrderType",
    *   summary="Отфильтровать исполнителей по типам заказов",
    *   description="Вывести исполнителей по выбранным типам заказов (если в запросе есть тип заказов, от которых исполнитель не отказывался, то он попадает в выборку)", 
    *   @OA\Parameter(
    *       name="type_id[]",
    *       in="query",
    *       required=true,
    *       @OA\Schema(
    *           type="array",
    *           @OA\Items(type="integer")
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
    *       description="Исполнитель отказался от заказов данного типа",
    *       @OA\JsonContent()
    *   ),
    *   @OA\Response(
    *       response=200,
    *       description="Исполнитель отказался от заказов данного типа",
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

    public function filterByOrderType(Request $request) {

        try {
            $filter_workers = $this->workerService->filterByOrderType($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($filter_workers,'',200);
    }
}
