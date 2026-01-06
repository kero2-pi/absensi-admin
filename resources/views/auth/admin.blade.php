{{-- resources/views/auth/admin-login.blade.php --}}
<!DOCTYPE html>
<html>
<head>
    <title>Admin Login</title>
    <link rel="stylesheet"
          href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

<form method="POST" action="{{ route('admin.login.submit') }}"
      class="border p-4 rounded w-25">
    @csrf

    <h4 class="mb-3 text-center">Admin Login</h4>

    <input type="email" name="email" class="form-control mb-2" placeholder="Email" required>
    <input type="password" name="password" class="form-control mb-3" placeholder="Password" required>

    <button class="btn btn-dark w-100">Login</button>
</form>

</body>
</html>
