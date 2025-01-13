<?php

namespace App\Http\Controllers;

use App\Models\Sekolah;
use App\Models\Pendamping;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class PendampingController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Pendamping::where('status', 1);

            if ($request->sekolah_id) {
                $data->where('sekolah_id', $request->sekolah_id);
            }

            $data = $data->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('sekolah', function ($row) {
                    return $row->sekolah->nama_sekolah;
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

        $sekolahs = Sekolah::where('status', 1)->get();
        $pendampings = Pendamping::where('status', 1)->orderBy('created_at', 'DESC')->get();
    
        return view('backend.pendamping', compact(
            'sekolahs',
            'pendampings',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        try {
            $request->validate([
                'sekolah_id' => 'required',
                'nama_pendamping' => 'required',
            ]);

            Pendamping::create([
                'sekolah_id' => $request['sekolah_id'],
                'nama_pendamping' => $request['nama_pendamping'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id) {
        $pendamping = Pendamping::find($id);

        return response()->json($pendamping);
    }

    public function edit($id) {}

    public function update(Request $request, $id) {
        try {
            $pendamping = Pendamping::find($id);

            $request->validate([
                'sekolah_id' => 'required',
                'nama_pendamping' => 'required',
            ]);

            $pendamping->update([
                'sekolah_id' => $request['sekolah_id'],
                'nama_pendamping' => $request['nama_pendamping'],
            ]);
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id) {
        try {
            $pendamping = Pendamping::find($id);

            if ($pendamping) {
                $pendamping->update([
                    'status' => 0,
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
