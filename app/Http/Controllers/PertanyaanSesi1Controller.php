<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use App\Models\Pertanyaan;
use Illuminate\Http\Request;

use Yajra\DataTables\Facades\DataTables;

class PertanyaanSesi1Controller extends Controller
{
    public function index(Request $request, $provinsiId, $temaId) {
        if ($request->ajax()) {
            $data = Pertanyaan::where('tema_id', $temaId)->where('sesi', 1)->orderBy('created_at', 'DESC');
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

        $tema = Tema::find($temaId);
        $pertanyaans = Pertanyaan::where('tema_id', $temaId)->where('sesi', 1)->orderBy('created_at', 'DESC')->get();
    
        return view('admin.pertanyaan-sesi-1', compact(
            'tema',
            'pertanyaans',
        ));
    }

    public function create($provinsiId, $temaId) {}

    public function store(Request $request, $provinsiId, $temaId) {
        try {
            $request->validate([
                'pertanyaan' => 'required',
                'jawabans' => 'required|array|min:1',
                'jawabans.*' => 'required|string'
            ]);

            $pertanyaan = Pertanyaan::create([
                'tema_id' => $temaId,
                'pertanyaan' => $request['pertanyaan'],
                'sesi' => 1,
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

    public function show($provinsiId, $temaId, $id) {
        $pertanyaan = Pertanyaan::with('jawabans')->find($id);

        return response()->json($pertanyaan);
    }

    public function edit($provinsiId, $temaId, $id) {}

    public function update(Request $request, $provinsiId, $temaId, $id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 1)->find($id);

            $request->validate([
                'pertanyaan' => 'required',
                'jawabans' => 'required|array|min:1',
                'jawabans.*' => 'required|string',
                'jawaban_ids' => 'required|array',
                'jawaban_ids.*' => 'nullable|exists:jawabans,id'
            ]);

            $pertanyaan->update([
                'pertanyaan' => $request['pertanyaan'],
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

    public function destroy($provinsiId, $temaId, $id) {
        try {
            $pertanyaan = Pertanyaan::where('sesi', 1)->find($id);

            if ($pertanyaan) {
                $pertanyaan->delete();
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
