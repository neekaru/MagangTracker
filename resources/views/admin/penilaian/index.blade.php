@extends('layouts.app')

@section('title', 'Penilaian Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Penilaian Akhir Magang</h1>
</div>

@if(session('success'))
<div class="alert alert-success alert-dismissible fade show" role="alert">
    {{ session('success') }}
    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
</div>
@endif

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="penilaianTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Peserta</th>
                        <th>NIM</th>
                        <th>Unit</th>
                        <th>Pembimbing</th>
                        <th>Nilai Akhir</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($penilaianList as $penilaian)
                    @php
                        $average = ($penilaian->nilai_kedisplinan + 
                                   $penilaian->nilai_tanggung_jawab + 
                                   $penilaian->nilai_kemampuan_teknis + 
                                   $penilaian->nilai_laporan_akhir + 
                                   $penilaian->nilai_prestasi) / 5;
                    @endphp
                    <tr>
                        <td>{{ $penilaian->magang->mahasiswa->nama_lengkap ?? $penilaian->magang->mahasiswa->user->name }}</td>
                        <td>{{ $penilaian->magang->mahasiswa->nim }}</td>
                        <td>{{ $penilaian->magang->unitBisnis->nama_unit_bisnis ?? '-' }}</td>
                        <td>{{ $penilaian->penilai->nama_lengkap ?? '-' }}</td>
                        <td><strong>{{ number_format($average, 2) }}</strong></td>
                        <td>
                            @if($average >= 60)
                                <span class="badge bg-success">Lulus</span>
                            @else
                                <span class="badge bg-danger">Tidak Lulus</span>
                            @endif
                        </td>
                        <td>
                            <a href="{{ route('penilaian.show', $penilaian->id) }}" class="btn btn-sm btn-info text-white" title="Lihat Detail">
                                <i class="fas fa-eye"></i>
                            </a>
                            <a href="{{ route('penilaian.edit', $penilaian->id) }}" class="btn btn-sm btn-warning" title="Edit">
                                <i class="fas fa-edit"></i>
                            </a>
                            <form action="{{ route('penilaian.destroy', $penilaian->id) }}" method="POST" class="d-inline" 
                                  onsubmit="return confirm('Apakah Anda yakin ingin menghapus penilaian ini?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-sm btn-danger" title="Hapus">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        
        {{ $penilaianList->links() }}
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#penilaianTable').DataTable({
            "paging": false, // Pagination handled by Laravel
            "info": false,
            "language": {
                "emptyTable": "Belum ada data penilaian",
                "zeroRecords": "Tidak ada data yang cocok",
                "search": "Cari:",
                "lengthMenu": "Tampilkan _MENU_ data per halaman"
            },
            "columnDefs": [
                { "orderable": false, "targets": 6 } // Disable sorting on action column
            ]
        });
    });
</script>
@endpush
