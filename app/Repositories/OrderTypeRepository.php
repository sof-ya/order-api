<?php

namespace App\Repositories;

use App\Http\Resources\OrderTypeResource;
use App\Models\OrderType;
use Illuminate\Http\Request;

class OrderTypeRepository
{    
    public function index(Request $request){
        return OrderTypeResource::collection(OrderType::all());
    }

    public function getById(Request $request, $id){
        return new OrderTypeResource(OrderType::findOrFail($id));
    }
}
