<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\OrderRepository;
use App\Models\Order;

class OrderController extends Controller
{
    private OrderRepository $orderRepository;
    
    public function __construct(OrderRepository $orderRepository)
    {
        $this->orderRepository = $orderRepository;
    }
    
    public function index(Request $request) {
        return $this->orderRepository->index($request);
    }

    public function show(Order $order, Request $request) {
        return $this->orderRepository->getById($request, $order->id);
    }

    public function store(Request $request) {
        return $this->orderRepository->store($request);
    }

    public function update(Order $order, Request $request) {
        return $this->orderRepository->update($request, $order->id);
    }

    public function destroy(Order $order, Request $request) {
        return $this->orderRepository->delete($request, $order->id);
    }
}
