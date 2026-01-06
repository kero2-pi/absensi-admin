<?php

namespace Database\Seeders;

use App\Models\Instansi;
use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Support\Facades\DB;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            ShiftSeeder::class,
            InstansiSeeder::class
        ]);
        // User::factory()->count(20)->create();
        //Kehadiran::factory()->count(20)->create();
    }
}
