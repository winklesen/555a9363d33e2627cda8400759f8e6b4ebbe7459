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
                'sesi' => 'required',
                'point' => 'required',
            ]);

            $beratPoint = 0;

            if ($request['sesi'] == 1) {
                $beratPoint = $request['point'] * 0.2;
            } elseif ($request['sesi'] == 2) {
                $beratPoint = $request['point'] * 0.3;
            } elseif ($request['sesi'] == 3) {
                $beratPoint = $request['point'] * 0.5;
            }

            Point::create([
                'sekolah_id' => $request['sekolah_id'],
                'sesi' => $request['sesi'],
                'point' => $request['point'],
                'berat_point' => $beratPoint,
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
