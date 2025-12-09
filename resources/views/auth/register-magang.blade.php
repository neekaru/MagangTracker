<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Magang - MagangTracking</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            position: relative;
            overflow-y: auto;
            overflow-x: hidden;
            min-height: 100vh;
        }
        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0,0,0,0.5), rgba(0,0,0,0.5)), url('https://images.unsplash.com/photo-1497366754035-f200968a6e72?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            filter: blur(4px);
            z-index: -1;
        }
        .card {
            background: rgba(255, 255, 255, 0.95);
        }
    </style>

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h4 class="mb-0">Formulir Pendaftaran Magang</h4>
                </div>
                <div class="card-body">
                    <div class="alert alert-info">
                        <h5>Pendaftaran Magang Dinonaktifkan</h5>
                        <p>Pendaftaran magang melalui aplikasi telah dinonaktifkan. Jika Anda perlu mendaftar magang, silakan hubungi Admin atau datang ke kantor administrasi.</p>
                    </div>
                    <div class="d-grid gap-2 mt-3">
                        <a href="{{ url('/') }}" class="btn btn-outline-secondary">Kembali ke Beranda</a>
                        <a href="{{ route('mahasiswa.magang.index') }}" class="btn btn-primary">Lihat Status Magang</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
