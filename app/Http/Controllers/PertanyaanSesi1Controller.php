<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use App\Models\Provinsi;
use App\Models\Pertanyaan;

use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PertanyaanSesi1Controller extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Pertanyaan::where('sesi', 1)->where('status', 1);

            if ($request->provinsi_id) {
                $data->where('provinsi_id', $request->provinsi_id);
            }

            if ($request->tema_id) {
                $data->where('tema_id', $request->tema_id);
            }

            $data = $data->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('provinsi', function ($row) {
                    return $row->provinsi->nama_provinsi;
                })
                ->addColumn('tema', function ($row) {
                    return $row->tema->tema;
                })
                ->addColumn('jawaban', function ($row) {
                    $html = '<div class="badges-list">';

                    foreach ($row->jawabans as $jawaban) {
                        $html .= '<span class="badge bg-success text-white">' . $jawaban->jawaban . '</span>';
                    }

                    $html .= '</div>';

                    return $html;
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
                    'jawaban',
                    'status_aktif',
                    'action',
                ])
                ->make(true);
        }

        $provinsis = Provinsi::where('status', 1)->get();
        $temas = Tema::where('sesi', 1)->where('status', 1)->get();
        $pertanyaans = Pertanyaan::where('sesi', 1)->where('status', 1)->orderBy('created_at', 'DESC')->get();
    
        return view('backend.pertanyaan-sesi-1', compact(
            'provinsis',
            'temas',
            'pertanyaans',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        try {
            $request->validate([
                'tema_id' => 'required',
                'pertanyaan' => 'required',
                'jawabans' => 'required|array|min:1',
                'jawabans.*' => 'required|string'
            ]);

            $tema = Tema::where('status', 1)->find($request['tema_id']);

            $pertanyaan = Pertanyaan::create([
                'provinsi_id' => $tema->provinsi_id,
                'tema_id' => $request['tema_id'],
                'pertanyaan' => $request['pertanyaan'],
                'sesi' => $tema->sesi,
            ]);

            foreach ($request->jawabans as $jawaban) {
                $pertanyaan->jawabans()->create([
                    'jawaban' => $jawaban
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id) {
        $pertanyaan = Pertanyaan::with('jawabans')->find($id);

        return response()->json($pertanyaan);
    }

    public function edit($id) {}

    public function update(Request $request, $id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 1)->find($id);

            $request->validate([
                'tema_id' => 'required',
                'pertanyaan' => 'required',
                'status_aktif' => 'required',
                'jawabans' => 'required|array|min:1',
                'jawabans.*' => 'required|string',
                'jawaban_ids' => 'required|array',
                'jawaban_ids.*' => 'nullable|exists:jawabans,id'
            ]);

            $tema = Tema::where('status', 1)->find($request['tema_id']);

            $pertanyaan->update([
                'provinsi_id' => $tema->provinsi_id,
                'tema_id' => $request['tema_id'],
                'pertanyaan' => $request['pertanyaan'],
                'sesi' => $tema->sesi,
                'status_aktif' => $request['status_aktif'],
            ]);

            if ($request->deleted_jawaban_ids) {
                $deletedIds = json_decode($request->deleted_jawaban_ids);
                if (!empty($deletedIds)) {
                    $pertanyaan->jawabans()
                        ->whereIn('id', $deletedIds)
                        ->delete();
                }
            }

            foreach ($request->jawabans as $index => $jawabanText) {
                $jawabanId = $request->jawaban_ids[$index] ?? null;
                
                if ($jawabanId) {
                    $pertanyaan->jawabans()
                        ->where('id', $jawabanId)
                        ->update(['jawaban' => $jawabanText]);
                } else {
                    $pertanyaan->jawabans()->create([
                        'jawaban' => $jawabanText
                    ]);
                }
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 1)->find($id);

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
