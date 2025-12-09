@extends('layouts.app')

@section('title', 'Tambah Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Tambah Absensi Peserta</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('admin.absensi.index') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-6">
        <div class="card shadow-sm">
            <div class="card-body">
                <form action="{{ route('admin.absensi.store') }}" method="POST">
                    @csrf
                    @include('admin.absensi.partials.form', ['absensi' => null, 'magangs' => $magangs])
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="alert alert-info">
            <h5><i class="fas fa-info-circle"></i> Panduan</h5>
            <ul class="mb-0">
                <li>Pilih peserta magang dengan status aktif.</li>
                <li>Admin dapat langsung menentukan status validasi.</li>
                <li>Gunakan keterangan untuk menjelaskan perubahan manual.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
