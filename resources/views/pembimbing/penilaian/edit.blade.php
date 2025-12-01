@extends('layouts.app')

@section('title', 'Form Penilaian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Form Penilaian: Siti Aminah</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/pembimbing/penilaian') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ url('/pembimbing/penilaian') }}" method="POST">
                    @csrf
                    <h5 class="mb-3">Komponen Penilaian</h5>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Kedisiplinan (20%)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="nilai_disiplin" min="0" max="100" required>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Tanggung Jawab (20%)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="nilai_tanggung_jawab" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Kemampuan Teknis (30%)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="nilai_teknis" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Kerjasama Tim (15%)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="nilai_kerjasama" min="0" max="100" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-4 col-form-label">Etika & Perilaku (15%)</label>
                        <div class="col-sm-8">
                            <input type="number" class="form-control" name="nilai_etika" min="0" max="100" required>
                        </div>
                    </div>

                    <hr>

                    <div class="mb-3">
                        <label class="form-label">Catatan / Komentar Pembimbing</label>
                        <textarea class="form-control" name="catatan" rows="4"></textarea>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Penilaian</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-md-4">
        <div class="card shadow-sm bg-light">
            <div class="card-body">
                <h6>Panduan Penilaian</h6>
                <ul class="small text-muted ps-3">
                    <li>Rentang nilai 0 - 100.</li>
                    <li>Nilai Akhir dihitung otomatis berdasarkan bobot.</li>
                    <li>Pastikan objektif dalam memberikan penilaian.</li>
                </ul>
            </div>
        </div>
    </div>
</div>
@endsection
