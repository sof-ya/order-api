<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;

class OrderController extends Controller
{
    public function __invoke()
    {
        dd(Order::find(1)->type()->get());
    }
}
