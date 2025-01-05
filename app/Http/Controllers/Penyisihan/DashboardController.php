<?php

namespace App\Http\Controllers\Penyisihan;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function dashboard() {
        return view('penyisihan.dashboard');
    }
}
