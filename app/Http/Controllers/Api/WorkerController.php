<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\WorkerRepository;
use App\Models\Worker;

class WorkerController extends Controller
{
    private WorkerRepository $workerRepository;
    
    public function __construct(WorkerRepository $workerRepository) {
        $this->workerRepository = $workerRepository;
    }
    
    public function index(Request $request) {
        return $this->workerRepository->index($request);
    }

    public function show(Worker $worker, Request $request) {
        return $this->workerRepository->getById($request, $worker->id);
    }

    public function store(Request $request) {
        return $this->workerRepository->store($request);
    }

    public function update(Worker $worker, Request $request) {
        return $this->workerRepository->update($request, $worker->id);
    }

    public function destroy(Worker $worker, Request $request) {
        return $this->workerRepository->delete($request, $worker->id);
    }

    public function setOrder(Worker $worker, Request $request) {
        return $this->workerRepository->setOrder($request, $worker->id);
    }

    public function excludeOrderType(Worker $worker, Request $request) {
        return $this->workerRepository->excludeOrderType($request, $worker->id);
    }

    public function filterByOrderType(Request $request) {
        return $this->workerRepository->filterByOrderType($request);
    }
}
