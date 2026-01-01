@extends('layouts.app')

@section('content')
<div class="card">
    <div class="card-header">{{ __('Manajemen Layanan Saya') }}</div>

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

        <div class="mb-3">
            <a href="{{ route('technician.services.create') }}" class="btn btn-primary">Tambah Layanan Baru</a>
        </div>

        <!-- Daftar Layanan Saya -->
        <div class="card">
            <div class="card-header">Daftar Layanan Saya</div>
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama Layanan</th>
                            <th>Kategori</th>
                            <th>Harga</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="serviceList">
                        <!-- Services will be loaded by JavaScript -->
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

<!-- Edit Service Modal -->
<div class="modal fade" id="editServiceModal" tabindex="-1" aria-labelledby="editServiceModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editServiceModalLabel">Edit Layanan</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form id="editServiceForm">
                    <input type="hidden" id="edit_service_id" name="id">
                    <div class="mb-3">
                        <label for="edit_category_id" class="form-label">Kategori Layanan</label>
                        <select class="form-select" id="edit_category_id" name="category_id" required>
                            <!-- Options will be loaded by JavaScript -->
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="edit_name" class="form-label">Nama Layanan</label>
                        <input type="text" class="form-control" id="edit_name" name="name" required>
                    </div>
                    <div class="mb-3">
                        <label for="edit_description" class="form-label">Deskripsi</label>
                        <textarea class="form-control" id="edit_description" name="description" rows="3"></textarea>
                    </div>
                    <div class="mb-3">
                        <label for="edit_price" class="form-label">Harga</label>
                        <input type="number" class="form-control" id="edit_price" name="price" required min="0">
                    </div>
                    <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('sidebar')
    @include('teknisi.partials.sidebar')
@endsection

<script>
    // These constants are now global from layouts/app.blade.php
    // const AUTH_TOKEN = "...";
    // const API_URL = "...";
    let allCategories = []; // To store categories for dropdowns

    document.addEventListener('DOMContentLoaded', () => {
        loadServiceCategoriesForEdit(); // Load categories for edit modal
        loadOwnedServices(); // Load services list

        document.getElementById('editServiceForm').addEventListener('submit', function(event) {
            event.preventDefault();
            updateService();
        });
    });

    async function loadServiceCategoriesForEdit() {
        try {
            const categories = await fetchApi(`${API_URL}/service-categories`);
            allCategories = categories; // Store for later use
            const categorySelectEdit = document.getElementById('edit_category_id'); // For edit form

            if (categorySelectEdit) { // Check if element exists
                categorySelectEdit.innerHTML = '';
                if (categories.length === 0) {
                    let option = document.createElement('option');
                    option.value = '';
                    option.textContent = 'Tidak ada kategori layanan tersedia';
                    categorySelectEdit.appendChild(option);
                    categorySelectEdit.disabled = true;
                } else {
                    categories.forEach(category => {
                        let option = document.createElement('option');
                        option.value = category.id;
                        option.textContent = category.name;
                        categorySelectEdit.appendChild(option);
                    });
                    categorySelectEdit.disabled = false;
                }
            }
        } catch (error) {
            console.error('Failed to load service categories:', error);
            alert('Gagal memuat kategori layanan. Pastikan ada kategori yang tersedia.');
        }
    }

    async function loadOwnedServices() {
        try {
            const services = await fetchApi(`${API_URL}/technician/owned-services`);
            const serviceListBody = document.getElementById('serviceList');
            serviceListBody.innerHTML = ''; // Clear existing list

            if (services.length === 0) {
                serviceListBody.innerHTML = '<tr><td colspan="5">Belum ada layanan yang Anda buat.</td></tr>';
                return;
            }

            services.forEach(service => {
                const row = serviceListBody.insertRow();
                row.innerHTML = `
                    <td>${service.id}</td>
                    <td>${service.name}</td>
                    <td>${service.category ? service.category.name : 'N/A'}</td>
                    <td>Rp${service.price.toLocaleString('id-ID')}</td>
                    <td>
                        <button class="btn btn-sm btn-info me-1" onclick="showEditModal(${service.id})">Edit</button>
                        <button class="btn btn-sm btn-danger" onclick="deleteService(${service.id})">Hapus</button>
                    </td>
                `;
            });
        } catch (error) {
            console.error('Failed to load owned services:', error);
            alert('Gagal memuat layanan Anda. Pastikan Anda sudah login sebagai teknisi.');
        }
    }

    async function showEditModal(serviceId) {
        try {
            const service = await fetchApi(`${API_URL}/technician/owned-services/${serviceId}`);
            
            // Populate the modal form
            document.getElementById('edit_service_id').value = service.id;
            document.getElementById('edit_category_id').value = service.category_id;
            document.getElementById('edit_name').value = service.name;
            document.getElementById('edit_description').value = service.description || '';
            document.getElementById('edit_price').value = service.price;

            // Show the modal
            var editServiceModal = new bootstrap.Modal(document.getElementById('editServiceModal'));
            editServiceModal.show();

        } catch (error) {
            console.error('Failed to load service for editing:', error);
            alert('Gagal memuat data layanan untuk diedit.');
        }
    }

    async function updateService() {
        const form = document.getElementById('editServiceForm');
        const serviceId = document.getElementById('edit_service_id').value;
        const serviceData = {
            category_id: form.elements['edit_category_id'].value,
            name: form.elements['edit_name'].value,
            description: form.elements['edit_description'].value,
            price: form.elements['edit_price'].value,
        };

        try {
            await fetchApi(`${API_URL}/technician/owned-services/${serviceId}`, 'PUT', serviceData);
            alert('Layanan berhasil diperbarui!');
            var editServiceModal = bootstrap.Modal.getInstance(document.getElementById('editServiceModal'));
            editServiceModal.hide();
            loadOwnedServices(); // Refresh list
        } catch (error) {
            // Error handled in fetchApi
        }
    }

    async function deleteService(serviceId) {
        if (!confirm('Anda yakin ingin menghapus layanan ini?')) {
            return;
        }

        try {
            await fetchApi(`${API_URL}/technician/owned-services/${serviceId}`, 'DELETE');
            alert('Layanan berhasil dihapus!');
            loadOwnedServices(); // Refresh list
        } catch (error) {
            // Error handled in fetchApi
        }
    }
</script>