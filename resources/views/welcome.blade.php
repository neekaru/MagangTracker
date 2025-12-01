<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MagangTracking - Sistem Manajemen Magang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .hero-section {
            background: linear-gradient(rgba(0,0,0,0.6), rgba(0,0,0,0.6)), url('https://images.unsplash.com/photo-1497366216548-37526070297c?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }
        .hero-content {
            max-width: 800px;
            padding: 20px;
        }
    </style>
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
        <div class="container">
            <a class="navbar-brand" href="#">MagangTracking</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item"><a class="nav-link" href="#fitur">Fitur</a></li>
                    <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                    <li class="nav-item"><a class="nav-link btn btn-primary text-white ms-2" href="{{ url('/register-magang') }}">Daftar Magang</a></li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="hero-content">
            <h1 class="display-4 fw-bold">Sistem Manajemen Data Karyawan Magang</h1>
            <p class="lead mb-4">Kelola pendaftaran, logbook, absensi, dan penilaian magang dengan mudah, transparan, dan paperless.</p>
            <a href="{{ url('/login') }}" class="btn btn-lg btn-primary me-2">Masuk Sekarang</a>
            <a href="#fitur" class="btn btn-lg btn-outline-light">Pelajari Lebih Lanjut</a>
        </div>
    </div>

    <div id="fitur" class="container py-5">
        <div class="row text-center">
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5">Pendaftaran Mudah</h3>
                        <p>Daftar magang secara online dan pantau status penerimaan anda secara real-time.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5">Logbook Digital</h3>
                        <p>Isi kegiatan harian dan absensi langsung dari perangkat anda tanpa perlu kertas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-4 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <h3 class="h5">Penilaian Transparan</h3>
                        <p>Dapatkan penilaian kinerja dari pembimbing secara objektif dan terukur.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <footer class="bg-dark text-white text-center py-3">
        <p class="mb-0">&copy; 2025 Politeknik Sampit. All rights reserved.</p>
    </footer>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
