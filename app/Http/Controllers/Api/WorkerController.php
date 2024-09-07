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
    
    public function index(Request $request) {
        try {
            $workers = $this->workerService->getAll($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($workers,'',200);
    }

    public function show(Worker $worker, Request $request) {

        try {
            $worker = $this->workerService->getById($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }
        
        return ApiResponseClass::sendResponse($worker,'',200);
    }

    public function store(Request $request) {

        try {
            $created_worker = $this->workerService->create($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($created_worker,'Исполнитель создан',200);
    }

    public function update(Worker $worker, Request $request) {

        try {
            $updated_worker = $this->workerService->update($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($updated_worker,'Данные об исполнителе обновлены',200);
    }

    public function destroy(Worker $worker, Request $request) {

        try {
            $deleted_worker = $this->workerService->destroy($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($deleted_worker,'Данные об исполнителе удалены',200);
    }

    public function setOrder(Worker $worker, Request $request) {

        try {
            $order_worker = $this->workerService->setOrder($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($order_worker,'Исполнитель назначен на заказ',200);
    }

    public function excludeOrderType(Worker $worker, Request $request) {

        try {
            $exclude_order_type = $this->workerService->excludeOrderType($request, $worker->id);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($exclude_order_type,'Исполнитель отказался от заказов данного типа',200);
    }

    public function filterByOrderType(Request $request) {

        try {
            $filter_workers = $this->workerService->filterByOrderType($request);
        } catch (Exeption $e) { 
            ApiResponseClass::throw($e, $e->getMessage());
        }

        return ApiResponseClass::sendResponse($filter_workers,'',200);
    }
}
