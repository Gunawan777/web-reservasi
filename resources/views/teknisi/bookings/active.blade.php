@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Daftar Pesanan Aktif') }}</div>

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

        @if ($activeBookings->isEmpty())
            <p>Tidak ada pesanan aktif.</p>
        @else
            <ul class="list-group mb-4">
                @foreach ($activeBookings as $booking)
                    <li class="list-group-item">
                        <h5>Layanan: {{ $booking->service->name }}</h5>
                        <p>Pelanggan: {{ $booking->customer->name }}</p>
                        <p>Estimasi Harga: Rp{{ number_format($booking->estimated_price, 0, ',', '.') }}</p>
                        <p>Tanggal Booking: {{ \Carbon\Carbon::parse($booking->booking_date)->format('d F Y H:i') }}</p>
                        <p>Deskripsi: {{ $booking->description }}</p>
                        <p>Status: {{ ucfirst($booking->status) }}</p>
                        <div class="mt-2">
                            @if ($booking->status == 'pending')
                                <form action="{{ route('bookings.accept', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-success btn-sm">Terima</button>
                                </form>
                                <form action="{{ route('bookings.reject', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    <button type="submit" class="btn btn-danger btn-sm">Tolak</button>
                                </form>
                            @elseif (in_array($booking->status, ['accepted', 'in_progress']))
                                <form action="{{ route('bookings.updateStatus', $booking->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('PUT')
                                    <select name="status" class="form-select form-select-sm d-inline-block w-auto me-2">
                                        @if ($booking->status == 'accepted')
                                            <option value="in_progress">Dalam Pengerjaan</option>
                                            <option value="completed">Selesai</option>
                                        @elseif ($booking->status == 'in_progress')
                                            <option value="completed">Selesai</option>
                                        @endif
                                    </select>
                                    <button type="submit" class="btn btn-primary btn-sm">Update Status</button>
                                </form>
                                @if ($booking->status == 'accepted' || $booking->status == 'in_progress')
                                    <div class="mt-3">
                                        <h6>Revisi Harga</h6>
                                        <form action="{{ route('bookings.requestPriceRevision', $booking->id) }}" method="POST">
                                            @csrf
                                            @method('PUT')
                                            <div class="input-group mb-3">
                                                <span class="input-group-text">Rp</span>
                                                <input type="number" name="revised_price" class="form-control" placeholder="Harga Revisi" min="0" step="1000" value="{{ old('revised_price', $booking->revised_price ?? $booking->estimated_price) }}">
                                                <button type="submit" class="btn btn-warning">Ajukan Revisi Harga</button>
                                            </div>
                                            @error('revised_price')
                                                <span class="text-danger">{{ $message }}</span>
                                            @enderror
                                        </form>
                                    </div>
                                @endif
                            @endif
                        </div>
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