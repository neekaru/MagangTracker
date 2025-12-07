@extends('layouts.app')

@section('title', 'Logbook Mahasiswa Bimbingan')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Logbook Mahasiswa Bimbingan</h1>
</div>

<div class="card shadow-sm">
    <div class="card-body">
        <div class="table-responsive">
            <table id="logbookTable" class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Mahasiswa</th>
                        <th>Tanggal</th>
                        <th>Deskripsi</th>
                        <th>Status</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($logbooks as $logbook)
                    <tr>
                        <td>{{ $logbook->magang->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                        <td>{{ \Carbon\Carbon::parse($logbook->tanggal_logbook)->translatedFormat('d F Y') }}</td>
                        <td>{{ Str::limit($logbook->deskripsi_kegiatan, 50) }}</td>
                        <td>
                            @if($logbook->status == 'approved')
                                <span class="badge bg-success">Approved</span>
                            @elseif($logbook->status == 'rejected')
                                <span class="badge bg-danger">Rejected</span>
                            @else
                                <span class="badge bg-warning text-dark">Pending</span>
                            @endif
                        </td>
                        <td>
                            <form action="{{ route('pembimbing.logbook.update', $logbook) }}" method="POST">
                                @csrf
                                @method('PUT')
                                <select name="status" class="form-select form-select-sm" onchange="this.form.submit()">
                                    <option value="pending" {{ $logbook->status == 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="approved" {{ $logbook->status == 'approved' ? 'selected' : '' }}>Approve</option>
                                    <option value="rejected" {{ $logbook->status == 'rejected' ? 'selected' : '' }}>Reject</option>
                                </select>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#logbookTable').DataTable({
            "language": {
                "emptyTable": "Belum ada data logbook",
                "zeroRecords": "Tidak ada data yang cocok",
                "info": "Menampilkan _START_ sampai _END_ dari _TOTAL_ data",
                "infoEmpty": "Menampilkan 0 sampai 0 dari 0 data",
                "infoFiltered": "(disaring dari _MAX_ total data)",
                "search": "Cari:",
                "paginate": {
                    "first": "Pertama",
                    "last": "Terakhir",
                    "next": "Selanjutnya",
                    "previous": "Sebelumnya"
                },
                "lengthMenu": "Tampilkan _MENU_ data per halaman"
            },
            "order": [[1, "desc"]], // Sort by date descending
            "columnDefs": [
                { "orderable": false, "targets": 4 } // Disable sorting on action column
            ]
        });
    });
</script>
@endpush
