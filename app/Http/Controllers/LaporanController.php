<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\LaporanAbsensiExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        $tanggalAwal  = $request->tanggal_awal
            ?? Carbon::now()->startOfMonth()->toDateString();

        $tanggalAkhir = $request->tanggal_akhir
            ?? Carbon::now()->endOfMonth()->toDateString();

        $hariKerja = $this->hitungHariKerja($tanggalAwal, $tanggalAkhir);

        $users = User::with([
            'kehadiran' => function ($q) use ($tanggalAwal, $tanggalAkhir) {
                $q->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
            }
        ])
        ->when($request->filled('status'), fn ($q) =>
            $q->where('status', $request->status)
        )
        ->get();

        return view('laporan', compact(
            'users',
            'tanggalAwal',
            'tanggalAkhir',
            'hariKerja'
        ));
    }

    public function export(Request $request)
    {
        $tanggalAwal  = $request->tanggal_awal
            ?? Carbon::now()->startOfMonth()->toDateString();

        $tanggalAkhir = $request->tanggal_akhir
            ?? Carbon::now()->endOfMonth()->toDateString();

        $hariKerja = $this->hitungHariKerja($tanggalAwal, $tanggalAkhir);

        $now = now()->format('Ymd_His');

        $users = User::where(function($q) use ($request) {
    if ($request->filled('status')) {
        $q->where('status', $request->status);
    }
})
->with(['kehadiran' => function($q) use ($tanggalAwal, $tanggalAkhir) {
    $q->whereBetween('tanggal', [$tanggalAwal, $tanggalAkhir]);
}])
->get();


        // PDF
        if ($request->input('format') === 'pdf') {
            $pdf = Pdf::loadView(
                'laporan.absensi',
                compact('users','tanggalAwal','tanggalAkhir','hariKerja')
            )->setPaper('a4', 'landscape');

            return $pdf->download("laporan-absensi_{$now}.pdf");
        }

        // EXCEL
        return Excel::download(
            new LaporanAbsensiExport(
                $users,
                $tanggalAwal,
                $tanggalAkhir,
                $hariKerja
            ),
            "laporan-absensi_{$now}.xlsx"
        );
    }

    private function hitungHariKerja($awal, $akhir)
    {
        $start = Carbon::parse($awal);
        $end   = Carbon::parse($akhir);

        $hari = 0;
        while ($start <= $end) {
            if (!$start->isWeekend()) {
                $hari++;
            }
            $start->addDay();
        }
        return $hari;
    }
}
