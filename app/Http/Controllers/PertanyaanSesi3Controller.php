<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PertanyaanSesi3Controller extends Controller
{
    public function index(Request $request, $provinsiId) {
        if ($request->ajax()) {
            $data = Pertanyaan::with('jawaban')->where('sesi', 3)->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('jawaban', function ($row) {
                    return $row->jawaban->jawaban;
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-list">';
                    $html .= '<button class="btn btn-primary edit" data-id="' . $row->id . '">Edit</button>';
                    $html .= '<button class="btn btn-danger delete" data-id="' . $row->id . '">Hapus</button>';
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $provinsi = Provinsi::find($provinsiId);
        $pertanyaans = Pertanyaan::where('sesi', 3)->orderBy('created_at', 'DESC')->get();
    
        return view('admin.pertanyaan-sesi-3', compact(
            'provinsi',
            'pertanyaans',
        ));
    }

    public function create($provinsiId) {}

    public function store(Request $request, $provinsiId) {
        try {
            $request->validate([
                'pertanyaan' => 'required',
                'jawaban' => 'required',
            ]);

            $pertanyaan = Pertanyaan::create([
                'pertanyaan' => $request['pertanyaan'],
                'sesi' => 3,
            ]);

            $pertanyaan->jawaban()->create([
                'jawaban' => $request['jawaban'],
            ]);

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($provinsiId, $id) {
        $pertanyaan = Pertanyaan::with('jawabans')->find($id);

        return response()->json([
            'pertanyaan' => $pertanyaan->pertanyaan,
            'jawaban' => $pertanyaan->jawaban->jawaban,
        ]);
    }

    public function edit($provinsiId, $id) {}

    public function update(Request $request, $provinsiId, $id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 3)->find($id);

            $request->validate([
                'pertanyaan' => 'required',
            ]);

            $pertanyaan->update([
                'pertanyaan' => $request['pertanyaan'],
            ]);

            if ($pertanyaan->jawaban) {
                $pertanyaan->jawaban->update([
                    'jawaban' => $request['jawaban'],
                ]);
            } else {
                $pertanyaan->jawaban()->create([
                    'jawaban' => $request['jawaban'],
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($provinsiId, $id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 3)->find($id);

            if ($pertanyaan) {
                $pertanyaan->delete();
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
