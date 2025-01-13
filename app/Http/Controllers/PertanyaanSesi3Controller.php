<?php

namespace App\Http\Controllers;

use App\Models\Provinsi;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PertanyaanSesi3Controller extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Pertanyaan::where('sesi', 3)->where('status', 1);

            if ($request->provinsi_id) {
                $data->where('provinsi_id', $request->provinsi_id);
            }

            $data = $data->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('provinsi', function ($row) {
                    return $row->provinsi->nama_provinsi;
                })
                ->addColumn('jawaban', function ($row) {
                    return $row->jawaban->jawaban;
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
        $pertanyaans = Pertanyaan::where('sesi', 3)->where('status', 1)->orderBy('created_at', 'DESC')->get();
    
        return view('backend.pertanyaan-sesi-3', compact(
            'provinsis',
            'pertanyaans',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        try {
            $request->validate([
                'provinsi_id' => 'required',
                'pertanyaan' => 'required',
                'jawaban' => 'required',
            ]);

            $pertanyaan = Pertanyaan::create([
                'provinsi_id' => $request['provinsi_id'],
                'pertanyaan' => $request['pertanyaan'],
                'sesi' => 3,
            ]);

            $pertanyaan->jawaban()->create([
                'jawaban' => $request['jawaban'],
            ]);

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id) {
        $pertanyaan = Pertanyaan::with('jawabans')->find($id);

        return response()->json([
            'pertanyaan' => $pertanyaan->pertanyaan,
            'jawaban' => $pertanyaan->jawaban->jawaban,
        ]);
    }

    public function edit($id) {}

    public function update(Request $request, $id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 3)->find($id);

            $request->validate([
                'provinsi_id' => 'required',
                'pertanyaan' => 'required',
                'jawaban' => 'required',
                'status_aktif' => 'required',
            ]);

            $pertanyaan->update([
                'provinsi_id' => $request['provinsi_id'],
                'pertanyaan' => $request['pertanyaan'],
                'status_aktif' => $request['provinsi_id'],
            ]);

            if ($pertanyaan->jawaban) {
                $pertanyaan->jawaban->update([
                    'jawaban' => $request['jawaban'],
                ]);
            } else {
                $pertanyaan->jawaban()->create([
                    'jawaban' => $request['jawaban'],
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 3)->find($id);

            if ($pertanyaan) {
                $pertanyaan->update([
                    'status' => 0,
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
