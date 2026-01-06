@extends('layouts.app')

@section('content')
<div class="container">
    <h3>Kelola Data Libur</h3>

    {{-- Form Tambah / Edit --}}
    <div class="card mb-4 p-3">
        <h5>{{ isset($editLibur) ? 'Edit Libur' : 'Tambah Libur Baru' }}</h5>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ isset($editLibur) ? route('libur.update', $editLibur->id) : route('libur.store') }}" method="POST">
            @csrf
            @if(isset($editLibur))
                @method('PUT')
            @endif

            <div class="mb-3">
                <label for="tanggal" class="form-label">Tanggal Libur</label>
                <input type="date" name="tanggal" id="tanggal" class="form-control" 
                       value="{{ old('tanggal', $editLibur->tanggal ?? '') }}" required>
            </div>

            <div class="mb-3">
                <label for="keterangan" class="form-label">Keterangan</label>
                <input type="text" name="keterangan" id="keterangan" class="form-control" 
                       value="{{ old('keterangan', $editLibur->keterangan ?? '') }}" 
                       placeholder="Misal: Hari Raya Nyepi">
            </div>

            <button type="submit" class="btn btn-primary">{{ isset($editLibur) ? 'Update' : 'Simpan' }}</button>

            @if(isset($editLibur))
                <a href="{{ route('libur.manage') }}" class="btn btn-secondary">Batal</a>
            @endif
        </form>
    </div>

    {{-- Tabel Data Libur --}}
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Tanggal</th>
                <th>Keterangan</th>
                <th>Dibuat</th>
                <th>Aksi</th>
            </tr>
        </thead>
        <tbody>
            @forelse ($libur as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ \Carbon\Carbon::parse($item->tanggal)->format('d-m-Y') }}</td>
                    <td>{{ $item->keterangan ?? '-' }}</td>
                    <td>{{ $item->created_at->format('d-m-Y H:i') }}</td>
                    <td>
                        {{-- Tombol Edit --}}
                        <a href="{{ route('libur.manage', $item->id) }}" class="btn btn-sm btn-warning">Edit</a>

                        {{-- Tombol Hapus --}}
                        <form action="{{ route('libur.destroy', $item->id) }}" method="POST" class="d-inline" 
                              onsubmit="return confirm('Yakin ingin menghapus?')">
                            @csrf
                            @method('DELETE')
                            <button class="btn btn-sm btn-danger">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="5" class="text-center">Belum ada data libur.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
