<div class="card">
    <div class="card-header">{{ __('Navigasi Teknisi') }}</div>
    <div class="card-body p-0">
        <div class="list-group list-group-flush">
            <a href="{{ route('teknisi.dashboard') }}" class="list-group-item list-group-item-action {{ request()->routeIs('teknisi.dashboard') ? 'active' : '' }}">
                {{ __('Dashboard Utama') }}
            </a>
            <a href="{{ route('technician.services.index') }}" class="list-group-item list-group-item-action {{ request()->routeIs('technician.services.index') ? 'active' : '' }}">
                {{ __('Manajemen Layanan Saya') }}
            </a>
            <a href="{{ route('technician.bookings.active') }}" class="list-group-item list-group-item-action {{ request()->routeIs('technician.bookings.active') ? 'active' : '' }}">
                {{ __('Daftar Pesanan Aktif') }}
            </a>
            <a href="{{ route('technician.bookings.history') }}" class="list-group-item list-group-item-action {{ request()->routeIs('technician.bookings.history') ? 'active' : '' }}">
                {{ __('Riwayat Pesanan') }}
            </a>
            <a href="{{ route('logout') }}" class="list-group-item list-group-item-action"
               onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                {{ __('Logout') }}
            </a>
        </div>
    </div>
</div>
