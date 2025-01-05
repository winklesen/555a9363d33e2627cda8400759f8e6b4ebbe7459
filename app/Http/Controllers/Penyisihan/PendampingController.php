<?php

namespace App\Http\Controllers\Penyisihan;

use App\Models\Sekolah;
use App\Models\Pendamping;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PendampingController extends Controller
{
    public function index(Request $request, $provinsiId, $sekolahId) {
        if ($request->ajax()) {
            $data = Pendamping::where('sekolah_id', $sekolahId)->orderBy('created_at', 'DESC');
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
        $pendampings = Pendamping::where('sekolah_id', $sekolahId)->orderBy('created_at', 'DESC')->get();
    
        return view('penyisihan.pendamping', compact(
            'sekolah',
            'pendampings',
        ));
    }

    public function create($provinsiId, $sekolahId) {}

    public function store(Request $request, $provinsiId, $sekolahId) {
        try {
            $request->validate([
                'nama_pendamping' => 'required',
            ]);

            Pendamping::create([
                'sekolah_id' => $sekolahId,
                'nama_pendamping' => $request['nama_pendamping'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($provinsiId, $sekolahId, $id) {
        $pendamping = Pendamping::find($id);

        return response()->json($pendamping);
    }

    public function edit($provinsiId, $sekolahId, $id) {}

    public function update(Request $request, $provinsiId, $sekolahId, $id) {
        try {
            $pendamping = Pendamping::find($id);

            $request->validate([
                'nama_pendamping' => 'required',
            ]);

            $pendamping->update([
                'nama_pendamping' => $request['nama_pendamping'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($provinsiId, $sekolahId, $id) {
        try {
            $pendamping = Pendamping::find($id);

            if ($pendamping) {
                $pendamping->delete();
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
