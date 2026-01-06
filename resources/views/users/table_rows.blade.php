@forelse ($users as $user)
<tr>
    <td>{{ $loop->iteration }}</td>
    <td>{{ $user->name }}</td>
    <td>{{ $user->email }}</td>
    <td>{{ $user->status ?? '-' }}</td>
    <td>{{ $user->mode_kerja ?? '-' }}</td>
    <td>{{ $user->instansi ?? '-' }}</td>
    <td>{{ $user->shift->nama_shift ?? '-' }}</td>
</tr>
@empty
<tr>
    <td colspan="7" class="text-center text-muted">
        Data tidak ditemukan
    </td>
</tr>
@endforelse
