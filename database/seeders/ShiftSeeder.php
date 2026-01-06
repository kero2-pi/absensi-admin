<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Shift;

class ShiftSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $shifts = [
            [
                'nama_shift' => 'PAGI',
                'mulai' => '08:00',
                'selesai' => '16:00',
            ],
            [
                'nama_shift' => 'SIANG',
                'mulai' => '13:00',
                'selesai' => '21:00',
            ],
            [
                'nama_shift' => 'FULLTIME',
                'mulai' => '09:00',
                'selesai' => '17:00',
            ],
        ];

        foreach ($shifts as $shift) {
            Shift::updateOrCreate(
                ['nama_shift' => $shift['nama_shift']],
                $shift
            );
        }
    }
}
