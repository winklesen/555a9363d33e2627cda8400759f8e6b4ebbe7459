<?php

namespace App\Http\Controllers\Penyisihan;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\Point;

class DashboardController extends Controller
{
    public function dashboard() {
        return view('penyisihan.dashboard');
    }
}
