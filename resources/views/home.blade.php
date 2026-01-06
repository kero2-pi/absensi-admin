@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-2">Dashboard Absensi</h3>
    <p class="text-muted">Tanggal: <strong>{{ $tanggal }}</strong></p>

    @forelse ($users as $shift => $list)
        <div class="card mb-4">
            <div class="card-header bg-dark text-white">
                Shift: {{ $shift }}
            </div>

            <div class="card-body p-0">
                <table class="table table-bordered table-hover mb-0">
                    <thead class="table-light">
                        <tr>
                            <th>Nama</th>
                            <th>Jam Masuk</th>
                            <th>Status</th>
                            <th>Keterlambatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($list as $user)
                            @php
                                $hadir = $user->kehadiran->first();

                                if (!$hadir) {
                                    // seharusnya jarang terjadi kalau sudah di-generate
                                    $rowClass = 'table-secondary';
                                    $statusText = 'Belum Digenerate';
                                    $statusBadge = 'secondary';
                                    $jamMasuk = '-';
                                    $keterlambatan = '-';
                                } else {
                                    $status = $hadir->status;

                                    switch ($status) {
                                        case 'ALPA':
                                            $rowClass = 'table-danger';
                                            $statusBadge = 'danger';
                                            break;

                                        case 'IZIN':
                                        case 'SAKIT':
                                        case 'CUTI':
                                            $rowClass = 'table-warning';
                                            $statusBadge = 'warning';
                                            break;

                                        case 'HADIR':
                                        default:
                                            $rowClass = 'table-success';
                                            $statusBadge = 'success';
                                            break;
                                    }

                                    $statusText = $status;
                                    $jamMasuk = $hadir->jam_masuk ?? '-';
                                    $keterlambatan = $hadir->menit_telat
                                        ? $hadir->menit_telat . ' menit'
                                        : '-';
                                }
                            @endphp

                            <tr class="{{ $rowClass }}">
                                <td>{{ $user->name }}</td>
                                <td>{{ $jamMasuk }}</td>
                                <td>
                                    <span class="badge bg-{{ $statusBadge }}">
                                        {{ $statusText }}
                                    </span>
                                </td>
                                <td>{{ $keterlambatan }}</td>
                            </tr>

                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @empty
        <div class="alert alert-warning">
            Tidak ada data user.
        </div>
    @endforelse
</div>
@endsection
