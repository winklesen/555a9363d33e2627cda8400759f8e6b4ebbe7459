<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PertanyaanSesi2Controller extends Controller
{
    public function index(Request $request, $provinsiId) {
        if ($request->ajax()) {
            $data = Pertanyaan::where('sesi', 2)->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
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
        $pertanyaans = Pertanyaan::where('sesi', 2)->orderBy('created_at', 'DESC')->get();
    
        return view('admin.pertanyaan-sesi-2', compact(
            'provinsi',
            'pertanyaans',
        ));
    }

    public function create($provinsiId) {}

    public function store(Request $request, $provinsiId) {
        try {
            $request->validate([
                'pertanyaan' => 'required',
                'sisi' => 'required',
            ]);

            Pertanyaan::create([
                'pertanyaan' => $request['pertanyaan'],
                'sisi' => $request['sisi'],
                'sesi' => 2,
            ]);

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($provinsiId, $id) {
        $pertanyaan = Pertanyaan::with('jawabans')->find($id);

        return response()->json($pertanyaan);
    }

    public function edit($provinsiId, $id) {}

    public function update(Request $request, $provinsiId, $id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 2)->find($id);

            $request->validate([
                'pertanyaan' => 'required',
                'sisi' => 'required',
            ]);

            $pertanyaan->update([
                'pertanyaan' => $request['pertanyaan'],
                'sisi' => $request['sisi'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($provinsiId, $id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 2)->find($id);

            if ($pertanyaan) {
                $pertanyaan->delete();
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
