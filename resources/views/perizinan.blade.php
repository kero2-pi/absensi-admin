@extends('layouts.app')

@section('content')
<div class="container-fluid">

    <h4 class="mb-3">Approval Perizinan</h4>

    @if (session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <div class="card">
        <div class="card-body p-0">

            <table class="table table-striped mb-0 align-middle">
                <thead class="table-dark">
                    <tr>
                        <th>No</th>
                        <th>Nama User</th>
                        <th>Jenis</th>
                        <th>Tanggal Mulai</th>
                        <th>Tanggal Selesai</th>
                        <th>Keterangan</th>
                        <th>Lampiran</th>
                        <th class="text-center">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                    @forelse ($perizinan as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->user->name ?? '-' }}</td>
                            <td>
                                <span class="badge bg-info">
                                    {{ $item->jenis }}
                                </span>
                            </td>
                            <td>{{ $item->tanggal_mulai }}</td>
                            <td>{{ $item->tanggal_selesai }}</td>
                            <td>{{ $item->keterangan ?? '-' }}</td>
                            <td>
                                @if ($item->lampiran)
                                    <a href="{{ asset('storage/' . $item->lampiran) }}"
                                       target="_blank"
                                       class="btn btn-sm btn-outline-primary">
                                        Lihat
                                    </a>
                                @else
                                    -
                                @endif
                            </td>
                            <td class="text-center">

                                {{-- SETUJUI --}}
                                <form action="{{ route('admin.perizinan.approve', $item->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-success"
                                            onclick="return confirm('Setujui perizinan ini?')">
                                        ✔ Setujui
                                    </button>
                                </form>

                                {{-- TOLAK --}}
                                <form action="{{ route('admin.perizinan.reject', $item->id) }}"
                                      method="POST"
                                      class="d-inline">
                                    @csrf
                                    <button class="btn btn-sm btn-danger"
                                            onclick="return confirm('Tolak perizinan ini?')">
                                        ✖ Tolak
                                    </button>
                                </form>

                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-muted py-4">
                                Tidak ada perizinan menunggu persetujuan
                            </td>
                        </tr>
                    @endforelse
                </tbody>

            </table>

        </div>
    </div>

</div>
@endsection
