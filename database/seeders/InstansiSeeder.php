<?php

namespace Database\Seeders;

use App\Models\Instansi;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class InstansiSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $instansi = [
            [
                'nama_instansi' => 'SKMN 1'
            ],
            [
                'nama_instansi' => 'SMKN 2'
            ],
            [
                'nama_instansi' => 'SMKN 3'
            ]
            
        ];

        foreach ($instansi as $i) {
            Instansi::updateOrCreate(
                ['nama_instansi' => $i['nama_instansi']],
                $i
            );
        }
    }
}
