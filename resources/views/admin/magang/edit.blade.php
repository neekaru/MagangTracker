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
                        <select class="form-select" id="unit" name="unit">
                            <option value="IT" selected>IT Support</option>
                            <option value="Keuangan">Keuangan</option>
                            <option value="HRD">HRD</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="pembimbing" class="form-label">Dosen Pembimbing</label>
                        <select class="form-select" id="pembimbing" name="pembimbing">
                            <option value="1" selected>Pak Budi</option>
                            <option value="2">Bu Ani</option>
                        </select>
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
                            <option value="selesai">Selesai</option>
                            <option value="batal">Dibatalkan</option>
                        </select>
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
