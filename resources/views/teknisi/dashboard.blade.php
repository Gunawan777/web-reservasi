@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Dashboard Teknisi') }}</div>

    <div class="card-body">
        <p>{{ __('Selamat datang di dashboard teknisi!') }}</p>

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

        {{-- The actual content for active/history bookings is now on dedicated pages --}}
        <p>Gunakan navigasi di samping untuk mengelola layanan dan pesanan Anda.</p>
    </div>
</div>
@endsection

@section('sidebar')
    @include('teknisi.partials.sidebar')
@endsection
