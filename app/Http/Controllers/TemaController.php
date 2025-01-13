<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TemaController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Tema::where('status', 1);

            if ($request->provinsi_id) {
                $data->where('provinsi_id', $request->provinsi_id);
            }

            if ($request->sesi) {
                $data->where('sesi', $request->sesi);
            }

            $data = $data->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('provinsi', function ($row) {
                    return $row->provinsi->nama_provinsi;
                })
                ->addColumn('status_aktif', function ($row) {
                    if ($row->status_aktif == 1) {
                        $html = '<span class="badge bg-success text-white">Aktif</span>';
                    } else {
                        $html = '<span class="badge bg-danger text-white">Tidak Aktif</span>';
                    }

                    return $html;
                })
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-list">';
                    $html .= '<button class="btn btn-primary edit" data-id="' . $row->id . '">Edit</button>';
                    $html .= '<button class="btn btn-danger delete" data-id="' . $row->id . '">Hapus</button>';
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns([
                    'status_aktif',
                    'action',
                ])
                ->make(true);
        }

        $provinsis = Provinsi::where('status', 1)->get();
        $temas = Tema::where('status', 1)->orderBy('created_at', 'DESC')->get();
    
        return view('backend.tema', compact(
            'provinsis',
            'temas',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        try {
            $request->validate([
                'provinsi_id' => 'required',
                'tema' => 'required',
                'sesi' => 'required',
            ]);

            Tema::create([
                'provinsi_id' => $request['provinsi_id'],
                'tema' => $request['tema'],
                'sesi' => $request['sesi'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id) {
        $tema = Tema::find($id);
        
        return response()->json($tema);
    }

    public function edit($id) {}

    public function update(Request $request, $id) {
        try {
            $tema = Tema::find($id);

            $request->validate([
                'provinsi_id' => 'required',
                'tema' => 'required',
                'sesi' => 'required',
            ]);

            $tema->update([
                'provinsi_id' => $request['provinsi_id'],
                'tema' => $request['tema'],
                'sesi' => $request['sesi'],
                'status_aktif' => $request['status_aktif'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id) {
        try {
            $tema = Tema::find($id);

            if ($tema) {
                $tema->update([
                    'status' => 0,
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
