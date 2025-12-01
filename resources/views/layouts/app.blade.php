<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sistem Magang') - MagangTracking</title>
    <!-- Bootstrap 5 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- FontAwesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- DataTables CSS -->
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css">
    <style>
        body {
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-color: #f8f9fa;
        }
        .wrapper {
            display: flex;
            width: 100%;
            align-items: stretch;
            flex: 1;
        }
        #sidebar {
            min-width: 250px;
            max-width: 250px;
            background: #343a40;
            color: #fff;
            transition: all 0.3s;
        }
        #sidebar.active {
            margin-left: -250px;
        }
        #sidebar .sidebar-header {
            padding: 20px;
            background: #343a40;
        }
        #sidebar ul.components {
            padding: 20px 0;
            border-bottom: 1px solid #4b545c;
        }
        #sidebar ul p {
            color: #fff;
            padding: 10px;
        }
        #sidebar ul li a {
            padding: 10px;
            font-size: 1.1em;
            display: block;
            color: #fff;
            text-decoration: none;
        }
        #sidebar ul li a:hover {
            color: #343a40;
            background: #fff;
        }
        #sidebar ul li.active > a {
            color: #fff;
            background: #0d6efd;
        }
        #content {
            width: 100%;
            padding: 20px;
            min-height: 100vh;
            transition: all 0.3s;
        }
        .navbar {
            padding: 15px 10px;
            background: #fff;
            border: none;
            border-radius: 0;
            margin-bottom: 40px;
            box-shadow: 1px 1px 3px rgba(0, 0, 0, 0.1);
        }
        @media (max-width: 768px) {
            #sidebar {
                margin-left: -250px;
            }
            #sidebar.active {
                margin-left: 0;
            }
            #sidebarCollapse span {
                display: none;
            }
        }
    </style>
    @stack('styles')
