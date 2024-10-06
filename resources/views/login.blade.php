<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Buku || {{$tittle}} </title>
    <style>
        body {
            background-color: lightgray !important;
        }
    </style>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    <script src="//cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="d-flex flex-column min-vh-100">

<header>
    <nav class="navbar navbar-expand-lg bg-primary">
        <div class="container">
            <a class="navbar-brand text-white" href="#">CRUD Buku</a>
        </div>
    </nav>
</header>

<div class="container">
    <div class="row">
        <div class="col-6 border p-5 rounded mx-auto mt-5 bg-white">
            <form id="loginForm">
                @csrf
                <div>
                    <h3>Login</h3>
                </div>
                <div class="mb-3">
                    <label for="username" class="form-label">Username</label>
                    <input type="text" class="form-control" name="username_user" required>
                </div>
                <div class="mb-3">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" name="password_user" required>
                </div>
                
                <button type="submit" class="btn btn-primary">Login</button>
            </form>
            <div id="response"></div>
        </div>
    </div>
</div>

<footer class="text-center text-lg-start bg-primary mt-auto">
    <div class="text-center text-white p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2024 Copyright :
        <a class="text-white" href="#">CRUD Buku</a>
    </div>
</footer>

<script>
    $(document).ready(function() {
        $('#loginForm').submit(function(e) {
            e.preventDefault(); // Mencegah reload halaman

            var formData = $(this).serialize(); // Mengambil data dari form

            $.ajax({
                url: '{{ route('login.ajax') }}', // Ganti dengan nama route yang sesuai
                type: 'POST',
                data: formData,
                success: function(response) {
                    if (response.success) {
                        // Jika login berhasil
                        $('#response').html('<div class="alert alert-primary">' + response.message + '</div>');
                        window.location.href = "{{ route('/databuku') }}"; 
                    } else {
                        // Jika login gagal
                        $('#response').html('<div class="alert alert-danger">' + response.message + '</div>');
                    }
                },
                error: function(xhr) {
                    $('#response').html('<div class="alert alert-danger">Terjadi kesalahan, coba lagi.</div>');
                }
            });
        });
    });
</script>

</body>
</html>
