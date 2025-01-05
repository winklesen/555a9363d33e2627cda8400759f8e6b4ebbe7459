<?php

namespace App\Http\Controllers\Penyisihan;

use App\Models\Sekolah;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class SekolahController extends Controller
{
    public function index(Request $request, $provinsiId) {
        if ($request->ajax()) {
            $data = Sekolah::where('provinsi_id', $provinsiId)->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $btn = '<div class="btn-list">';
                    $btn .= '<a href="' . route('penyisihan.provinsi.sekolah.peserta.index', ['provinsiId' => $row->provinsi->id, 'sekolahId' => $row->id]) . '" class="btn btn-success">Peserta</a>';
                    $btn .= '<a href="' . route('penyisihan.provinsi.sekolah.pendamping.index', ['provinsiId' => $row->provinsi->id, 'sekolahId' => $row->id]) . '" class="btn btn-success">Pendamping</a>';
                    $btn .= '<button class="btn btn-primary edit" data-id="' . $row->id . '">Edit</button>';
                    $btn .= '<button class="btn btn-danger delete" data-id="' . $row->id . '">Hapus</button>';
                    $btn .= '</div>';

                    return $btn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $provinsi = Provinsi::find($provinsiId);
        $sekolahs = Sekolah::where('provinsi_id', $provinsiId)->orderBy('created_at', 'DESC')->get();
    
        return view('penyisihan.sekolah', compact(
            'provinsi',
            'sekolahs',
        ));
    }

    public function create($provinsiId) {}

    public function store(Request $request, $provinsiId) {
        try {
            $request->validate([
                'nama_sekolah' => 'required',
            ]);

            Sekolah::create([
                'provinsi_id' => $provinsiId,
                'nama_sekolah' => $request['nama_sekolah'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($provinsiId, $id) {
        $sekolah = Sekolah::find($id);
        
        return response()->json($sekolah);
    }

    public function edit($provinsiId, $id) {}

    public function update(Request $request, $provinsiId, $id) {
        try {
            $sekolah = Sekolah::find($id);

            $request->validate([
                'nama_sekolah' => 'required',
            ]);

            $sekolah->update([
                'nama_sekolah' => $request['nama_sekolah'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($provinsiId, $id) {
        try {
            $sekolah = Sekolah::find($id);

            if ($sekolah) {
                $sekolah->delete();
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
