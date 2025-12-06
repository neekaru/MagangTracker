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
                <form action="{{ route('mahasiswa.absensi.store') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label for="magang_id" class="form-label">Magang</label>
                        <select class="form-control" id="magang_id" name="magang_id" required>
                            @foreach($magangs as $magang)
                                <option value="{{ $magang->id }}">{{ $magang->unitBisnis->nama_unit_bisnis ?? 'Unit' }} - {{ $magang->periodeMagang->nama_periode ?? 'Periode' }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="tanggal" class="form-label">Tanggal</label>
                        <input type="date" class="form-control" id="tanggal" name="tanggal" value="{{ date('Y-m-d') }}" required>
                    </div>
                    <div class="mb-3">
                        <label for="jam" class="form-label">Jam</label>
                        <input type="time" class="form-control" id="jam" name="jam" value="{{ date('H:i') }}">
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
                        <textarea class="form-control" id="keterangan" name="keterangan" rows="3" placeholder="Tambahkan catatan jika perlu..."></textarea>
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
                <li>Absensi masuk dilakukan antara pukul 07:00 - 09:00.</li>
                <li>Jika berhalangan hadir, pilih status Izin atau Sakit dan berikan keterangan yang jelas.</li>
                <li>Lokasi wajib diisi jika status Hadir.</li>
            </ul>
        </div>
    </div>
</div>

<script>
    function toggleLokasi(val) {
        const lokasiGroup = document.getElementById('lokasiGroup');
        const lokasiInput = document.getElementById('lokasi');
        if(val === 'hadir') {
            lokasiGroup.style.display = 'block';
            lokasiInput.required = true;
        } else {
            lokasiGroup.style.display = 'none';
            lokasiInput.required = false;
        }
    }
</script>
@endsection
