<!DOCTYPE html>
<html>
<head>
    <style>
        body { font-size: 10px; }
        table { width: 100%; border-collapse: collapse; }
        th, td {
            border: 1px solid #000;
            padding: 4px;
            text-align: center;
        }
        th { background: #eee; }
    </style>
</head>
<body>

<h3>Laporan Absensi</h3>
<p>
    Periode: {{ $tanggalAwal }} s/d {{ $tanggalAkhir }} |
    Hari Kerja: {{ $hariKerja }} hari
</p>

<table>
<thead>
<tr>
    <th>Nama</th>
    <th>WFO</th><th>WFH</th>
    <th>Pagi</th><th>Siang</th><th>Fulltime</th>
    <th>Hadir</th><th>Izin</th><th>Cuti</th><th>Sakit</th><th>Alpa</th>
    <th>Terlambat</th>
    <th>Kehadiran</th>
</tr>
</thead>
<tbody>
@foreach($users as $user)
@php
    $h = fn($s) => $user->kehadiran->where('status',$s)->count();
    $total = $h('HADIR') + $h('IZIN') + $h('CUTI') + $h('SAKIT');
    $persen = $hariKerja > 0 ? round(($total/$hariKerja)*100) : 0;
@endphp
<tr>
    <td>{{ $user->name }}</td>
    <td>{{ $user->kehadiran->where('mode_kerja','WFO')->count() }}</td>
    <td>{{ $user->kehadiran->where('mode_kerja','WFH')->count() }}</td>
    <td>{{ $user->kehadiran->where('shift','PAGI')->count() }}</td>
    <td>{{ $user->kehadiran->where('shift','SIANG')->count() }}</td>
    <td>{{ $user->kehadiran->where('shift','FULLTIME')->count() }}</td>
    <td>{{ $h('HADIR') }}</td>
    <td>{{ $h('IZIN') }}</td>
    <td>{{ $h('CUTI') }}</td>
    <td>{{ $h('SAKIT') }}</td>
    <td>{{ $h('ALPA') }}</td>
    <td>{{ $user->kehadiran->where('terlambat',true)->count() }}</td>
    <td>{{ $persen }}%</td>
</tr>
@endforeach
</tbody>
</table>

</body>
</html>
