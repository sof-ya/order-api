<?php

namespace App\Interfaces;
use Illuminate\Http\Request;
use App\Models\Order;

interface RecordsRepositoryInterface
{
    public function index(Request $request);
    public function getById(Request $request, $id);
    public function store(Request $request);
    public function update(Request $request, $id);
    public function delete(Request $request, $id);
}
