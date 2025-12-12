@extends('layouts.app')

@section('title', 'Monitoring Logbook')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Monitoring Logbook Peserta</h1>
    </div>

    <div class="card shadow-sm mb-4">
        <div class="card-body">
            <form class="row g-3" method="GET" action="{{ route('logbook.index') }}">
                <div class="col-md-3">
                    <label class="form-label">Periode</label>
                    <select class="form-select select2-filter" name="periode_id" data-placeholder="Semua Periode">
                        <option value="">Semua Periode</option>
                        @foreach(($periodes ?? []) as $periode)
                            <option value="{{ $periode->id }}" @selected(($selectedPeriodeId ?? null) == $periode->id)>
                                {{ $periode->nama_periode }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">Unit</label>
                    <select class="form-select select2-filter" name="unit_id" data-placeholder="Semua Unit">
                        <option value="">Semua Unit</option>
                        @foreach(($units ?? []) as $unit)
                            <option value="{{ $unit->id }}" @selected(($selectedUnitId ?? null) == $unit->id)>
                                {{ $unit->nama_unit_bisnis }}
                            </option>
                        @endforeach
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary w-100">Filter</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="logbookTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>Tanggal</th>
                            <th>Nama Peserta</th>
                            <th>Unit</th>
                            <th>Kegiatan</th>
                            <th>Status</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($logbooks as $logbook)
                            <tr>
                                <td>{{ \Carbon\Carbon::parse($logbook->tanggal_logbook)->format('d M Y') }}</td>
                                <td>{{ $logbook->magang->mahasiswa->nama_lengkap ?? 'N/A' }}</td>
                                <td>{{ $logbook->magang->unitBisnis->nama_unit_bisnis ?? 'N/A' }}</td>
                                <td>{{ Str::limit($logbook->deskripsi_kegiatan, 30) }}</td>
                                <td>
                                    @if ($logbook->status == 'pending')
                                        <span class="badge bg-warning text-dark">Menunggu</span>
                                    @elseif($logbook->status == 'approved')
                                        <span class="badge bg-success">Disetujui</span>
                                    @else
                                        <span class="badge bg-danger">Ditolak</span>
                                    @endif
                                </td>
                                <td>
                                    <a href="{{ route('logbook.show', $logbook) }}" class="btn btn-sm btn-info text-white"
                                        title="Lihat Detail"><i class="fas fa-eye"></i></a>
                                    <form action="{{ route('logbook.destroy', $logbook) }}" method="POST"
                                        class="d-inline-block delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-sm btn-danger delete-btn" title="Delete"><i
                                                class="fas fa-trash"></i></button>
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

@push('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <style>
        .select2-container--default .select2-selection--single {
            height: 38px;
            padding: 5px 12px;
            border: 1px solid #ced4da;
            border-radius: .375rem;
        }
        .select2-container--default .select2-selection--single .select2-selection__rendered {
            line-height: 26px;
        }
        .select2-container--default .select2-selection--single .select2-selection__arrow {
            height: 36px;
        }
    </style>
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <script>
        $(document).ready(function() {
            $('.select2-filter').select2({
                width: '100%',
                allowClear: true,
                placeholder: function() {
                    return $(this).data('placeholder');
                }
            });

            $('#logbookTable').DataTable({
                "order": [
                    [0, "desc"]
                ]
            });

            $('.delete-btn').on('click', function(e) {
                e.preventDefault();
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Hapus Logbook?',
                    text: "Data yang dihapus tidak dapat dikembalikan!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#3085d6',
                    confirmButtonText: 'Ya, hapus!',
                    cancelButtonText: 'Batal'
                }).then((result) => {
                    if (result.isConfirmed) {
                        form.submit();
                    }
                });
            });
        });
    </script>
@endpush
