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
                ->addColumn('point_per_sesi', function ($row) {
                    $sesi1 = $row->points->where('sesi', 1)->sum('point');
                    $sesi2 = $row->points->where('sesi', 2)->sum('point');
                    $sesi3 = $row->points->where('sesi', 3)->sum('point');

                    $html = '<div>';
                    $html .= '<div>Sesi 1 : ' . $sesi1 . '</div>';
                    $html .= '<div>Sesi 2 : ' . $sesi2 . '</div>';
                    $html .= '<div>Sesi 3 : ' . $sesi3 . '</div>';
                    $html .= '</div>';

                    return $html;
                })
                ->addColumn('point', function ($row) {
                    return $row->points->sum('point');
                })
                ->addColumn('berat_point', function ($row) {
                    return $row->points->sum('berat_point');
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-list">';
                    $html .= '<a href="' . route('penyisihan.provinsi.sekolah.peserta.index', ['provinsiId' => $row->provinsi->id, 'sekolahId' => $row->id]) . '" class="btn btn-success">Peserta</a>';
                    $html .= '<a href="' . route('penyisihan.provinsi.sekolah.pendamping.index', ['provinsiId' => $row->provinsi->id, 'sekolahId' => $row->id]) . '" class="btn btn-success">Pendamping</a>';
                    $html .= '<button class="btn btn-primary setGroup" data-id="' . $row->id . '">Set Group</button>';
                    $html .= '<button class="btn btn-primary edit" data-id="' . $row->id . '">Edit</button>';
                    $html .= '<button class="btn btn-danger delete" data-id="' . $row->id . '">Hapus</button>';
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['point_per_sesi', 'action'])
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

    public function setGroup($provinsiId, $id) {
        try {
            $sekolah = Sekolah::where('provinsi_id', $provinsiId)->find($id);

            $sekolahCount = Sekolah::where('provinsi_id', $provinsiId)->whereNotNull('group')->count();

            $sekolah->update([
                'group' => floor($sekolahCount / 3) + 1,
            ]);

            return response()->json([
                'message' => "$sekolah->nama_sekolah set Group $sekolah->group."
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
