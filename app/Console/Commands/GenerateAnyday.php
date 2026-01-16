<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\User;
use App\Models\Kehadiran;
use Carbon\Carbon;

class GenerateAnyday extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'kehadiran:generate-anyday {date?}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Generate kehadiran harian untuk semua user tanpa cek weekend dan hari libur';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        // Ambil tanggal target
        $tanggal = $this->argument('date')
            ? Carbon::parse($this->argument('date'))->toDateString()
            : Carbon::today()->toDateString();

        // Ambil semua user beserta shift
        $users = User::with('shift')->get();

        foreach ($users as $user) {
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

        $this->info("Kehadiran tanggal {$tanggal} berhasil digenerate (tanpa cek weekend/libur).");
        return Command::SUCCESS;
    }
}
