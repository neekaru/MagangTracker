@extends('layouts.app')

@section('title', 'Data Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Data Peserta Magang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ route('magang.create') }}" class="btn btn-sm btn-primary">
            <i class="fas fa-plus"></i> Tambah Magang
        </a>
    </div>
</div>

<ul class="nav nav-tabs mb-3" id="magangTab" role="tablist">
    <li class="nav-item" role="presentation">
        <button class="nav-link active" id="active-tab" data-bs-toggle="tab" data-bs-target="#active" type="button" role="tab">Aktif</button>
    </li>
    <li class="nav-item" role="presentation">
        <button class="nav-link" id="pending-tab" data-bs-toggle="tab" data-bs-target="#pending" type="button" role="tab">Pendaftaran Baru @if($pending->count() > 0)<span class="badge bg-danger">{{ $pending->count() }}</span>@endif</button>
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
                        @forelse($aktif as $magang)
                        <tr>
                            <td>{{ $magang->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ $magang->mahasiswa->nisn ?? 'N/A' }}</td>
                            <td>{{ $magang->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</td>
                            <td>{{ $magang->periodeMagang->nama_periode ?? 'N/A' }}</td>
                            <td>{{ $magang->dosen->nama_lengkap ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('magang.show', $magang->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Detail</a>
                                <a href="{{ route('magang.edit', $magang->id) }}" class="btn btn-sm btn-warning"><i class="fas fa-edit"></i></a>
                                <form action="{{ route('magang.destroy', $magang->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-sm btn-danger delete-btn" onclick="return confirm('Hapus magang ini?')"><i class="fas fa-trash"></i></button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data magang aktif.</td>
                        </tr>
                        @endforelse
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
                        @forelse($pending as $magang)
                        <tr>
                            <td>{{ $magang->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ $magang->mahasiswa->nisn ?? 'N/A' }}</td>
                            <td>{{ $magang->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</td>
                            <td>{{ $magang->created_at->format('d M Y') }}</td>
                            <td>
                                <button class="btn btn-sm btn-success"><i class="fas fa-check"></i> Terima</button>
                                <button class="btn btn-sm btn-danger"><i class="fas fa-times"></i> Tolak</button>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" class="text-center">Belum ada pendaftaran baru.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <!-- Tab Selesai -->
    <div class="tab-pane fade" id="finished" role="tabpanel">
        <div class="card shadow-sm">
            <div class="card-body">
                <table id="tableFinished" class="table table-striped table-hover w-100">
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
                        @forelse($selesai as $magang)
                        <tr>
                            <td>{{ $magang->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                            <td>{{ $magang->mahasiswa->nisn ?? 'N/A' }}</td>
                            <td>{{ $magang->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</td>
                            <td>{{ $magang->periodeMagang->nama_periode ?? 'N/A' }}</td>
                            <td>{{ $magang->dosen->nama_lengkap ?? 'N/A' }}</td>
                            <td>
                                <a href="{{ route('magang.show', $magang->id) }}" class="btn btn-sm btn-info text-white"><i class="fas fa-eye"></i> Detail</a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" class="text-center">Belum ada data magang yang selesai.</td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        // Destroy existing DataTables if they exist
        if ($.fn.DataTable.isDataTable('#tableActive')) {
            $('#tableActive').DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable('#tablePending')) {
            $('#tablePending').DataTable().destroy();
        }
        if ($.fn.DataTable.isDataTable('#tableFinished')) {
            $('#tableFinished').DataTable().destroy();
        }

        // Initialize DataTables only when tab is shown and table has actual data (not just empty message)
        var activeRows = $('#tableActive tbody tr:not(:has(td[colspan]))');
        if (activeRows.length > 0) {
            $('#tableActive').DataTable();
        }
        
        $('button[data-bs-toggle="tab"]').on('shown.bs.tab', function (e) {
            var target = $(e.target).data('bs-target');
            
            if (target === '#pending' && !$.fn.DataTable.isDataTable('#tablePending')) {
                setTimeout(function() {
                    var pendingRows = $('#tablePending tbody tr:not(:has(td[colspan]))');
                    if (pendingRows.length > 0) {
                        $('#tablePending').DataTable();
                    }
                }, 100);
            } else if (target === '#finished' && !$.fn.DataTable.isDataTable('#tableFinished')) {
                setTimeout(function() {
                    var finishedRows = $('#tableFinished tbody tr:not(:has(td[colspan]))');
                    if (finishedRows.length > 0) {
                        $('#tableFinished').DataTable();
                    }
                }, 100);
            }
        });

        $('.delete-btn').click(function() {
            Swal.fire({
                title: 'Hapus Data Magang?',
                text: "Data yang dihapus tidak dapat dikembalikan!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    Swal.fire(
                        'Terhapus!',
                        'Data magang berhasil dihapus.',
                        'success'
                    )
                }
            })
        });
    });
</script>
@endpush
