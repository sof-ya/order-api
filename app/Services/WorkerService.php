<?php

namespace App\Services;

use App\Repositories\WorkerRepository;
use Illuminate\Http\Request;
use App\Classes\ApiResponseClass;
use Exception;

class WorkerService
{
    private WorkerRepository $workerRepository;
    
    public function __construct(WorkerRepository $workerRepository) {
        $this->workerRepository = $workerRepository;
    }

    public function getAll(Request $request) {

        try {
            $workers = $this->workerRepository->index($request);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось получить данные об исполнителях");
        }

        return $workers;
    }

    public function getById(Request $request, $id) {

        try {
            $worker = $this->workerRepository->getById($request, $id);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось получить данные об исполнителе");
        }

        return $worker;
    }

    public function create(Request $request) {
        
        try {
            $created_worker = $this->workerRepository->store($request);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось создать исполнителя");
        }
        
        return $created_worker;
    }

    public function update(Request $request, $id) {
        
        try {
            $updated_worker = $this->workerRepository->update($request, $id);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось обновить данные об исполнителе");
        }

        return $updated_worker;
    }

    public function destroy(Request $request, $id) {
        
        try {
            $deleted_worker = $this->workerRepository->delete($request, $id);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось удалить исполнителя");
        }

        return $deleted_worker;
    }

    public function setOrder(Request $request, $id) {
        
        try {
            $set_info = $this->workerRepository->setOrder($request, $id);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось назначить исполнителя на заказ");
        }

        return $set_info;
    }

    public function excludeOrderType(Request $request, $id) {

        try {
            $exclude_order_type = $this->workerRepository->excludeOrderType($request, $id);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось исключить заказ данного типа для выбранного исполнителя");
        }

        return $exclude_order_type;
    }

    public function filterByOrderType(Request $request) {

        try {
            $filter_workers = $this->workerRepository->filterByOrderType($request);
        } catch (Exeption $e) { 
            ApiResponseClass::rollback($e, "Не удалось отфильтровать исполнителей по типу заказа");
        }

        return $filter_workers;
    }
}
