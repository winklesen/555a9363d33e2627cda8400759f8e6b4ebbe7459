<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\Point;

class DashboardController extends Controller
{
    public function dashboard() {
        return view('backend.dashboard');
    }
}
