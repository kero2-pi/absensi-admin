<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kehadiran;
use App\Models\Wajah;
use App\Services\FaceService;
use Carbon\Carbon;

class KehadiranController extends Controller
{
    public function absenMasuk(Request $request)
{
    $request->validate([
        'data' => ['required', 'array'],
        'mode_kerja' => ['nullable', 'in:WFO,WFH'],
    ]);

    $user = $request->user();
    $today = Carbon::today()->toDateString();
    $now = Carbon::now();

    // =========================
    // 1. VALIDASI WAJAH
    // =========================
    $wajah = Wajah::where('user_id', $user->id)->first();

    if (!$wajah) {
        return response()->json([
            'message' => 'Wajah belum terdaftar'
        ], 403);
    }

    $distance = FaceService::cosineDistance(
        $wajah->data,
        $request->data
    );

    $threshold = config('face.threshold', 0.4);

    if ($distance > $threshold) {
        return response()->json([
            'message' => 'Wajah tidak cocok'
        ], 403);
    }

    // =========================
    // 2. AMBIL DATA KEHADIRAN
    // =========================
    $kehadiran = Kehadiran::where('user_id', $user->id)
        ->where('tanggal', $today)
        ->first();

    if (!$kehadiran) {
        return response()->json([
            'message' => 'Data kehadiran hari ini belum dibuat'
        ], 404);
    }

    // =========================
    // 3. CEK STATUS IZIN
    // =========================
    if (in_array($kehadiran->status, ['IZIN', 'CUTI', 'SAKIT'])) {
        return response()->json([
            'message' => 'Sedang izin'
        ], 403);
    }

    // =========================
    // 4. CEK SUDAH ABSEN
    // =========================
    if ($kehadiran->jam_masuk) {
        return response()->json([
            'message' => 'Sudah absen masuk'
        ], 422);
    }

    // =========================
    // 5. HITUNG KETERLAMBATAN
    // =========================
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

    return response()->json([
        'message' => 'Absen masuk berhasil'
    ]);
}


    public function index(Request $request)
    {
        $user = $request->user();

        // parameter bulan & tahun (opsional)
        $bulan = $request->query('bulan', now()->month); // 1-12
        $tahun = $request->query('tahun', now()->year);

        $startDate = Carbon::create($tahun, $bulan, 1)->startOfMonth();
        $endDate   = Carbon::create($tahun, $bulan, 1)->endOfMonth();

        $kehadiran = Kehadiran::where('user_id', $user->id)
            ->whereBetween('tanggal', [$startDate, $endDate])
            ->orderBy('tanggal', 'asc')
            ->paginate(10); // pagination per bulan

        return response()->json([
            'meta' => [
                'bulan' => (int) $bulan,
                'tahun' => (int) $tahun,
            ],
            'data' => $kehadiran
        ]);
    }
}
