@extends('layouts.app')

@section('content')
<div class="container">

    <h3 class="mb-4">Laporan Absensi</h3>

    {{-- FILTER --}}
<form method="GET" action="{{ route('admin.laporan.index') }}" class="row g-3 mb-4">

    <div class="col-md-3">
        <label class="form-label">Status User</label>
        <select name="status" class="form-select">
            <option value="">-- Semua --</option>
            <option value="PKL" @selected(request('status')=='PKL')>PKL</option>
            <option value="KARYAWAN" @selected(request('status')=='KARYAWAN')>Karyawan</option>
        </select>
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Awal</label>
        <input type="date" name="tanggal_awal" class="form-control"
               value="{{ $tanggalAwal }}">
    </div>

    <div class="col-md-3">
        <label class="form-label">Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" class="form-control"
               value="{{ $tanggalAkhir }}">
    </div>

    <div class="col-md-3 d-flex align-items-end">
        <button class="btn btn-primary w-100">🔍 Filter</button>
    </div>
</form>


    {{-- INFO --}}
    <div class="alert alert-info mb-3">
        <strong>Periode:</strong> {{ $tanggalAwal }} s/d {{ $tanggalAkhir }} |
        <strong>Hari Kerja:</strong> {{ $hariKerja }} hari
    </div>

    {{-- EXPORT --}}
    <div class="mb-4">
    <form method="POST" action="{{ route('admin.laporan.export') }}" class="d-inline">
        @csrf
        <input type="hidden" name="format" value="pdf">
        <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
        <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <button class="btn btn-danger btn-sm">Export PDF</button>
    </form>

    <form method="POST" action="{{ route('admin.laporan.export') }}" class="d-inline ms-2">
        @csrf
        <input type="hidden" name="format" value="excel">
        <input type="hidden" name="tanggal_awal" value="{{ $tanggalAwal }}">
        <input type="hidden" name="tanggal_akhir" value="{{ $tanggalAkhir }}">
        <input type="hidden" name="status" value="{{ request('status') }}">
        <button class="btn btn-success btn-sm">Export Excel</button>
    </form>
</div>





    {{-- TABLE --}}
    <div class="table-responsive">
    <table class="table table-bordered table-sm align-middle text-center">
        <thead class="table-dark text-center align-middle">
<tr>
    <th rowspan="2">Nama</th>
    <th rowspan="2">Status User</th>

    <th colspan="2">Mode Kerja</th>

    <th colspan="3">Shift</th>

    <th colspan="5">Status Kehadiran</th>

    <th rowspan="2">Terlambat</th>
    <th rowspan="2">Kehadiran</th>
</tr>
<tr>
    {{-- Mode Kerja --}}
    <th>WFO</th>
    <th>WFH</th>

    {{-- Shift --}}
    <th>Pagi</th>
    <th>Siang</th>
    <th>Fulltime</th>

    {{-- Status Kehadiran --}}
    <th>Hadir</th>
    <th>Izin</th>
    <th>Cuti</th>
    <th>Sakit</th>
    <th>Alpa</th>
</tr>
</thead>



        <tbody>
@forelse ($users as $user)
@php
    // STATUS
    $hadir = $user->kehadiran->where('status','HADIR')->count();
    $izin  = $user->kehadiran->where('status','IZIN')->count();
    $cuti  = $user->kehadiran->where('status','CUTI')->count();
    $sakit = $user->kehadiran->where('status','SAKIT')->count();
    $alpa  = $user->kehadiran->where('status','ALPA')->count();

    // TERLAMBAT
    $telat = $user->kehadiran->where('terlambat', true)->count();

    // SHIFT
    $pagi     = $user->kehadiran->where('shift','PAGI')->count();
    $siang    = $user->kehadiran->where('shift','SIANG')->count();
    $fulltime = $user->kehadiran->where('shift','FULLTIME')->count();

    // MODE KERJA
    $wfo = $user->kehadiran->where('mode_kerja','WFO')->count();
    $wfh = $user->kehadiran->where('mode_kerja','WFH')->count();

    // PERSENTASE
    $totalHadirValid = $hadir + $izin + $cuti + $sakit;

$persentase = $hariKerja > 0
    ? round(($totalHadirValid / $hariKerja) * 100)
    : 0;

@endphp

<tr class="text-center">
    <td class="text-start">{{ $user->name }}</td>
    <td>{{ $user->status }}</td>

    {{-- Mode Kerja --}}
    <td>{{ $wfo }}</td>
    <td>{{ $wfh }}</td>

    {{-- Shift --}}
    <td>{{ $pagi }}</td>
    <td>{{ $siang }}</td>
    <td>{{ $fulltime }}</td>

    {{-- Status Kehadiran --}}
    <td>{{ $hadir }}</td>
    <td>{{ $izin }}</td>
    <td>{{ $cuti }}</td>
    <td>{{ $sakit }}</td>
    <td>{{ $alpa }}</td>

    {{-- Terlambat --}}
    <td>{{ $telat }}</td>

    {{-- Kehadiran --}}
    <td>
        <span class="badge bg-{{ $persentase >= 90 ? 'success' : ($persentase >= 75 ? 'warning' : 'danger') }}">
            {{ $persentase }}%
        </span>
    </td>
</tr>

@empty
<tr>
    <td colspan="14" class="text-muted text-center">
        Tidak ada data
    </td>
</tr>
@endforelse
</tbody>


    </table>
    </div>

</div>
@endsection
