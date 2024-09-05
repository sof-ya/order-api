<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;

class WorkerController extends Controller
{
    public function __invoke()
    {
        var_dump(Worker::all());
    }
}
