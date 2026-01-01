@extends('layouts.app')

@section('content')



<style>
/* ================= HERO SECTION ================= */
.hero-section {
    height: 85vh;
    background: linear-gradient(
        rgba(0,0,0,0.55),
        rgba(0,0,0,0.55)
    ),
    url('/images/ChatGPT Image 28 Des 2025, 04.45.24.png');
    background-size: cover;
    background-position: center;
    display: flex;
    align-items: center;
    color: #fff;
}

.hero-content {
    max-width: 600px;
}

.hero-content h1 {
    font-size: 3rem;
    font-weight: 700;
}

/* ================= FEATURE ================= */
.feature-card {
    border-radius: 14px;
    box-shadow: 0 10px 25px rgba(0,0,0,0.1);
    transition: all 0.3s ease;
}

.feature-card:hover {
    transform: translateY(-8px);
}
</style>

<!-- HERO SECTION -->
<div class="hero-section d-flex align-items-center text-white">
    <div class="container text-center">
        <h5 class="text-warning mb-2">SOLUSI PERBAIKAN TERBAIK</h5>
        <h1 class="fw-bold display-5">
            TEMUKAN TEKNISI <br> TERPERCAYA ANDA
        </h1>
        <p class="mt-3 mb-4">
            Layanan perbaikan cepat, aman, dan profesional langsung ke lokasi Anda
        </p>
        <a href="{{ route('teknisi.index') }}" class="btn btn-warning btn-lg px-4">
            Cari Teknisi Sekarang
        </a>
    </div>
</div>

<!-- FEATURE CARDS -->
<div class="container feature-section">
    <div class="row text-center">

        <div class="col-md-3 mb-4">
            <div class="card feature-card p-4 shadow-sm">
                <div class="icon mb-3">👨‍🔧</div>
                <h5>Teknisi Profesional</h5>
                <p class="text-muted">Berpengalaman & terpercaya</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card feature-card p-4 shadow-sm">
                <div class="icon mb-3">💰</div>
                <h5>Harga Terbaik</h5>
                <p class="text-muted">Transparan & terjangkau</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card feature-card p-4 shadow-sm">
                <div class="icon mb-3">🛠️</div>
                <h5>Layanan Lengkap</h5>
                <p class="text-muted">Berbagai jenis perbaikan</p>
            </div>
        </div>

        <div class="col-md-3 mb-4">
            <div class="card feature-card p-4 shadow-sm">
                <div class="icon mb-3">⚡</div>
                <h5>Respon Cepat</h5>
                <p class="text-muted">Teknisi siap datang</p>
            </div>
        </div>

    </div>
</div>

<!-- DASHBOARD CONTENT -->
<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <strong>Dashboard Pelanggan</strong>
        </div>

        <div class="card-body">
            <p>Selamat datang di dashboard pelanggan!</p>

            <div class="row text-center mt-4">
                <div class="col-md-6 mb-3">
                    <div class="card p-3">
                        <h5>Jumlah Teknisi</h5>
                        <p class="display-6">{{ $totalTechnicians }}</p>
                    </div>
                </div>
                <div class="col-md-6 mb-3">
                    <div class="card p-3">
                        <h5>Jumlah Layanan</h5>
                        <p class="display-6">{{ $totalServices }}</p>
                    </div>
                </div>
            </div>

            @if(session('success'))
                <div class="alert alert-success mt-3">
                    {{ session('success') }}
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger mt-3">
                    {{ session('error') }}
                </div>
            @endif
        </div>
    </div>
</div>

@endsection
