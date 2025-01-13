<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class SekolahController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Sekolah::where('status', 1);

            if ($request->provinsi_id) {
                $data->where('provinsi_id', $request->provinsi_id);
            }

            $data = $data->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('provinsi', function ($row) {
                    return $row->provinsi->nama_provinsi;
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

        $provinsis = Provinsi::where('status', 1)->get();
        $sekolahs = Sekolah::where('status', 1)->orderBy('created_at', 'DESC')->get();
    
        return view('backend.sekolah', compact(
            'provinsis',
            'sekolahs',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        try {
            $request->validate([
                'provinsi_id' => 'required',
                'nama_sekolah' => 'required',
            ]);

            Sekolah::create([
                'provinsi_id' => $request['provinsi_id'],
                'nama_sekolah' => $request['nama_sekolah'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id) {
        $sekolah = Sekolah::find($id);
        
        return response()->json($sekolah);
    }

    public function edit($id) {}

    public function update(Request $request, $id) {
        try {
            $sekolah = Sekolah::find($id);

            $request->validate([
                'provinsi_id' => 'required',
                'nama_sekolah' => 'required',
            ]);

            $sekolah->update([
                'provinsi_id' => $request['provinsi_id'],
                'nama_sekolah' => $request['nama_sekolah'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id) {
        try {
            $sekolah = Sekolah::find($id);

            if ($sekolah) {
                $sekolah->update([
                    'status' => 0,
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
