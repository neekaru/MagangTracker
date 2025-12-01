@extends('layouts.app')

@section('title', 'Data Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Peserta Magang</h1>
</div>

<ul class="nav nav-tabs mb-3" id="magangTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">Aktif</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Pendaftaran Baru <span class="badge bg-danger">2</span></button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="finished-tab" data-bs-toggle="tab" data-bs-target="#finished" type="button" role="tab">Selesai</button>
    </li>
</ul>

<div class="tab-content" id="magangTabContent">
    <!-- Tab Aktif -->
    <div class="tab-pane fade show active" id="active" role="tabpanel">
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="tableActive" class="table table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>Nama Peserta</th>
                            <th>NIM</th>
                            <th>Unit Magang</th>
                            <th>Periode</th>
                            <th>Pembimbing</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Siti Aminah</td>
                            <td>C030320005</td>
                            <td>IT Support</td>
                            <td>Jan 2025 - Jun 2025</td>
                            <td>Pak Budi</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        <tr>
                            <td>Rudi Hartono</td>
                            <td>C030320008</td>
                            <td>Keuangan</td>
                            <td>Jan 2025 - Jun 2025</td>
                            <td>Bu Ani</td>
                            <td>
                                <a href="#" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Pending -->
    <div class="tab-pane fade" id="pending" role="tabpanel">
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="tablePending" class="table table-striped table-hover w-100">
                    <thead>
                        <tr>
                            <th>Nama Peserta</th>
                            <th>NIM</th>
                            <th>Unit Tujuan</th>
                            <th>Tanggal Pengajuan</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Dewi Sartika</td>
                            <td>C030320012</td>
                            <td>HRD</td>
                            <td>01 Des 2025</td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="fas fa-check"></i> Terima</button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Tolak</button>
                            </td>
                        </tr>
                        <tr>
                            <td>Joko Widodo</td>
                            <td>C030320015</td>
                            <td>Umum</td>
                            <td>30 Nov 2025</td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="fas fa-check"></i> Terima</button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Tolak</button>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Selesai -->
    <div class="tab-pane fade" id="finished" role="tabpanel">
        <div class="card shadow-sm">
            <div class="card-body">
                <p class="text-muted">Belum ada data magang yang selesai.</p>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#tableActive').DataTable();
        $('#tablePending').DataTable();
    });
</script>
@endpush
