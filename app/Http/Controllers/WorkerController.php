<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Worker;

class WorkerController extends Controller
{
    public function __invoke()
    {
        dd(Worker::find(5)->orders()->get());
    }
}
