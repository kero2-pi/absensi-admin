<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Kehadiran;
use App\Models\Shift;
use Carbon\Carbon;

class GenerateDailyKehadiran extends Command
{
    protected $signature = 'kehadiran:generate {date?}';
    protected $description = 'Generate kehadiran harian berdasarkan shift';

    public function handle()
    {
        $tanggal = $this->argument('date')
            ? Carbon::parse($this->argument('date'))->toDateString()
            : Carbon::today()->toDateString();
    
    
        $users = User::with('shift')->get();
    
        foreach ($users as $user) {
        
            // ambil shift via relasi
            $shift = $user->shift;
        
            if (!$shift) {
                $this->error("User ID {$user->id} tidak memiliki shift");
                continue;
            }
        
            Kehadiran::firstOrCreate(
                [
                    'user_id' => $user->id,
                    'tanggal' => $tanggal,
                ],
                [
                    'shift' => $shift->nama_shift,
                    'jam_shift_masuk' => $shift->mulai,
                    'mode_kerja' => $user->mode_kerja,
                    'status' => 'ALPA',
                ]
            );
        }
    
        $this->info("Kehadiran {$tanggal} berhasil digenerate");
    }

}
