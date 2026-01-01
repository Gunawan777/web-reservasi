@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">{{ __('Daftar Teknisi') }}</div>

                <div class="card-body">
                    <div id="techniciansList" class="row">
                        <!-- Technicians and their services will be loaded by JavaScript -->
                        <p>Memuat daftar teknisi...</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        loadTechniciansAndServices();
    });

    async function loadTechniciansAndServices() {
        try {
            // Use the globally defined fetchApi
            const technicians = await fetchApi(`${API_URL}/customer/technicians`);
            const techniciansListDiv = document.getElementById('techniciansList');
            techniciansListDiv.innerHTML = ''; // Clear existing content

            if (technicians.length === 0) {
                techniciansListDiv.innerHTML = '<p>Tidak ada teknisi yang terdaftar atau menawarkan layanan.</p>';
                return;
            }

            technicians.forEach(technician => {
                const technicianCard = document.createElement('div');
                technicianCard.className = 'col-md-12 mb-4'; // Full width for each technician for better service display
                let servicesHtml = '<p>Belum ada layanan yang ditawarkan.</p>';

                if (technician.owned_services && technician.owned_services.length > 0) {
                    servicesHtml = '<ul class="list-group list-group-flush">';
                    technician.owned_services.forEach(service => {
                        servicesHtml += `
                            <li class="list-group-item">
                                <strong>${service.name}</strong><br>
                                Kategori: ${service.category ? service.category.name : 'N/A'}<br>
                                Deskripsi: ${service.description || 'Tidak ada deskripsi'}<br>
                                Harga: Rp${service.price.toLocaleString('id-ID')}
                            </li>
                        `;
                    });
                    servicesHtml += '</ul>';
                }

                technicianCard.innerHTML = `
                    <div class="card">
                        <div class="card-header">
                            <h5>${technician.name} <small class="text-muted">(Teknisi)</small></h5>
                        </div>
                        <div class="card-body">
                            <p>Email: ${technician.email}</p>
                            <p>Telepon: ${technician.phone_number}</p>
                            <p>Alamat: ${technician.address}</p>
                            <h6>Layanan yang Ditawarkan:</h6>
                            ${servicesHtml}
                            <a href="/teknisi/${technician.id}" class="btn btn-primary btn-sm mt-3">Lihat Detail & Buat Pesanan</a>
                        </div>
                    </div>
                `;
                techniciansListDiv.appendChild(technicianCard);
            });
        } catch (error) {
            console.error('Failed to load technicians and services:', error);
            alert('Gagal memuat daftar teknisi. Pastikan Anda sudah login.');
        }
    }
</script>
