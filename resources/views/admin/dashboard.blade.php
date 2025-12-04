@extends('layouts.app')

@section('title', 'Admin Dashboard')

@section('content')
    <div class="row">
        <div class="col-md-12 mb-4">
            <h2>Admin Dashboard</h2>
            <p>Welcome back, Admin.</p>
        </div>
    </div>

    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-white bg-primary mb-3">
                <div class="card-header"><i class="fas fa-users me-2"></i>Peserta Aktif</div>
                <div class="card-body">
                    <h5 class="card-title">120</h5>
                    <p class="card-text">Mahasiswa sedang magang.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-success mb-3">
                <div class="card-header"><i class="fas fa-chalkboard-teacher me-2"></i>Pembimbing</div>
                <div class="card-body">
                    <h5 class="card-title">15</h5>
                    <p class="card-text">Dosen & Pembimbing Lapangan.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-warning mb-3">
                <div class="card-header"><i class="fas fa-user-plus me-2"></i>Pendaftaran Baru</div>
                <div class="card-body">
                    <h5 class="card-title">5</h5>
                    <p class="card-text">Menunggu verifikasi.</p>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-white bg-danger mb-3">
                <div class="card-header"><i class="fas fa-book-open me-2"></i>Logbook Hari Ini</div>
                <div class="card-body">
                    <h5 class="card-title">45</h5>
                    <p class="card-text">Logbook terisi hari ini.</p>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <i class="fas fa-chart-bar me-2"></i>Statistik Pendaftaran per Periode
                </div>
                <div class="card-body">
                    <canvas id="magangChart" width="400" height="200"></canvas>
                </div>
            </div>
        </div>
        <div class="col-md-4">
            <div class="card mb-4">
                <div class="card-header">
                    <i class="fas fa-history me-2"></i>Aktivitas Terbaru
                </div>
                <ul class="list-group list-group-flush">
                    <li class="list-group-item">Budi mengisi logbook <span class="badge bg-secondary float-end">10m
                            ago</span></li>
                    <li class="list-group-item">Siti mendaftar magang <span class="badge bg-secondary float-end">1h
                            ago</span></li>
                    <li class="list-group-item">Pak Dosen menilai Andi <span class="badge bg-secondary float-end">2h
                            ago</span></li>
                </ul>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const ctx = document.getElementById('magangChart').getContext('2d');
            const magangChart = new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Ganjil 2024', 'Genap 2024', 'Ganjil 2025', 'Genap 2025'],
                    datasets: [{
                        label: 'Jumlah Peserta Magang',
                        data: [45, 52, 38, 65],
                        backgroundColor: [
                            'rgba(255, 99, 132, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 205, 86, 0.2)',
                            'rgba(75, 192, 192, 0.2)'
                        ],
                        borderColor: [
                            'rgba(255, 99, 132, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 205, 86, 1)',
                            'rgba(75, 192, 192, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    scales: {
                        y: {
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
@endpush
