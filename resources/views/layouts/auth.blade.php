<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>@yield('title', 'Login') - CampusRoom</title>
    <link rel="shortcut icon" href="{{ asset('assets/img/logounuja.png') }}" type="image/x-icon">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

    <link rel="stylesheet" href="{{ url('assets/vendors/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ url('assets/css/auth.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
</head>
<body>

    <!-- Ambient Glow Spots -->
    <div class="ambient-glow-1"></div>

    <div class="login-wrapper auth-background d-flex align-items-center justify-content-center min-vh-100">
        @yield('content')
    </div>

    <script src="{{ url('assets/vendors/bootstrap.bundle.min.js') }}"></script>
    @stack('scripts')
</body>
</html>
