@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Tambah Layanan Baru') }}</div>

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

        <!-- Form Tambah Layanan Baru -->
        <form id="createServiceForm">
            <div class="mb-3">
                <label for="category_id" class="form-label">Kategori Layanan</label>
                <select class="form-select" id="category_id" name="category_id" required>
                    <option value="">Pilih Kategori</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-3">
                <label for="name" class="form-label">Nama Layanan</label>
                <input type="text" class="form-control" id="name" name="name" required>
            </div>
            <div class="mb-3">
                <label for="description" class="form-label">Deskripsi</label>
                <textarea class="form-control" id="description" name="description" rows="3"></textarea>
            </div>
            <div class="mb-3">
                <label for="price" class="form-label">Harga</label>
                <input type="number" class="form-control" id="price" name="price" required min="0">
            </div>
            <button type="submit" class="btn btn-primary">Tambah Layanan</button>
            <a href="{{ route('technician.services.index') }}" class="btn btn-secondary">Batal</a>
        </form>

    </div>
</div>
@endsection

@section('sidebar')
    @include('teknisi.partials.sidebar')
@endsection

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.getElementById('createServiceForm').addEventListener('submit', function(event) {
            event.preventDefault();
            createService();
        });
    });

    async function createService() {
        const form = document.getElementById('createServiceForm');
        const serviceData = {
            category_id: form.elements['category_id'].value,
            name: form.elements['name'].value,
            description: form.elements['description'].value,
            price: form.elements['price'].value,
        };

        try {
            await fetchApi(`${API_URL}/technician/owned-services`, 'POST', serviceData);
            alert('Layanan berhasil ditambahkan!');
            window.location.href = "{{ route('technician.services.index') }}"; // Redirect to service list
        } catch (error) {
            // Error handled in fetchApi
        }
    }
</script>