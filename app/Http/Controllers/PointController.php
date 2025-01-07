<?php

namespace App\Http\Controllers;

use App\Models\Point;
use Illuminate\Http\Request;

class PointController extends Controller
{
    public function point(Request $request) {
        try {
            $request->validate([
                'sekolah_id' => 'required',
                'group' => 'required',
                'point_sesi_satu' => 'required',
                'point_sesi_dua' => 'required',
                'point_sesi_tiga' => 'required',
                'babak' => 'required',
            ]);

            $bobotPointSesiSatu = $request['point_sesi_satu'] * 0.2;
            $bobotPointSesiDua = $request['point_sesi_dua'] * 0.3;
            $bobotPointSesiTiga = $request['point_sesi_tiga'] * 0.5;

            Point::create([
                'sekolah_id' => $request['sekolah_id'],
                'babak' => $request['babak'],
                'group' => $request['group'],
                'point_sesi_satu' => $request['point_sesi_satu'],
                'point_sesi_dua' => $request['point_sesi_dua'],
                'point_sesi_tiga' => $request['point_sesi_tiga'],
                'bobot_point_sesi_satu' => $bobotPointSesiSatu,
                'bobot_point_sesi_dua' => $bobotPointSesiDua,
                'bobot_point_sesi_tiga' => $bobotPointSesiTiga,
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
