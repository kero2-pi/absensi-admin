@extends('layouts.app')

@section('content')
<div class="container">

    {{-- HEADER --}}
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Data Shift Kerja</h3>
    </div>

    {{-- FLASH MESSAGE --}}
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    {{-- TABLE --}}
    <div class="card shadow-sm">
        <div class="card-body p-0">

            <table class="table table-bordered table-hover mb-0 align-middle">
                <thead class="table-light">
                    <tr>
                        <th width="50">#</th>
                        <th>Nama Shift</th>
                        <th>Jam Masuk</th>
                        <th>Jam Keluar</th>
                        <th width="100">Aksi</th>
                    </tr>
                </thead>

                <tbody>
                @forelse ($shifts as $shift)

                    <form method="POST"
                          action="{{ route('admin.settings.shifts.update', $shift) }}">
                        @csrf
                        @method('PATCH')

                        <tr>
                            <td>{{ $loop->iteration }}</td>

                            <td>
                                <input type="text"
                                       name="nama_shift"
                                       value="{{ $shift->nama_shift }}"
                                       class="form-control form-control-sm"
                                       required>
                            </td>

                            <td>
                                <input type="time"
                                       name="mulai"
                                       value="{{ $shift->mulai }}"
                                       class="form-control form-control-sm"
                                       required>
                            </td>

                            <td>
                                <input type="time"
                                       name="selesai"
                                       value="{{ $shift->selesai }}"
                                       class="form-control form-control-sm"
                                       required>
                            </td>

                            <td>
                                <button type="submit"
                                        class="btn btn-success btn-sm w-100">
                                    Simpan
                                </button>
                            </td>
                        </tr>
                    </form>

                @empty
                    <tr>
                        <td colspan="5" class="text-center text-muted py-3">
                            Belum ada data shift
                        </td>
                    </tr>
                @endforelse
                </tbody>

            </table>

        </div>
    </div>

    {{-- INFO --}}
    <div class="mt-3 text-muted small">
    </div>

</div>
@endsection
