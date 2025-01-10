<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ChartController extends Controller
{
    public function penyisihan() {
        $point = [
            'Sekolah 1' => ['point' => 10, 'bobot_point' => 20],
            'Sekolah 2' => ['point' => 15, 'bobot_point' => 30],
            'Sekolah 3' => ['point' => 12, 'bobot_point' => 25],
            'Sekolah 4' => ['point' => 14, 'bobot_point' => 28],
            'Sekolah 5' => ['point' => 16, 'bobot_point' => 32],
            'Sekolah 6' => ['point' => 18, 'bobot_point' => 36],
            'Sekolah 7' => ['point' => 20, 'bobot_point' => 40],
            'Sekolah 8' => ['point' => 22, 'bobot_point' => 44],
            'Sekolah 9' => ['point' => 24, 'bobot_point' => 48],
        ];
    
        $data = [
            'name' => "Final Sekolah 1",
            'info' => "Point : (point) / Bobot : (bobot_point)",
            'children' => [
                [
                    'name' => "Semi Final Sekolah 1",
                    'info' => "Point : " . $point['Sekolah 1']['point'] . " / Bobot : " . $point['Sekolah 1']['bobot_point'],
                    'children' => [
                        ['name' => "Penyisihan Sekolah 1", 'info' => "Point : " . $point['Sekolah 1']['point'] . " / Bobot : " . $point['Sekolah 1']['bobot_point']],
                        ['name' => "Penyisihan Sekolah 2", 'info' => "Point : " . $point['Sekolah 2']['point'] . " / Bobot : " . $point['Sekolah 2']['bobot_point']],
                        ['name' => "Penyisihan Sekolah 3", 'info' => "Point : " . $point['Sekolah 3']['point'] . " / Bobot : " . $point['Sekolah 3']['bobot_point']],
                    ]
                ],
                [
                    'name' => "Semi Final Sekolah 5",
                    'info' => "Point : " . $point['Sekolah 5']['point'] . " / Bobot : " . $point['Sekolah 5']['bobot_point'],
                    'children' => [
                        ['name' => "Penyisihan Sekolah 4", 'info' => "Point : " . $point['Sekolah 4']['point'] . " / Bobot : " . $point['Sekolah 4']['bobot_point']],
                        ['name' => "Penyisihan Sekolah 5", 'info' => "Point : " . $point['Sekolah 5']['point'] . " / Bobot : " . $point['Sekolah 5']['bobot_point']],
                        ['name' => "Penyisihan Sekolah 6", 'info' => "Point : " . $point['Sekolah 6']['point'] . " / Bobot : " . $point['Sekolah 6']['bobot_point']],
                    ]
                ],
                [
                    'name' => "Semi Final Sekolah 9",
                    'info' => "Point : " . $point['Sekolah 9']['point'] . " / Bobot : " . $point['Sekolah 9']['bobot_point'],
                    'children' => [
                        ['name' => "Penyisihan Sekolah 7", 'info' => "Point : " . $point['Sekolah 7']['point'] . " / Bobot : " . $point['Sekolah 7']['bobot_point']],
                        ['name' => "Penyisihan Sekolah 8", 'info' => "Point : " . $point['Sekolah 8']['point'] . " / Bobot : " . $point['Sekolah 8']['bobot_point']],
                        ['name' => "Penyisihan Sekolah 9", 'info' => "Point : " . $point['Sekolah 9']['point'] . " / Bobot : " . $point['Sekolah 9']['bobot_point']],
                    ]
                ],
            ]
        ];
    
        return view('charts.penyisihan', compact('data'));
    }
}
