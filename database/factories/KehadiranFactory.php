<?php

namespace Database\Factories;

use App\Models\Kehadiran;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Carbon\Carbon;

use function Symfony\Component\Clock\now;

class KehadiranFactory extends Factory
{
    protected $model = Kehadiran::class;

    public function definition(): array
    {
        $user = User::with('shift')->random()->first();

        $jamShiftMasuk = Carbon::createFromFormat('H:i:s', $user->shift->mulai);

        // kemungkinan telat / tidak
        $isTelat = $this->faker->boolean(30); // 30% telat

        if ($isTelat) {
            $jamMasuk = (clone $jamShiftMasuk)->addMinutes(
                $this->faker->numberBetween(1, 30)
            );
        } else {
            $jamMasuk = (clone $jamShiftMasuk)->subMinutes(
                $this->faker->numberBetween(0, 10)
            );
        }

        $menitTelat = 0;
        if ($jamMasuk->gt($jamShiftMasuk)) {
            $menitTelat = $jamShiftMasuk->diffInMinutes($jamMasuk);
        }

        return [
            'user_id' => $user->id,
            'shift' => $user->shift->nama_shift,                // snapshot
            'jam_shift_masuk' => $jamShiftMasuk->format('H:i:s'),
            'jam_masuk' => $jamMasuk->format('H:i:s'),
            'mode_kerja' => $user->mode_kerja,
            'tanggal' => date('Y-m-d'),
            'terlambat' => $menitTelat > 0,
            'menit_telat' => $menitTelat,
        ];
    }
}
