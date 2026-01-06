<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithCustomStartCell;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class LaporanAbsensiExport implements
    FromCollection,
    WithHeadings,
    WithCustomStartCell,
    WithEvents
{
    protected $users;
    protected $awal;
    protected $akhir;
    protected $hariKerja;

    public function __construct($users, $awal, $akhir, $hariKerja)
    {
        $this->users = $users;
        $this->awal = $awal;
        $this->akhir = $akhir;
        $this->hariKerja = $hariKerja;
    }

    public function startCell(): string
    {
        return 'A4';
    }

    public function collection()
    {
        return $this->users->map(function ($user) {

            $h = fn($s) => $user->kehadiran->where('status',$s)->count();

            $hadir = $h('HADIR');
            $izin  = $h('IZIN');
            $cuti  = $h('CUTI');
            $sakit = $h('SAKIT');
            $alpa  = $h('ALPA');

            $wfo = $user->kehadiran->where('mode_kerja','WFO')->count();
            $wfh = $user->kehadiran->where('mode_kerja','WFH')->count();

            $pagi     = $user->kehadiran->where('shift','PAGI')->count();
            $siang    = $user->kehadiran->where('shift','SIANG')->count();
            $fulltime = $user->kehadiran->where('shift','FULLTIME')->count();

            $telat = $user->kehadiran->where('terlambat',true)->count();

            $totalValid = $hadir + $izin + $cuti + $sakit;

            $persen = $this->hariKerja > 0
                ? round(($totalValid / $this->hariKerja) * 100)
                : 0;

            return [
                $user->name,
                $wfo, $wfh,
                $pagi, $siang, $fulltime,
                $hadir, $izin, $cuti, $sakit, $alpa,
                $telat,
                $persen.'%'
            ];
        });
    }

    public function headings(): array
{
    return [
        [
            'Nama', 'WFO', 'WFH', 'Pagi', 'Siang', 'Fulltime',
            'Hadir', 'Izin', 'Cuti', 'Sakit', 'Alpa', 'Terlambat', '% Kehadiran'
        ]
    ];
}

public function registerEvents(): array
{
    return [
        AfterSheet::class => function (AfterSheet $event) {
            $event->sheet->setCellValue('A1', 'LAPORAN ABSENSI');
            $event->sheet->setCellValue('A2', "Periode: {$this->awal} s/d {$this->akhir} | Hari Kerja: {$this->hariKerja} hari");

            $event->sheet->mergeCells('A1:M1');
            $event->sheet->mergeCells('A2:M2');
        }
    ];
}

}
