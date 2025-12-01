@extends('layouts.app')

@section('title', 'Edit Penilaian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Edit Penilaian: Siti Aminah</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/penilaian/1') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ url('/admin/penilaian/1') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <h5 class="mb-3">Nilai Pembimbing Lapangan</h5>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Kedisiplinan</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="nilai_disiplin" min="0" max="100" value="85" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Tanggung Jawab</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="nilai_tanggung_jawab" min="0" max="100" value="85" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Kemampuan Teknis</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="nilai_teknis" min="0" max="100" value="85" required>
                        </div>
                    </div>

                    <h5 class="mb-3 mt-4">Nilai Dosen Pembimbing</h5>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Laporan Akhir</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="nilai_laporan" min="0" max="100" value="90" required>
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label class="col-sm-6 col-form-label">Presentasi</label>
                        <div class="col-sm-6">
                            <input type="number" class="form-control" name="nilai_presentasi" min="0" max="100" value="90" required>
                        </div>
                    </div>

                    <div class="mb-3">
                        <label for="catatan" class="form-label">Catatan</label>
                        <textarea class="form-control" id="catatan" name="catatan" rows="3">Mahasiswa sangat rajin dan proaktif dalam menyelesaikan tugas. Perlu ditingkatkan lagi dalam hal dokumentasi teknis.</textarea>
                    </div>
                    
                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <h6>Informasi Perhitungan</h6>
                <ul class="small text-muted ps-3 mb-0">
                    <li>Nilai akhir = (Rata-rata Pembimbing × 60%) + (Rata-rata Dosen × 40%)</li>
                    <li>Rata-rata Pembimbing = (Disiplin + Tanggung Jawab + Teknis) ÷ 3</li>
                    <li>Rata-rata Dosen = (Laporan + Presentasi) ÷ 2</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
