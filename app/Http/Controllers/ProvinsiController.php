<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ProvinsiController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Provinsi::where('status', 1)->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('tanggal_mulai', function ($row) {
                    return \Carbon\Carbon::parse($row->tanggal_mulai)->format('d M Y');
                })
                ->addColumn('tanggal_selesai', function ($row) {
                    return \Carbon\Carbon::parse($row->tanggal_selesai)->format('d M Y');
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

        $provinsis = Provinsi::where('status', 1)->orderBy('created_at', 'DESC')->get();
    
        return view('backend.provinsi', compact(
            'provinsis',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        try {
            $request->validate([
                'nama_provinsi' => 'required',
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
            ]);

            Provinsi::create([
                'nama_provinsi' => $request['nama_provinsi'],
                'nama_kota' => $request['nama_kota'],
                'tanggal_mulai' => $request['tanggal_mulai'],
                'tanggal_selesai' => $request['tanggal_selesai'],
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
                'tanggal_mulai' => 'required',
                'tanggal_selesai' => 'required',
            ]);

            $provinsi->update([
                'nama_provinsi' => $request['nama_provinsi'],
                'nama_kota' => $request['nama_kota'],
                'tanggal_mulai' => $request['tanggal_mulai'],
                'tanggal_selesai' => $request['tanggal_selesai'],
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
                $provinsi->update([
                    'status' => 0,
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
