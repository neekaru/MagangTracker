@extends('layouts.app')

@section('title', 'Profil Saya')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Profil Saya</h1>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <img src="https://ui-avatars.com/api/?name=Ahmad+Fulan&background=random" class="rounded-circle mb-3" width="100">
                <h5>Ahmad Fulan</h5>
                <p class="text-muted mb-1">Mahasiswa</p>
                <span class="badge bg-success">Aktif</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm">
            <div class="card-header">
                Edit Profil
            </div>
            <div class="card-body">
                <form action="{{ url('/mahasiswa/profil') }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Nama Lengkap</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nama" value="Ahmad Fulan" required>
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">NIM</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="nim" value="C030320001" readonly>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Email</label>
                        <div class="col-sm-9">
                            <input type="email" class="form-control" name="email" value="ahmad@mhs.com" required>
                        </div>
                    </div>

                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">No. HP</label>
                        <div class="col-sm-9">
                            <input type="text" class="form-control" name="no_hp" value="081234567890">
                        </div>
                    </div>

                    <hr>
                    
                    <h6 class="mb-3">Ganti Password (Opsional)</h6>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Password Baru</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password">
                        </div>
                    </div>
                    
                    <div class="mb-3 row">
                        <label class="col-sm-3 col-form-label">Konfirmasi Password</label>
                        <div class="col-sm-9">
                            <input type="password" class="form-control" name="password_confirmation">
                        </div>
                    </div>

                    <div class="d-flex justify-content-end">
                        <button type="submit" class="btn btn-primary">Simpan Perubahan</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
