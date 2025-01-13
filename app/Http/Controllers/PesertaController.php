<?php

namespace App\Http\Controllers;

use App\Models\Peserta;
use Illuminate\Http\Request;
use App\Models\Sekolah;
use Yajra\DataTables\Facades\DataTables;

class PesertaController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Peserta::where('status', 1);

            if ($request->sekolah_id) {
                $data->where('sekolah_id', $request->sekolah_id);
            }

            $data = $data->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sekolah', function ($row) {
                    return $row->sekolah->nama_sekolah;
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

        $sekolahs = Sekolah::where('status', 1)->get();
        $pesertas = Peserta::where('status', 1)->orderBy('created_at', 'DESC')->get();
    
        return view('backend.peserta', compact(
            'sekolahs',
            'pesertas',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        try {
            $request->validate([
                'sekolah_id' => 'required',
                'nomor_peserta' => 'required|numeric',
                'nama_peserta' => 'required',
            ]);

            Peserta::create([
                'sekolah_id' => $request['sekolah_id'],
                'nomor_peserta' => $request['nomor_peserta'],
                'nama_peserta' => $request['nama_peserta'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id) {
        $peserta = Peserta::find($id);

        return response()->json($peserta);
    }

    public function edit($id) {}

    public function update(Request $request, $id) {
        try {
            $peserta = Peserta::find($id);

            $request->validate([
                'sekolah_id' => 'required',
                'nomor_peserta' => 'required|numeric',
                'nama_peserta' => 'required',
            ]);

            $peserta->update([
                'sekolah_id' => $request['sekolah_id'],
                'nomor_peserta' => $request['nomor_peserta'],
                'nama_peserta' => $request['nama_peserta'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id) {
        try {
            $peserta = Peserta::find($id);

            if ($peserta) {
                $peserta->update([
                    'status' => 0,
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
