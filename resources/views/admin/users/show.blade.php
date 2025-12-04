@extends('layouts.app')

@section('title', 'Detail User')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail User: {{ $user->email }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('users.edit', $user->id) }}" class="btn btn-sm btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('users.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    @php
                        $name = '';
                        if ($user->role === 'Pembimbing' && $user->dosen) {
                            $name = $user->dosen->nama_lengkap;
                        } elseif ($user->role === 'Mahasiswa' && $user->mahasiswa) {
                            $name = 'NISN: ' . $user->mahasiswa->nisn;
                        } else {
                            $name = 'Admin';
                        }
                    @endphp
                    <img src="https://ui-avatars.com/api/?name={{ urlencode($name) }}&background=random"
                        class="rounded-circle mb-3" width="100">
                    <h5>{{ $name }}</h5>
                    <p class="text-muted mb-1">{{ $user->email }}</p>
                    @if ($user->role === 'Admin')
                        <span class="badge bg-danger">Admin</span>
                    @elseif($user->role === 'Pembimbing')
                        <span class="badge bg-info text-dark">Pembimbing</span>
                    @else
                        <span class="badge bg-secondary">Mahasiswa</span>
                    @endif
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header">
                    Informasi Detail
                </div>
                <div class="card-body">
                    <table class="table table-borderless">
                        <tr>
                            <th width="30%">Email</th>
                            <td>{{ $user->email }}</td>
                        </tr>
                        <tr>
                            <th>Role</th>
                            <td>{{ $user->role }}</td>
                        </tr>

                        @if ($user->role === 'Pembimbing' && $user->dosen)
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $user->dosen->nama_lengkap }}</td>
                            </tr>
                            <tr>
                                <th>NIP</th>
                                <td>{{ $user->dosen->nip ?? '-' }}</td>
                            </tr>
                        @endif

                        @if ($user->role === 'Mahasiswa' && $user->mahasiswa)
                            <tr>
                                <th>Nama Lengkap</th>
                                <td>{{ $user->mahasiswa->nama_lengkap ?? '-' }}</td>
                            </tr>
                            <tr>
                                <th>NISN</th>
                                <td>{{ $user->mahasiswa->nisn }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Mulai</th>
                                <td>{{ $user->mahasiswa->tanggal_mulai->format('d M Y') }}</td>
                            </tr>
                            <tr>
                                <th>Tanggal Selesai</th>
                                <td>{{ $user->mahasiswa->tanggal_selesai->format('d M Y') }}</td>
                            </tr>
                        @endif

                        <tr>
                            <th>Status Akun</th>
                            <td><span class="badge bg-success">Aktif</span></td>
                        </tr>
                        <tr>
                            <th>Terdaftar Sejak</th>
                            <td>{{ $user->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $user->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if ($user->role === 'Mahasiswa' && $user->mahasiswa)
                <div class="card shadow-sm mt-3">
                    <div class="card-header">
                        Informasi Magang
                    </div>
                    <div class="card-body">
                        @php
                            $magang = $user->mahasiswa
                                ->magang()
                                ->with(['unitBisnis', 'dosen', 'periodeMagang'])
                                ->first();
                        @endphp

                        @if ($magang)
                            <table class="table table-borderless">
                                <tr>
                                    <th width="30%">Unit Bisnis</th>
                                    <td>{{ $magang->unitBisnis->nama_unit_bisnis ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pembimbing Dosen</th>
                                    <td>{{ $magang->dosen->nama_lengkap ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Pembimbing Lapangan</th>
                                    <td>{{ $magang->pembimbing_lapangan }}</td>
                                </tr>
                                <tr>
                                    <th>Periode</th>
                                    <td>{{ $magang->periodeMagang->nama_periode ?? '-' }}</td>
                                </tr>
                                <tr>
                                    <th>Status Magang</th>
                                    <td>
                                        @if ($magang->status_magang === 'Aktif')
                                            <span class="badge bg-success">Aktif</span>
                                        @elseif($magang->status_magang === 'selesai')
                                            <span class="badge bg-primary">Selesai</span>
                                        @else
                                            <span class="badge bg-secondary">{{ $magang->status_magang }}</span>
                                        @endif
                                    </td>
                                </tr>
                                <tr>
                                    <th>Target Logbook Mingguan</th>
                                    <td>{{ $magang->target_book_mingguan }} entry</td>
                                </tr>
                            </table>
                        @else
                            <p class="text-muted">Belum ada data magang</p>
                        @endif
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
