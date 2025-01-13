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
            ]);

            Point::create([
                'sekolah_id' => $request['sekolah_id'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
