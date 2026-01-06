@extends('layouts.app')

@section('content')
<div class="container">
    <h3 class="mb-4">Tambah User Baru</h3>

    <form action="{{ route('admin.users.store') }}" method="POST">
        @csrf

        {{-- Nama --}}
        <div class="mb-3">
            <label class="form-label">Nama</label>
            <input type="text" name="name" class="form-control" required>
        </div>

        {{-- Email --}}
        <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
        </div>

        {{-- Password --}}
        <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
        </div>

        {{-- Status --}}
        <div class="mb-3">
            <label class="form-label">Status</label>
            <select name="status" id="status" class="form-select">
                <option value="">-- Pilih Status --</option>
                <option value="PKL">PKL</option>
                <option value="KARYAWAN">Karyawan</option>
            </select>
        </div>

        {{-- Instansi --}}
        <div class="mb-3">
            <label class="form-label">Instansi</label>
            <select name="instansi" id="instansi" class="form-select">
                <option value="">-- Pilih Instansi --</option>
                @foreach ($instansi as $i)
                    <option value="{{ $i->nama_instansi }}">
                        {{ $i->nama_instansi }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- Mode Kerja --}}
        <div class="mb-3">
            <label class="form-label">Mode Kerja</label>
            <select name="mode_kerja" id="modeKerja" class="form-select">
                <option value="">-- Pilih Mode Kerja --</option>
                <option value="WFO">WFO</option>
                <option value="WFH">WFH</option>
            </select>
        </div>

        {{-- Shift --}}
        <div class="mb-4">
            <label class="form-label">Shift</label>
            <select name="shift_id" id="shift" class="form-select" required>
                <option value="">-- Pilih Shift --</option>
                @foreach ($shift as $s)
                    <option 
                        value="{{ $s->id }}"
                        data-nama="{{ $s->nama_shift }}"
                    >
                        {{ $s->nama_shift }} ({{ $s->mulai }} - {{ $s->selesai }})
                    </option>
                @endforeach
            </select>
        </div>

        {{-- BUTTON --}}
        <div class="d-flex justify-content-end">
            <button type="submit" class="btn btn-primary">
                💾 Simpan
            </button>
        </div>

    </form>
</div>
@endsection

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function () {
    const status     = document.getElementById('status');
    const instansi   = document.getElementById('instansi');
    const modeKerja  = document.getElementById('modeKerja');
    const shift      = document.getElementById('shift');

    function handleStatusChange() {
        if (status.value === 'KARYAWAN') {
            instansi.value = '';
            instansi.disabled = true;
        } else {
            instansi.disabled = false;
        }
    }

    function handleModeKerjaChange() {
        const options = shift.querySelectorAll('option');

        options.forEach(option => option.disabled = false);

        if (modeKerja.value === 'WFH') {
            options.forEach(option => {
                if (option.dataset.nama !== 'FULLTIME' && option.value !== '') {
                    option.disabled = true;
                }
            });

            const fulltime = [...options].find(
                opt => opt.dataset.nama === 'FULLTIME'
            );

            if (fulltime) {
                shift.value = fulltime.value;
                shift.disabled = true;
            }

        } else {
            shift.disabled = false;
            shift.value = '';
        }
    }

    status.addEventListener('change', handleStatusChange);
    modeKerja.addEventListener('change', handleModeKerjaChange);
});
</script>
@endsection
