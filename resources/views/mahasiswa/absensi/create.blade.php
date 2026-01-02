@extends('layouts.app')

@section('title', 'Isi Absensi')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Form Absensi Harian</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('mahasiswa.absensi.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-body">
                    @if (session('error'))
                        <div class="alert alert-danger">
                            {{ session('error') }}
                        </div>
                    @endif
                    @if ($errors->any())
                        <div class="alert alert-danger">
                            <ul class="mb-0">
                                @foreach ($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
                    <form action="{{ route('mahasiswa.absensi.store') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="magang_id" class="form-label">Magang</label>
                            <select class="form-control" id="magang_id" name="magang_id" required>
                                @foreach ($magangs as $magang)
                                    <option value="{{ $magang->id }}">
                                        {{ $magang->unitBisnis->nama_unit_bisnis ?? 'Unit' }} -
                                        {{ $magang->periodeMagang->nama_periode ?? 'Periode' }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="jenis_absen" class="form-label">Jenis Absensi</label>
                            <select class="form-select" id="jenis_absen" name="jenis_absen" required>
                                <option value="">-- Pilih Jenis Absensi --</option>
                                <option value="masuk">Absensi Masuk</option>
                                <option value="pulang">Absensi Pulang</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="tanggal" class="form-label">Tanggal</label>
                            <input type="date" class="form-control" id="tanggal" name="tanggal"
                                value="{{ date('Y-m-d') }}" required>
                        </div>
                        <div class="mb-3">
                            <label for="jam" class="form-label">Jam</label>
                            <input type="time" class="form-control" id="jam" name="jam"
                                value="{{ date('H:i') }}">
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Lokasi Absensi</label>
                            <div id="absensi-map" class="rounded border"></div>
                            <div class="row g-2 mt-2">
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="latitude" name="latitude" placeholder="Latitude" value="{{ old('latitude') }}" readonly>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" id="longitude" name="longitude" placeholder="Longitude" value="{{ old('longitude') }}" readonly>
                                </div>
                            </div>
                            <button type="button" class="btn btn-outline-primary btn-sm mt-2" id="gunakan-lokasi">
                                Gunakan Lokasi Saya
                            </button>
                            <small id="lokasiStatus" class="text-muted d-block mt-1">Mendeteksi lokasi...</small>
                        </div>
                        <div class="mb-3">
                            <label for="status_kehadiran" class="form-label">Status Kehadiran</label>
                            <select class="form-select" id="status_kehadiran" name="status_kehadiran" required>
                                <option value="Hadir">Hadir</option>
                                <option value="Izin">Izin</option>
                                <option value="Sakit">Sakit</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="keterangan" class="form-label">Keterangan</label>
                            <textarea class="form-control" id="keterangan" name="keterangan" rows="3"
                                placeholder="Tambahkan catatan jika perlu..."></textarea>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-primary btn-lg">Kirim Absensi</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="alert alert-info">
                <h5><i class="fas fa-info-circle"></i> Aturan Absensi</h5>
                <ul class="mb-0">
                    <li>Untuk status <strong>Hadir</strong>, pilih jenis absensi: Masuk atau Pulang.</li>
                    <li>Untuk status <strong>Izin</strong> atau <strong>Sakit</strong>, tidak perlu memilih jenis absensi.
                    </li>
                    <li>Anda hanya dapat melakukan 1x absensi masuk dan 1x absensi pulang per hari.</li>
                    <li>Absensi masuk disarankan dilakukan antara pukul 07:00 - 09:00.</li>
                    <li>Jika berhalangan hadir, pilih status Izin atau Sakit dan berikan keterangan yang jelas.</li>
                </ul>
            </div>
        </div>
    </div>

@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <style>
        #absensi-map {
            height: 320px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js" integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo=" crossorigin=""></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const statusKehadiran = document.getElementById('status_kehadiran');
            const jenisAbsenGroup = document.getElementById('jenis_absen').closest('.mb-3');
            const jenisAbsenSelect = document.getElementById('jenis_absen');

            function toggleJenisAbsen() {
                if (statusKehadiran.value === 'Hadir') {
                    jenisAbsenGroup.style.display = 'block';
                    jenisAbsenSelect.required = true;
                } else {
                    jenisAbsenGroup.style.display = 'none';
                    jenisAbsenSelect.required = false;
                    jenisAbsenSelect.value = '';
                }
            }

            toggleJenisAbsen();
            statusKehadiran.addEventListener('change', toggleJenisAbsen);

            const lokasiStatus = document.getElementById('lokasiStatus');
            const latitudeInput = document.getElementById('latitude');
            const longitudeInput = document.getElementById('longitude');
            const gunakanLokasiBtn = document.getElementById('gunakan-lokasi');

            function setLokasiStatus(message) {
                if (lokasiStatus) {
                    lokasiStatus.textContent = message;
                }
            }

            var defaultLat = -6.200000;
            var defaultLng = 106.816666;
            var oldLat = parseFloat("{{ old('latitude') }}");
            var oldLng = parseFloat("{{ old('longitude') }}");
            var hasOldCoords = !isNaN(oldLat) && !isNaN(oldLng);

            var map = L.map('absensi-map').setView(
                hasOldCoords ? [oldLat, oldLng] : [defaultLat, defaultLng],
                hasOldCoords ? 16 : 12
            );

            L.tileLayer('https://{s}.tile.openstreetmap.de/tiles/osmde/{z}/{x}/{y}.png', {
                attribution: '&copy; OpenStreetMap contributors, tiles by openstreetmap.de'
            }).addTo(map);

            var marker = null;
            function updateCoords(lat, lng) {
                latitudeInput.value = lat.toFixed(6);
                longitudeInput.value = lng.toFixed(6);
            }

            function setMarker(lat, lng) {
                if (!marker) {
                    marker = L.marker([lat, lng], { draggable: true }).addTo(map);
                    marker.on('dragend', function (e) {
                        var pos = e.target.getLatLng();
                        updateCoords(pos.lat, pos.lng);
                    });
                } else {
                    marker.setLatLng([lat, lng]);
                }
                updateCoords(lat, lng);
            }

            if (hasOldCoords) {
                setMarker(oldLat, oldLng);
            }

            map.on('click', function (e) {
                setMarker(e.latlng.lat, e.latlng.lng);
                setLokasiStatus('Lokasi dipilih dari peta.');
            });

            function requestLocation() {
                if (!navigator.geolocation) {
                    setLokasiStatus('Perangkat ini tidak mendukung GPS.');
                    return;
                }

                setLokasiStatus('Meminta izin lokasi dengan akurasi tinggi...');
                var watchId = navigator.geolocation.watchPosition(
                    function (position) {
                        var lat = position.coords.latitude;
                        var lng = position.coords.longitude;
                        var accuracy = position.coords.accuracy;
                        setMarker(lat, lng);
                        map.setView([lat, lng], 16);
                        if (accuracy && accuracy > 0) {
                            setLokasiStatus('Akurasi lokasi: ' + Math.round(accuracy) + ' m.');
                        } else {
                            setLokasiStatus('Lokasi berhasil diambil.');
                        }
                        if (accuracy && accuracy <= 50) {
                            navigator.geolocation.clearWatch(watchId);
                            setLokasiStatus('Lokasi akurat berhasil diambil (' + Math.round(accuracy) + ' m).');
                        }
                    },
                    function (error) {
                        var message = 'Lokasi tidak diizinkan. Absensi tetap bisa dikirim.';
                        if (error && typeof error.code !== 'undefined') {
                            if (error.code === 1) {
                                message = 'Izin lokasi ditolak. Absensi tetap bisa dikirim.';
                            } else if (error.code === 2) {
                                message = 'Lokasi tidak tersedia. Coba lagi.';
                            } else if (error.code === 3) {
                                message = 'Permintaan lokasi timeout. Coba lagi.';
                            }
                        }
                        setLokasiStatus(message);
                        navigator.geolocation.clearWatch(watchId);
                    },
                    { enableHighAccuracy: true, timeout: 30000, maximumAge: 0 }
                );
            }

            gunakanLokasiBtn.addEventListener('click', requestLocation);
            requestLocation();
        });
    </script>
@endpush


