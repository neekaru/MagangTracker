@extends('layouts.app')

@section('title', 'Detail Absensi')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Absensi</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('pembimbing.absensi.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-light">
                    <h5 class="card-title mb-0">Informasi Absensi</h5>
                </div>
                <div class="card-body">
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Nama Peserta</div>
                        <div class="col-md-8">{{ $absen->magang->mahasiswa->nama_lengkap ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">NIM</div>
                        <div class="col-md-8">{{ $absen->magang->mahasiswa->nim ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Tanggal</div>
                        <div class="col-md-8">{{ \Carbon\Carbon::parse($absen->tanggal)->format('d F Y') }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Jenis Absensi</div>
                        <div class="col-md-8">
                            @if ($absen->jenis_absen == 'masuk')
                                <span class="badge bg-primary">Masuk</span>
                            @else
                                <span class="badge bg-secondary">Pulang</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Jam</div>
                        <div class="col-md-8">{{ $absen->jam ? substr($absen->jam, 0, 5) . ' WIB' : '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status Kehadiran</div>
                        <div class="col-md-8">
                            @if ($absen->status_kehadiran == 'Hadir')
                                <span class="badge bg-success">Hadir</span>
                            @elseif($absen->status_kehadiran == 'Izin')
                                <span class="badge bg-warning text-dark">Izin</span>
                            @else
                                <span class="badge bg-danger">Sakit</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Lokasi</div>
                        <div class="col-md-8">{{ $absen->magang->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Koordinat GPS</div>
                        <div class="col-md-8">
                            @if ($absen->latitude && $absen->longitude)
                                <div class="mb-2">
                                    <strong>Latitude:</strong> {{ $absen->latitude }}<br>
                                    <strong>Longitude:</strong> {{ $absen->longitude }}
                                </div>
                                <div id="map" style="height: 300px; width: 100%; border-radius: 8px;"></div>
                            @else
                                <span class="text-muted">-</span>
                            @endif
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Keterangan</div>
                        <div class="col-md-8">{{ $absen->keterangan ?: '-' }}</div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Waktu Input</div>
                        <div class="col-md-8">
                            {{ $absen->created_at ? \Carbon\Carbon::parse($absen->created_at)->format('d F Y, H:i') . ' WIB' : '-' }}
                        </div>
                    </div>
                    @if (Auth::check() && Auth::user()->role === 'Admin' && $absen->foto_bukti)
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Foto Bukti</div>
                        <div class="col-md-8">
                            @if (\Illuminate\Support\Facades\Storage::disk('public')->exists($absen->foto_bukti))
                                <a href="{{ Storage::url($absen->foto_bukti) }}" target="_blank" title="Klik untuk memperbesar">
                                    <img src="{{ Storage::url($absen->foto_bukti) }}" alt="Foto Bukti Absensi"
                                        class="img-thumbnail" style="max-height: 200px; object-fit: cover; cursor: zoom-in;">
                                </a>
                            @else
                                <span class="text-muted fst-italic">Tidak ada foto</span>
                            @endif
                        </div>
                    </div>
                    @endif
                    <hr>
                    <div class="row mb-3">
                        <div class="col-md-4 fw-bold">Status Validasi</div>
                        <div class="col-md-8">
                            @if ($absen->status_validasi === 'approved')
                                <span class="badge bg-success">Disetujui</span>
                            @elseif($absen->status_validasi === 'rejected')
                                <span class="badge bg-danger">Ditolak</span>
                            @else
                                <span class="badge bg-secondary">Menunggu Validasi</span>
                            @endif
                        </div>
                    </div>
                </div>
            </div>


        </div>
    </div>
@endsection

@push('styles')
<link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""/>
@endpush

@push('scripts')
<script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""></script>
<script>
    @if ($absen->latitude && $absen->longitude)
        document.addEventListener('DOMContentLoaded', function() {
            var lat = {{ $absen->latitude }};
            var lng = {{ $absen->longitude }};
            
            // Inisialisasi peta
            var map = L.map('map').setView([lat, lng], 15);
            
            // Tambahkan tile layer dari OpenStreetMap
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', {
                attribution: '&copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors',
                maxZoom: 19
            }).addTo(map);
            
            // Tambahkan marker di lokasi absensi
            var marker = L.marker([lat, lng]).addTo(map);
            marker.bindPopup('<b>Lokasi Absensi</b><br>{{ $absen->magang->mahasiswa->nama_lengkap ?? "N/A" }}<br>{{ \Carbon\Carbon::parse($absen->tanggal)->format("d F Y") }}').openPopup();
        });
    @endif
</script>
@endpush
