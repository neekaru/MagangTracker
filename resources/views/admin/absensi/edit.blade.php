@extends('layouts.app')

@section('title', 'Ubah Absensi')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Ubah Data Absensi</h1>
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
                <form action="{{ route('admin.absensi.update', $absensi->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    @include('admin.absensi.partials.form', ['absensi' => $absensi, 'magangs' => $magangs])
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">Perbarui</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <div class="col-lg-6">
        <div class="alert alert-warning">
            <h5><i class="fas fa-exclamation-triangle"></i> Catatan</h5>
            <ul class="mb-0">
                <li>Perubahan disimpan sebagai pembaruan manual oleh admin.</li>
                <li>Status validasi yang di-set ke menunggu akan menghapus data validator sebelumnya.</li>
            </ul>
        </div>
    </div>
</div>
@endsection
