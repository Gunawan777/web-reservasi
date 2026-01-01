@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Riwayat Pesanan') }}</div>

    <div class="card-body">
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

        @if ($historyBookings->isEmpty())
            <p>Tidak ada riwayat pesanan.</p>
        @else
            <ul class="list-group">
                @foreach ($historyBookings as $booking)
                    <li class="list-group-item">
                        <h5>Layanan: {{ $booking->service->name }}</h5>
                        <p>Pelanggan: {{ $booking->customer->name }}</p>
                        <p>Harga: Rp{{ number_format($booking->revised_price ?? $booking->estimated_price, 0, ',', '.') }}</p>
                        <p>Tanggal Booking: {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y H:i') }}</p>
                        <p>Deskripsi: {{ $booking->description }}</p>
                        <p>Status: {{ ucfirst($booking->status) }}</p>
                        @if ($booking->review)
                            <div class="mt-3">
                                <h6>Ulasan Pelanggan:</h6>
                                <p>Rating: {{ $booking->review->rating }} Bintang</p>
                                <p>Komentar: {{ $booking->review->comment }}</p>
                            </div>
                        @endif
                    </li>
                @endforeach
            </ul>
        @endif
    </div>
</div>
@endsection

@section('sidebar')
    @include('teknisi.partials.sidebar')
@endsection

