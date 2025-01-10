<?php

namespace App\Http\Controllers;

use App\Models\Tema;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class TemaController extends Controller
{
    public function index(Request $request, $provinsiId) {
        if ($request->ajax()) {
            $data = Tema::where('provinsi_id', $provinsiId)->orderBy('created_at', 'DESC');
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $html = '<div class="btn-list">';
                    $html .= '<a href="' . route('admin.provinsi.sesi-1.tema.pertanyaan.index', ['provinsiId' => $row->provinsi->id, 'temaId' => $row->id]) . '" class="btn btn-success">Pertanyaan</a>';
                    $html .= '<button class="btn btn-primary edit" data-id="' . $row->id . '">Edit</button>';
                    $html .= '<button class="btn btn-danger delete" data-id="' . $row->id . '">Hapus</button>';
                    $html .= '</div>';

                    return $html;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        $provinsi = Provinsi::find($provinsiId);
        $temas = Tema::where('provinsi_id', $provinsiId)->orderBy('created_at', 'DESC')->get();
    
        return view('admin.tema', compact(
            'provinsi',
            'temas',
        ));
    }

    public function create($provinsiId) {}

    public function store(Request $request, $provinsiId) {
        try {
            $request->validate([
                'tema' => 'required',
            ]);

            Tema::create([
                'provinsi_id' => $provinsiId,
                'tema' => $request['tema'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($provinsiId, $id) {
        $tema = Tema::find($id);
        
        return response()->json($tema);
    }

    public function edit($provinsiId, $id) {}

    public function update(Request $request, $provinsiId, $id) {
        try {
            $tema = Tema::find($id);

            $request->validate([
                'tema' => 'required',
            ]);

            $tema->update([
                'tema' => $request['tema'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($provinsiId, $id) {
        try {
            $tema = Tema::find($id);

            if ($tema) {
                $tema->delete();
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
