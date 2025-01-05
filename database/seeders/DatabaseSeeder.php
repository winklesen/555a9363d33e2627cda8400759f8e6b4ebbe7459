<?php

namespace Database\Seeders;

use App\Models\Pendamping;
use App\Models\Peserta;
use App\Models\Provinsi;
use App\Models\Sekolah;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Admin',
                'email' => 'admin@mpr.com',
                'password' => bcrypt('admin123*'),
            ],
        ];

        User::insert($users);

        $provinsis = [
            [
                'nama_provinsi' => 'DKI Jakarta',
                'created_at' => now(),
            ],
        ];
        
        foreach ($provinsis as $p) {
            $provinsi = Provinsi::create($p);
        
            for ($i = 1; $i <= 9; $i++) {
                $sekolah = Sekolah::create([
                    'provinsi_id' => $provinsi->id,
                    'nama_sekolah' => 'SMAN ' . $i,
                    'created_at' => now(),
                ]);
        
                for ($j = 1; $j <= 10; $j++) {
                    Peserta::create([
                        'sekolah_id' => $sekolah->id,
                        'nomor_peserta' => $j,
                        'nama_peserta' => 'Peserta ' . $j . ' SMAN ' . $i,
                        'created_at' => now(),
                    ]);
                }
        
                Pendamping::create([
                    'sekolah_id' => $sekolah->id,
                    'nama_pendamping' => 'Pendamping SMAN ' . $i,
                    'created_at' => now(),
                ]);
            }
        }
    }
}
