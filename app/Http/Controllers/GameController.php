<?php

namespace App\Http\Controllers;

use App\Models\Game;
use App\Models\Point;
use App\Models\Sekolah;
use App\Models\Provinsi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class GameController extends Controller
{
    public function index(Request $request) {
        if ($request->ajax()) {
            $data = Game::where('status', 1);

            if (Auth::user()->provinsi_id !== null) {
                $data->where('provinsi_id', Auth::user()->provinsi_id);
            }

            if ($request->provinsi_id) {
                $data->where('provinsi_id', $request->provinsi_id);
            }

            $data = $data->orderBy('created_at', 'DESC');

            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('provinsi', function ($row) {
                    return $row->provinsi->nama_provinsi;
                })
                ->addColumn('game', function ($row) {
                    return 'Game ' . $row->game;
                })
                ->addColumn('sekolahs', function ($row) {
                    $html = '<div class="badges-list">';

                    foreach ($row->sekolahs as $sekolah) {
                        $html .= '<span class="badge bg-success text-white">' . $sekolah->nama_sekolah . '</span>';
                    }

                    $html .= '</div>';

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
                    'sekolahs',
                    'action',
                ])
                ->make(true);
        }

        $provinsis = Provinsi::where('status', 1)
            ->when(Auth::user()->provinsi_id, function ($query, $provinsiId) {
                return $query->where('id', $provinsiId);
            })
            ->get();
        $sekolahs = Sekolah::where('status', 1)
            ->when(Auth::user()->provinsi_id, function ($query, $provinsiId) {
                return $query->where('provinsi_id', $provinsiId);
            })
            ->get();
        $games = Game::where('status', 1)
            ->when(Auth::user()->provinsi_id, function ($query, $provinsiId) {
                return $query->where('provinsi_id', $provinsiId);
            })
            ->get();
    
        return view('backend.game', compact(
            'provinsis',
            'sekolahs',
            'games',
        ));
    }

    public function create() {}

    public function store(Request $request) {
        try {
            $request->validate([
                'provinsi_id' => 'required',
                'group_a' => 'required|exists:sekolahs,id',
                'group_b' => 'required|exists:sekolahs,id',
                'group_c' => 'required|exists:sekolahs,id',
            ]);

            $existingGames = Game::where('provinsi_id', $request->provinsi_id)->pluck('game')->toArray();

            $gameNumber = 1;
            while (in_array($gameNumber, $existingGames)) {
                $gameNumber++;
            }

            $game = Game::create([
                'provinsi_id' => $request['provinsi_id'],
                'game' => $gameNumber,
            ]);

            $groups = [
                'a' => $request['group_a'],
                'b' => $request['group_b'],
                'c' => $request['group_c'],
            ];
    
            foreach ($groups as $group => $sekolahId) {
                Point::create([
                    'game_id' => $game->id,
                    'sekolah_id' => $sekolahId,
                    'group' => $group,
                ]);
            }

            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function show($id) {
        $game = Game::find($id);
        
        $points = $game->points->groupBy('group');

        return response()->json([
            'provinsi_id' => $game->provinsi_id,
            'group_a' => $points->get('a')->first()->sekolah_id ?? null,
            'group_b' => $points->get('b')->first()->sekolah_id ?? null,
            'group_c' => $points->get('c')->first()->sekolah_id ?? null,
        ]);
    }

    public function edit($id) {}

    public function update(Request $request, $id) {
        try {
            $game = Game::find($id);

            $request->validate([
                'provinsi_id' => 'required',
                'group_a' => 'required|exists:sekolahs,id',
                'group_b' => 'required|exists:sekolahs,id',
                'group_c' => 'required|exists:sekolahs,id',
            ]);

            $game->update([
                'provinsi_id' => $request['provinsi_id'],
                'game' => $request['game'],
            ]);

            $points = [
                'a' => $request['group_a'],
                'b' => $request['group_b'],
                'c' => $request['group_c'],
            ];
    
            foreach ($points as $group => $sekolahId) {
                Point::updateOrCreate(
                    [
                        'game_id' => $game->id,
                        'group' => $group
                    ],
                    [
                        'sekolah_id' => $sekolahId
                    ]
                );
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }

    public function destroy($id) {
        try {
            $game = Game::find($id);

            if ($game) {
                $game->update([
                    'status' => 0,
                ]);
            }
    
            return response()->json(['success' => true]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json(['errors' => $e->errors()], 422);
        }
    }
}
