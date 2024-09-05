<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Partnership;

class PartnershipController extends Controller
{
    public function __invoke()
    {
        dd(Partnership::find(1)->order()->get());
    }
}
