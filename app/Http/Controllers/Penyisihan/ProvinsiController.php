<?php

namespace App\Http\Controllers\Penyisihan;

use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProvinsiController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Provinsi::select('*')->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-list">';
                    $html .= '<a href="' . route('penyisihan.provinsi.sekolah.index', ['provinsiId' => $row->id]) . '" class="btn btn-success">Sekolah</a>';
                    $html .= '<button class="btn btn-primary edit" data-id="' . $row->id . '">Edit</button>';
                    $html .= '<button class="btn btn-danger delete" data-id="' . $row->id . '">Hapus</button>';
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $provinsis = Provinsi::orderBy('created_at', 'DESC')->get();
    
        return view('penyisihan.provinsi', compact(
            'provinsis',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        try {
            $request->validate([
                'nama_provinsi' => 'required',
            ]);

            Provinsi::create([
                'nama_provinsi' => $request['nama_provinsi'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id) {
        $provinsi = Provinsi::find($id);
        
        return response()->json($provinsi);
    }

    public function edit($id) {}

    public function update(Request $request, $id) {
        try {
            $provinsi = Provinsi::find($id);

            $request->validate([
                'nama_provinsi' => 'required',
            ]);

            $provinsi->update([
                'nama_provinsi' => $request['nama_provinsi'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id) {
        try {
            $provinsi = Provinsi::find($id);

            if ($provinsi) {
                $provinsi->delete();
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
