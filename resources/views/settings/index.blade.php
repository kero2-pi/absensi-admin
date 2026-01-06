@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Pengaturan Sistem</h3>

    <div class="row g-4">

        {{-- ===== HARI LIBUR ===== --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="fs-1 mb-2"></div>
                    <h5>Hari Libur</h5>
                    <p class="text-muted small">
                        Kelola tanggal merah & hari libur nasional
                    </p>
                    <a href="{{ route('libur.manage') }}"
                       class="btn btn-outline-primary w-100">
                        Kelola
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== SHIFT ===== --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100">
                <div class="card-body text-center">
                    <div class="fs-1 mb-2"></div>
                    <h5>Shift Kerja</h5>
                    <p class="text-muted small">
                        Atur jam masuk & jam keluar shift
                    </p>
                    <a href="{{ route('admin.shifts') }}"
                       class="btn btn-outline-primary w-100">
                        Kelola
                    </a>
                </div>
            </div>
        </div>

        {{-- ===== FITUR LAIN ===== --}}
        <div class="col-md-4">
            <div class="card shadow-sm h-100 border-dashed">
                <div class="card-body text-center text-muted">
                    <div class="fs-1 mb-2">lainnya</div>
                    <h6>Fitur Lainnya</h6>
                    <small>Kalo Ada</small>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection
