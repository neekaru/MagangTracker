@extends('layouts.app')

@section('title', 'Laporan')

@section('content')
    <div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
        <h1 class="h2">Generate Laporan</h1>
    </div>

    <div class="row">
        <div class="col-md-6">
            <div class="card shadow-sm">
                <div class="card-header bg-light">
                    <h5 class="mb-0">Filter Laporan</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.laporan.export-pdf') }}" method="GET" id="laporanForm">
                        <div class="mb-3">
                            <label class="form-label">Periode Magang</label>
                            <select class="form-select" name="periode_id">
                                <option value="">Semua Periode</option>
                                @foreach ($periodes as $periode)
                                    <option value="{{ $periode->id }}">{{ $periode->nama_periode }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Unit Kerja</label>
                            <select class="form-select" name="unit_id">
                                <option value="">Semua Unit</option>
                                @foreach ($units as $unit)
                                    <option value="{{ $unit->id }}">{{ $unit->nama_unit_bisnis }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Status Magang</label>
                            <select class="form-select" name="status">
                                <option value="">Semua Status</option>
                                <option value="Aktif">Aktif</option>
                                <option value="Nonaktif">Nonaktif</option>
                                <option value="Selesai">Selesai</option>
                            </select>
                        </div>
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-danger"
                                formaction="{{ route('admin.laporan.export-pdf') }}">
                                <i class="fas fa-file-pdf"></i> Download PDF
                            </button>
                            <button type="submit" class="btn btn-success"
                                formaction="{{ route('admin.laporan.export-excel') }}">
                                <i class="fas fa-file-excel"></i> Download Excel
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
