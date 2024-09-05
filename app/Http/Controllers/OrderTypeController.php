<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\OrderType;

class OrderTypeController extends Controller
{
    public function __invoke()
    {
        dd(OrderType::find(3)->workers()->get());
    }
}
