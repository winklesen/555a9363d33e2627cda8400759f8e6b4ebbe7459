<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function penyisihan() {
        return view('charts.penyisihan');
    }
}
