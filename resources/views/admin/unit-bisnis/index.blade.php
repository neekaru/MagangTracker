@extends('layouts.app')

@section('title', 'Unit Bisnis')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Manajemen Unit Bisnis</h1>
        <div class="btn-toolbar mb-2 mb-md-0">
            <a href="{{ route('unit-bisnis.create') }}" class="btn btn-sm btn-primary">
                <i class="fas fa-plus"></i> Tambah Unit Bisnis
            </a>
        </div>
    </div>

    @if (session('success'))
        <div class="alert alert-success alert-dismissible fade show" role="alert">
            {{ session('success') }}
            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
        </div>
    @endif

    <div class="card shadow-sm">
        <div class="card-body">
            <div class="table-responsive">
                <table id="unitTable" class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>#</th>
                            <th>Nama Unit Bisnis</th>
                            <th>Periode</th>
                            <th>Jumlah Magang</th>
                            <th>Aksi</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($units as $index => $unit)
                            <tr>
                                <td>{{ $index + 1 }}</td>
                                <td>{{ $unit->nama_unit_bisnis }}</td>
                                <td>{{ $unit->periode->nama_periode ?? 'N/A' }}</td>
                                <td>
                                    <span class="badge bg-info">{{ $unit->magang->count() }} Mahasiswa</span>
                                </td>
                                <td>
                                    <a href="{{ route('unit-bisnis.show', $unit->id) }}"
                                        class="btn btn-sm btn-info text-white">
                                        <i class="fas fa-eye"></i>
                                    </a>
                                    <a href="{{ route('unit-bisnis.edit', $unit->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fas fa-edit"></i>
                                    </a>
                                    <form action="{{ route('unit-bisnis.destroy', $unit->id) }}" method="POST"
                                        class="d-inline delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" class="btn btn-sm btn-danger delete-btn">
                                            <i class="fas fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center">Tidak ada data unit bisnis</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        $(document).ready(function() {
            $('#unitTable').DataTable();

            $('.delete-btn').click(function() {
                const form = $(this).closest('form');
                Swal.fire({
                    title: 'Hapus Unit Bisnis?',
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
                })
            });
        });
    </script>
@endpush
