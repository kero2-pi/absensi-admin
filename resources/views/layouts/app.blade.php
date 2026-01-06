<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>

<body class="bg-light">

<div class="d-flex">

    {{-- SIDEBAR --}}
    <div class="bg-dark text-white p-3 sidebar">
        <h5 class="mb-4">ADMIN</h5>

        <ul class="nav flex-column gap-2">
            <li><a href="{{ route('admin.home') }}" class="nav-link text-white">Home</a></li>
            <li><a href="{{ route('admin.users.index') }}" class="nav-link text-white">Users</a></li>
            <li><a href="{{ route('admin.perizinan.index') }}" class="nav-link text-white">Perizinan</a></li>
            <li><a href="{{ route('admin.laporan.index') }}" class="nav-link text-white">Laporan</a></li>
            <li><a href="{{ route('admin.settings.index') }}" class="nav-link text-white">Settings</a></li>
            
        </ul>
    </div>

    {{-- CONTENT --}}
    <div class="content flex-grow-1 p-4">
        @yield('content')
        @yield('scripts')
    </div>

</div>

</body>

<style>
    body {
        overflow: hidden;
    }

    .sidebar {
        width: 250px;
        height: 100vh;
        position: fixed;
        left: 0;
        top: 0;
        overflow-y: auto;
    }

    .content {
        margin-left: 250px;
        height: 100vh;
        overflow-y: auto;
    }
</style>
</html>
