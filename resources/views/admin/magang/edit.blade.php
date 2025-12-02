@extends('layouts.app')

@section('title', 'Edit Data Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Data Magang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/magang/1') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ url('/admin/magang/1') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h5 class="mb-3">Informasi Peserta</h5>
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Nama Peserta</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control-plaintext" value="Siti Aminah" readonly>
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Detail Penempatan</h5>
                    <div class="mb-3">
                        <label for="unit" class="form-label">Unit Penempatan</label>
                        <select class="form-select" id="unit" name="unit" onchange="toggleOtherUnit(this.value)">
                            <option value="IT" selected>IT Support</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="HRD">HRD</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>
                    <div class="mb-3" id="otherUnitGroup" style="display: none;">
                        <label for="unit_lainnya" class="form-label">Unit Lainnya</label>
                        <input type="text" class="form-control" id="unit_lainnya" name="unit_lainnya" placeholder="Masukkan unit penempatan lainnya">
                    </div>
                    
                    <div class="mb-3">
                        <label for="pembimbing" class="form-label">Dosen Pembimbing</label>
                        <select class="form-select" id="pembimbing" name="pembimbing">
                            <option value="1" selected>Pak Budi</option>
                            <option value="2">Bu Ani</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="pembimbing_lapangan" class="form-label">Pembimbing Lapangan</label>
                        <input type="text" class="form-control" id="pembimbing_lapangan" name="pembimbing_lapangan" value="Pak Joko (IT Manager)" placeholder="Masukkan nama dan jabatan pembimbing lapangan">
                    </div>

                    <div class="row mb-3">
                        <div class="col-md-6">
                            <label for="tgl_mulai" class="form-label">Tanggal Mulai</label>
                            <input type="date" class="form-control" id="tgl_mulai" name="tgl_mulai" value="2025-01-01">
                        </div>
                        <div class="col-md-6">
                            <label for="tgl_selesai" class="form-label">Tanggal Selesai</label>
                            <input type="date" class="form-control" id="tgl_selesai" name="tgl_selesai" value="2025-06-30">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="periode" class="form-label">Periode</label>
                        <select class="form-select" id="periode" name="periode">
                            <option value="1" selected>Jan 2025 - Jun 2025</option>
                            <option value="2">Jul 2025 - Des 2025</option>
                        </select>
                    </div>

                    <div class="mb-3">
                        <label for="status" class="form-label">Status Magang</label>
                        <select class="form-select" id="status" name="status">
                            <option value="aktif" selected>Aktif</option>
                            <option value="nonaktif">Nonaktif</option>
                            <option value="selesai">Selesai</option>
                            <option value="batal">Dibatalkan</option>
                        </select>
                        <div class="form-text">Status ini menentukan akses mahasiswa ke sistem.</div>
                    </div>

                    <div class="mb-3">
                        <label for="target_logbook" class="form-label">Target Logbook Mingguan</label>
                        <input type="number" class="form-control" id="target_logbook" name="target_logbook" value="5" min="1" max="7">
                        <div class="form-text">Jumlah logbook yang wajib diisi mahasiswa per minggu (Default: 5 hari kerja).</div>
                    </div>

                    <div class="mb-3">
                        <label for="deskripsi_tugas" class="form-label">Deskripsi Tugas</label>
                        <textarea class="form-control" id="deskripsi_tugas" name="deskripsi_tugas" rows="4" placeholder="Jelaskan tugas-tugas yang harus dilakukan peserta magang di unit ini">Sebagai peserta magang di unit IT Support, tugas utama Anda meliputi:
- Membantu maintenance perangkat keras dan lunak kantor.
- Melakukan troubleshooting jaringan dasar.
- Membantu instalasi dan konfigurasi software.
- Mendokumentasikan kegiatan perbaikan dan maintenance.</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end mt-4">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    function toggleOtherUnit(value) {
        const otherGroup = document.getElementById('otherUnitGroup');
        const otherInput = document.getElementById('unit_lainnya');
        if (value === 'lainnya') {
            otherGroup.style.display = 'block';
            otherInput.required = true;
        } else {
            otherGroup.style.display = 'none';
            otherInput.required = false;
        }
    }
</script>
@endpush
