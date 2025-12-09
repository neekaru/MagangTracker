@extends('layouts.app')

@section('content')
<div class="container mt-4">
    <div class="alert alert-info">
        <h4>Pendaftaran Magang Dinonaktifkan</h4>
        <p>Pendaftaran magang melalui aplikasi telah dinonaktifkan. Jika Anda ingin mendaftar magang, silakan hubungi Admin.</p>
    </div>
    <a href="{{ route('mahasiswa.magang.index') }}" class="btn btn-secondary">Kembali</a>
</div>
@endsection