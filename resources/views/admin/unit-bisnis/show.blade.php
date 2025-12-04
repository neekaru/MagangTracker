@extends('layouts.app')

@section('title', 'Detail Unit Bisnis')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Detail Unit Bisnis: {{ $unit->nama_unit_bisnis }}</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('unit-bisnis.edit', $unit->id) }}" class="btn btn-sm btn-warning me-2">
                <i class="fas fa-edit"></i> Edit
            </a>
            <a href="{{ route('unit-bisnis.index') }}" class="btn btn-sm btn-secondary">
                <i class="fas fa-arrow-left"></i> Kembali
            </a>
        </div>
    </div>

    <div class="row">
        <div class="col-md-4">
            <div class="card shadow-sm mb-4">
                <div class="card-body text-center">
                    <i class="fas fa-building fa-4x text-primary mb-3"></i>
                    <h5>{{ $unit->nama_unit_bisnis }}</h5>
                    <p class="text-muted mb-1">Unit Bisnis</p>
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
                            <th width="30%">Nama Unit Bisnis</th>
                            <td>{{ $unit->nama_unit_bisnis }}</td>
                        </tr>
                        <tr>
                            <th>Jumlah Mahasiswa Magang</th>
                            <td>
                                <span class="badge bg-info">{{ $unit->magang->count() }} Mahasiswa</span>
                            </td>
                        </tr>
                        <tr>
                            <th>Terdaftar Sejak</th>
                            <td>{{ $unit->created_at->format('d M Y H:i') }}</td>
                        </tr>
                        <tr>
                            <th>Terakhir Diupdate</th>
                            <td>{{ $unit->updated_at->format('d M Y H:i') }}</td>
                        </tr>
                    </table>
                </div>
            </div>

            @if ($unit->magang->count() > 0)
                <div class="card shadow-sm mt-3">
                    <div class="card-header">
                        Daftar Mahasiswa Magang
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-sm table-hover">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>Nama Mahasiswa</th>
                                        <th>Pembimbing Dosen</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($unit->magang as $index => $magang)
                                        <tr>
                                            <td>{{ $index + 1 }}</td>
                                            <td>
                                                {{ $magang->mahasiswa->nama_lengkap ?? 'NISN: ' . $magang->mahasiswa->nisn }}
                                            </td>
                                            <td>{{ $magang->dosen->nama_lengkap ?? '-' }}</td>
                                            <td>
                                                @if ($magang->status_magang === 'Aktif')
                                                    <span class="badge bg-success">Aktif</span>
                                                @else
                                                    <span class="badge bg-secondary">{{ $magang->status_magang }}</span>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            @endif
        </div>
    </div>
@endsection
