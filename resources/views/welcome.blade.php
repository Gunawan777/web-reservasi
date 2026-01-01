<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>RepairGo</title>

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=Inter:wght@300;400;500&display=swap" rel="stylesheet">

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <style>
        body {
            margin: 0;
            font-family: 'Inter', sans-serif;
        }

        /* HERO */
        .hero {
            min-height: 100vh;
            background: 
                linear-gradient(rgba(0,0,0,.45), rgba(0,0,0,.45)),
                url("{{ asset('images/What Are Low Voltage Systems and How It Works.jpg') }}") center/cover no-repeat;
            color: #fff;
            display: flex;
            align-items: center;
        }

        .hero h1 {
            font-family: 'Playfair Display', serif;
            font-size: 4rem;
            font-weight: 700;
        }

        .hero p {
            max-width: 520px;
            font-size: 1.1rem;
            margin-top: 1rem;
            color: #eaeaea;
        }

        .btn-hero {
            margin-top: 1.5rem;
            padding: 12px 30px;
            border-radius: 30px;
            font-weight: 500;
        }

        /* NAVBAR */
        .navbar {
            background: transparent !important;
            position: absolute;
            width: 100%;
            z-index: 10;
        }

        .navbar a {
            color: #fff !important;
            font-weight: 500;
        }

        .navbar-brand {
            font-weight: 700;
            letter-spacing: 1px;
        }
    </style>
</head>
<body>

<!-- NAVBAR -->
<nav class="navbar navbar-expand-md">
    <div class="container">
        <a class="navbar-brand" href="#">RepairGo</a>

        <div class="ms-auto">
            @if (Route::has('login'))
                @auth
                    <a href="{{ url('/home') }}" class="me-3">Dashboard</a>
                @else
                    <a href="{{ route('login') }}" class="me-3">Login</a>
                    @if (Route::has('register'))
                        <a href="{{ route('register') }}">Register</a>
                    @endif
                @endauth
            @endif
        </div>
    </div>
</nav>

<!-- HERO SECTION -->
<section class="hero">
    <div class="container">
        <div class="row">
            <div class="col-lg-7">
                <small class="text-uppercase opacity-75">
                    Solusi Perbaikan Terpercaya
                </small>

                <h1 class="mt-2">
                    Solusi Perjalanan<br>
                    Perbaikan Digital Anda
                </h1>

                <p>
                    Temukan teknisi terbaik untuk perbaikan perangkat, instalasi,
                    dan layanan teknis lainnya dengan cepat, aman, dan profesional.
                </p>

                <a href="{{ route('login') }}" class="btn btn-warning btn-hero">
                    Mulai Sekarang
                </a>
            </div>
        </div>
    </div>
</section>

</body>
</html>
