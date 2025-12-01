@extends('layouts.app')

@section('title', 'Isi Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Form Absensi Harian</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/mahasiswa/absensi') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ url('/mahasiswa/absensi') }}" method="POST">
                    @csrf
                    <div class="mb-3">
                        <label class="form-label">Tanggal & Jam</label>
                        <input type="text" class="form-control" value="{{ date('d M Y H:i') }}" disabled readonly>
                        <small class="text-muted">Waktu server saat ini.</small>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status" class="form-label">Status Kehadiran</label>
                        <select class="form-select" id="status" name="status" required onchange="toggleLokasi(this.value)">
                            <option value="hadir">Hadir</option>
                            <option value="izin">Izin</option>
                            <option value="sakit">Sakit</option>
                        </select>
                    </div>

                    <div class="mb-3" id="lokasiGroup">
                        <label for="lokasi" class="form-label">Lokasi Saat Ini</label>
                        <input type="text" class="form-control" id="lokasi" name="lokasi" placeholder="Contoh: Kantor Pusat, Lab Komputer, WFH">
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
