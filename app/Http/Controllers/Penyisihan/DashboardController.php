<?php

namespace App\Http\Controllers\Penyisihan;

use App\Models\Sekolah;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function dashboard() {
        $sekolahs = Sekolah::all();
        $sekolahGroupByGroups = $sekolahs->groupBy('group');
        
        return view('penyisihan.dashboard', compact(
            'sekolahGroupByGroups',
        ));
    }
}
