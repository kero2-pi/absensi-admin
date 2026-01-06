@extends('layouts.app')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h3>Daftar User</h3>
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary">
            Tambah User
        </a>
    </div>

    {{-- LIVE SEARCH --}}
    <div class="mb-3">
        <input type="text"
               id="search"
               class="form-control"
               placeholder="Cari ID / Nama / Email">
    </div>

    {{-- TABLE --}}
    <div class="table-responsive">
        <table class="table table-bordered table-hover align-middle">
            <thead class="table-light">
                <tr>
                    <th>#</th>
                    <th>Nama</th>
                    <th>Email</th>
                    <th>Status</th>
                    <th>Mode Kerja</th>
                    <th>Instansi</th>
                    <th>Shift</th>
                </tr>
            </thead>

            <tbody id="user-table">
    @include('users.table_rows', ['users' => $users])
</tbody>


        </table>
    </div>
</div>
@endsection

@section('scripts')
<script>
let timer;
const input = document.getElementById('search');
const table = document.getElementById('user-table');

input.addEventListener('keyup', function () {
    clearTimeout(timer);

    timer = setTimeout(() => {
        fetch(`{{ route('admin.users.search') }}?q=${this.value}`)
        .then(res => res.text())
        .then(html => {
            table.innerHTML = html;
        });
    }, 100); // debounce
});
</script>
@endsection
