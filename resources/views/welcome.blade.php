<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>MagangTracking - Sistem Manajemen Magang</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        .hero-section {
            position: relative;
            overflow: hidden;
            color: white;
            height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
        }

        .hero-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(rgba(0, 0, 0, 0.6), rgba(0, 0, 0, 0.6)), url('https://images.unsplash.com/photo-1486406146926-c627a92ad1ab?auto=format&fit=crop&w=1920&q=80');
            background-size: cover;
            background-position: center;
            filter: blur(1px);
            z-index: -1;
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
                    @auth
                        <li class="nav-item">
                            <a class="nav-link"
                                href="@if (auth()->user()->role == 'Admin') /admin @elseif(auth()->user()->role == 'Pembimbing')/pembimbing @else/mahasiswa @endif">Dashboard</a>
                        </li>
                    @else
                        <li class="nav-item"><a class="nav-link" href="{{ url('/login') }}">Login</a></li>
                    @endauth
                </ul>
            </div>
        </div>
    </nav>

    <div class="hero-section">
        <div class="hero-content">
            <h1 class="display-4 fw-bold">Sistem Manajemen Data Karyawan Magang</h1>
            <p class="lead mb-4">Sistem manajemen magang yang mudah, transparan, dan paperless untuk jurnal kegiatan
                serta absensi harian.</p>
            <a href="{{ url('/login') }}" class="btn btn-lg btn-primary me-2">Masuk Sekarang</a>
            <a href="#fitur" class="btn btn-lg btn-outline-light">Pelajari Lebih Lanjut</a>
        </div>
    </div>

    <div id="fitur" class="container py-5">
        <div class="row text-center">
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-book-open fa-3x text-success"></i>
                        </div>
                        <h3 class="h5">Jurnal Kegiatan Digital</h3>
                        <p>Isi kegiatan harian dan absensi langsung dari perangkat anda tanpa perlu kertas.</p>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card h-100 border-0 shadow-sm">
                    <div class="card-body">
                        <div class="mb-3">
                            <i class="fas fa-chart-line fa-3x text-info"></i>
                        </div>
                        <h3 class="h5">Monitoring Real-time</h3>
                        <p>Pantau progress magang dan aktivitas harian secara real-time dari dashboard.</p>
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
