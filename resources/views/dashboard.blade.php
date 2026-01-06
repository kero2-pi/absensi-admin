<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Admin Dashboard</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body>

<div class="d-flex min-vh-100">

    {{-- SIDEBAR --}}
    <div class="bg-dark text-white p-3" style="width:250px">
        <h5 class="mb-4">ADMIN</h5>

        <ul class="nav flex-column gap-2">
            <li><a href="{{ route('dashboard') }}" class="nav-link text-white">Home</a></li>
            <li><a href="{{ route('users.index') }}" class="nav-link text-white">Users</a></li>
            <li><a href="#" class="nav-link text-white">Shifts</a></li>
        </ul>
    </div>

    {{-- CONTENT --}}
    <div class="flex-grow-1 p-4 bg-light">
        @yield('content')
    </div>

</div>

</body>
</html>