</head>
<body>

    <div class="wrapper">
        <!-- Sidebar -->
        @if(Auth::check() || request()->is('admin*') || request()->is('pembimbing*') || request()->is('mahasiswa*'))
        <nav id="sidebar">
            <div class="sidebar-header">
                <h3>MagangTracking</h3>
            </div>

            <ul class="list-unstyled components">
                <p>Role: {{ Auth::user()->role ?? (request()->is('admin*') ? 'Admin' : (request()->is('pembimbing*') ? 'Pembimbing' : 'Mahasiswa')) }}</p>
                
                @if(request()->is('admin*'))
                    <li class="{{ request()->is('admin') ? 'active' : '' }}">
                        <a href="{{ url('/admin') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                    </li>
                    <li class="{{ request()->is('admin/users*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/users') }}"><i class="fas fa-users me-2"></i> Users</a>
                    </li>
                    <li class="{{ request()->is('admin/magang*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/magang') }}"><i class="fas fa-user-graduate me-2"></i> Data Magang</a>
                    </li>
                    <li class="{{ request()->is('admin/periode-magang*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/periode-magang') }}"><i class="fas fa-calendar-alt me-2"></i> Periode</a>
                    </li>
                    <li class="{{ request()->is('admin/logbook*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/logbook') }}"><i class="fas fa-book me-2"></i> Logbook</a>
                    </li>
                    <li class="{{ request()->is('admin/absensi*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/absensi') }}"><i class="fas fa-clock me-2"></i> Absensi</a>
                    </li>
                    <li class="{{ request()->is('admin/penilaian*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/penilaian') }}"><i class="fas fa-star me-2"></i> Penilaian</a>
                    </li>
                    <li class="{{ request()->is('admin/laporan*') ? 'active' : '' }}">
                        <a href="{{ url('/admin/laporan') }}"><i class="fas fa-file-alt me-2"></i> Laporan</a>
                    </li>
                @elseif(request()->is('pembimbing*'))
                    <li class="{{ request()->is('pembimbing') ? 'active' : '' }}">
                        <a href="{{ url('/pembimbing') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                    </li>
                    <li class="{{ request()->is('pembimbing/peserta*') ? 'active' : '' }}">
                        <a href="{{ url('/pembimbing/peserta') }}"><i class="fas fa-users me-2"></i> Peserta Bimbingan</a>
                    </li>
                    <li class="{{ request()->is('pembimbing/penilaian*') ? 'active' : '' }}">
                        <a href="{{ url('/pembimbing/penilaian') }}"><i class="fas fa-star me-2"></i> Penilaian</a>
                    </li>
                    <li class="{{ request()->is('pembimbing/laporan*') ? 'active' : '' }}">
                        <a href="{{ url('/pembimbing/laporan') }}"><i class="fas fa-file-alt me-2"></i> Laporan</a>
                    </li>
                @elseif(request()->is('mahasiswa*'))
                    <li class="{{ request()->is('mahasiswa') ? 'active' : '' }}">
                        <a href="{{ url('/mahasiswa') }}"><i class="fas fa-tachometer-alt me-2"></i> Dashboard</a>
                    </li>
                    <li class="{{ request()->is('mahasiswa/profil*') ? 'active' : '' }}">
                        <a href="{{ url('/mahasiswa/profil') }}"><i class="fas fa-user me-2"></i> Profil</a>
                    </li>
                    <li class="{{ request()->is('mahasiswa/magang*') ? 'active' : '' }}">
                        <a href="{{ url('/mahasiswa/magang') }}"><i class="fas fa-info-circle me-2"></i> Info Magang</a>
                    </li>
                    <li class="{{ request()->is('mahasiswa/logbook*') ? 'active' : '' }}">
                        <a href="{{ url('/mahasiswa/logbook') }}"><i class="fas fa-book me-2"></i> Logbook</a>
                    </li>
                    <li class="{{ request()->is('mahasiswa/absensi*') ? 'active' : '' }}">
                        <a href="{{ url('/mahasiswa/absensi') }}"><i class="fas fa-clock me-2"></i> Absensi</a>
                    </li>
                    <li class="{{ request()->is('mahasiswa/nilai*') ? 'active' : '' }}">
                        <a href="{{ url('/mahasiswa/nilai') }}"><i class="fas fa-star me-2"></i> Nilai</a>
                    </li>
                @endif
            </ul>
        </nav>
        @endif

        <!-- Page Content -->
        <div id="content">
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <div class="container-fluid">
                    @if(Auth::check() || request()->is('admin*') || request()->is('pembimbing*') || request()->is('mahasiswa*'))
                    <button type="button" id="sidebarCollapse" class="btn btn-info text-white">
                        <i class="fas fa-align-left"></i>
                        <span>Toggle Sidebar</span>
                    </button>
                    @endif
                    
                    <a class="navbar-brand ms-3" href="{{ url('/') }}">MagangTracking</a>

                    <button class="btn btn-dark d-inline-block d-lg-none ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <i class="fas fa-align-justify"></i>
                    </button>

                    <div class="collapse navbar-collapse" id="navbarSupportedContent">
                        <ul class="nav navbar-nav ms-auto">
                            @if(!Auth::check() && !request()->is('admin*') && !request()->is('pembimbing*') && !request()->is('mahasiswa*'))
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/login') }}">Login</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('/register-magang') }}">Daftar Magang</a>
                                </li>
                            @else
                                <li class="nav-item dropdown">
                                    <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                        {{ Auth::user()->name ?? 'User Demo' }}
                                    </a>
                                    <ul class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                        <li><a class="dropdown-item" href="#">Profile</a></li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="{{ url('/logout') }}" method="POST">
                                                @csrf
                                                <button type="submit" class="dropdown-item">Logout</button>
                                            </form>
                                        </li>
                                    </ul>
                                </li>
                            @endif
                        </ul>
                    </div>
                </div>
            </nav>

            <div class="container-fluid">
                @yield('content')
            </div>
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- jQuery (Required for DataTables) -->
    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <!-- SweetAlert2 -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function(){
            const sidebarCollapse = document.getElementById('sidebarCollapse');
            if(sidebarCollapse){
                sidebarCollapse.addEventListener('click', function () {
                    document.getElementById('sidebar').classList.toggle('active');
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
