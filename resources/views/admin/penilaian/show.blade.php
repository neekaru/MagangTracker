@extends('layouts.app')

@section('title', 'Detail Penilaian')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Detail Penilaian: Siti Aminah</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <a href="{{ url('/admin/penilaian') }}" class="btn btn-sm btn-secondary">
            <i class="fas fa-arrow-left"></i> Kembali
        </a>
        <a href="{{ url('/admin/penilaian/1/edit') }}" class="btn btn-sm btn-warning ms-2">
            <i class="fas fa-edit"></i> Edit Nilai
        </a>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h1 class="display-1 fw-bold text-primary">87.5</h1>
                <p class="lead">Nilai Akhir</p>
                <span class="badge bg-success fs-5">LULUS</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                Rincian Nilai
            </div>
            <div class="card-body">
                <h5 class="card-title">Nilai Pembimbing Lapangan</h5>
                <table class="table table-sm table-bordered mb-4">
                    <tr>
                        <td>Kedisiplinan</td>
                        <td width="20%" class="text-center">85</td>
                    </tr>
                    <tr>
                        <td>Tanggung Jawab</td>
                        <td class="text-center">85</td>
                    </tr>
                    <tr>
                        <td>Kemampuan Teknis</td>
                        <td class="text-center">85</td>
                    </tr>
                    <tr class="table-light fw-bold">
                        <td>Rata-rata</td>
                        <td class="text-center">85</td>
                    </tr>
                </table>

                <h5 class="card-title">Nilai Dosen Pembimbing</h5>
                <table class="table table-sm table-bordered">
                    <tr>
                        <td>Laporan Akhir</td>
                        <td width="20%" class="text-center">90</td>
                    </tr>
                    <tr>
                        <td>Presentasi</td>
                        <td class="text-center">90</td>
                    </tr>
                    <tr class="table-light fw-bold">
                        <td>Rata-rata</td>
                        <td class="text-center">90</td>
                    </tr>
                </table>
                
                <div class="alert alert-info mt-3">
                    <small><strong>Catatan:</strong> Nilai akhir dihitung dengan bobot 60% dari Pembimbing Lapangan dan 40% dari Dosen Pembimbing.</small>
                </div>
            </div>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-header">
                Catatan
            </div>
            <div class="card-body">
                <p><em>"Mahasiswa sangat rajin dan proaktif dalam menyelesaikan tugas. Perlu ditingkatkan lagi dalam hal dokumentasi teknis."</em> - Pembimbing Lapangan</p>
            </div>
        </div>
    </div>
</div>
@endsection
