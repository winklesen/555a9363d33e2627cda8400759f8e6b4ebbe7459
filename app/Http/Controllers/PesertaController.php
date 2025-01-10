<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use Yajra\DataTables\Facades\DataTables;

class PesertaController extends Controller
{
    public function index(Request $request, $provinsiId, $sekolahId) {
        if ($request->ajax()) {
            $data = Peserta::where('sekolah_id', $sekolahId)->orderBy('created_at', 'DESC');
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

        $sekolah = Sekolah::find($sekolahId);
        $pesertas = Peserta::where('sekolah_id', $sekolahId)->orderBy('created_at', 'DESC')->get();
    
        return view('admin.peserta', compact(
            'sekolah',
            'pesertas',
        ));
    }

    public function create($provinsiId, $sekolahId) {}

    public function store(Request $request, $provinsiId, $sekolahId) {
        try {
            $request->validate([
                'nomor_peserta' => 'required|numeric',
                'nama_peserta' => 'required',
            ]);

            Peserta::create([
                'sekolah_id' => $sekolahId,
                'nomor_peserta' => $request['nomor_peserta'],
                'nama_peserta' => $request['nama_peserta'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($provinsiId, $sekolahId, $id) {
        $peserta = Peserta::find($id);

        return response()->json($peserta);
    }

    public function edit($provinsiId, $sekolahId, $id) {}

    public function update(Request $request, $provinsiId, $sekolahId, $id) {
        try {
            $peserta = Peserta::find($id);

            $request->validate([
                'nomor_peserta' => 'required|numeric',
                'nama_peserta' => 'required',
            ]);

            $peserta->update([
                'nomor_peserta' => $request['nomor_peserta'],
                'nama_peserta' => $request['nama_peserta'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($provinsiId, $sekolahId, $id) {
        try {
            $peserta = Peserta::find($id);

            if ($peserta) {
                $peserta->delete();
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
