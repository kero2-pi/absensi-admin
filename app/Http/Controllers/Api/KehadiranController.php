<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    public function absenMasuk(Request $request)
    {
        $user = $request->user();
        $today = Carbon::today()->toDateString();
        $now = Carbon::now();

        $kehadiran = Kehadiran::where('user_id', $user->id)
            ->where('tanggal', $today)
            ->firstOrFail();

        if (in_array($kehadiran->status, ['IZIN', 'CUTI', 'SAKIT'])) {
            return response()->json(['message' => 'Sedang izin'], 403);
        }

        if ($kehadiran->jam_masuk) {
            return response()->json(['message' => 'Sudah absen masuk'], 422);
        }


        $jamShift = Carbon::createFromFormat('H:i:s', $kehadiran->jam_shift_masuk);
        $terlambat = $now->gt($jamShift);

        $kehadiran->update([
            'jam_masuk' => $now->format('H:i:s'),
            'status' => 'HADIR',
            'mode_kerja' => $request->mode_kerja ?? 'WFO',
            'terlambat' => $terlambat,
            'keterlambatan' => $terlambat
                ? gmdate('H:i:s', $jamShift->diffInSeconds($now))
                : null,
        ]);

        return response()->json(['message' => 'Absen masuk berhasil']);
    }
}
