@extends('layouts.app')

@section('title', 'Nilai Akhir Magang')

@section('content')
<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
    <h1 class="h2">Nilai Akhir Magang</h1>
    <div class="btn-toolbar mb-2 mb-md-0">
        <button class="btn btn-sm btn-primary" onclick="window.print()">
            <i class="fas fa-print"></i> Cetak Transkrip
        </button>
    </div>
</div>

<div class="row">
    <div class="col-md-4">
        <div class="card shadow-sm mb-4">
            <div class="card-body text-center">
                <h6 class="text-muted mb-3">Nilai Akhir</h6>
                <h1 class="display-1 fw-bold text-primary">87.5</h1>
                <span class="badge bg-success fs-5 mt-2">LULUS</span>
            </div>
        </div>
    </div>
    
    <div class="col-md-8">
        <div class="card shadow-sm mb-4">
            <div class="card-header">
                Rincian Penilaian
            </div>
            <div class="card-body">
                <h5 class="card-title">Nilai Pembimbing Lapangan (Bobot 60%)</h5>
                <table class="table table-sm table-bordered mb-4">
                    <thead class="table-light">
                        <tr>
                            <th>Komponen</th>
                            <th width="20%" class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Kedisiplinan</td>
                            <td class="text-center">85</td>
                        </tr>
                        <tr>
                            <td>Tanggung Jawab</td>
                            <td class="text-center">85</td>
                        </tr>
                        <tr>
                            <td>Kemampuan Teknis</td>
                            <td class="text-center">85</td>
                        </tr>
                        <tr>
                            <td>Kerjasama Tim</td>
                            <td class="text-center">90</td>
                        </tr>
                        <tr>
                            <td>Etika & Perilaku</td>
                            <td class="text-center">85</td>
                        </tr>
                        <tr class="fw-bold table-secondary">
                            <td>Rata-rata</td>
                            <td class="text-center">86.0</td>
                        </tr>
                    </tbody>
                </table>

                <h5 class="card-title">Nilai Dosen Pembimbing (Bobot 40%)</h5>
                <table class="table table-sm table-bordered">
                    <thead class="table-light">
                        <tr>
                            <th>Komponen</th>
                            <th width="20%" class="text-center">Nilai</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>Laporan Akhir</td>
                            <td class="text-center">90</td>
                        </tr>
                        <tr>
                            <td>Presentasi</td>
                            <td class="text-center">90</td>
                        </tr>
                        <tr class="fw-bold table-secondary">
                            <td>Rata-rata</td>
                            <td class="text-center">90.0</td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        
        <div class="card shadow-sm">
            <div class="card-header">
                Catatan Pembimbing
            </div>
            <div class="card-body">
                <figure>
                    <blockquote class="blockquote">
                        <p>"Mahasiswa sangat rajin dan proaktif dalam menyelesaikan tugas. Perlu ditingkatkan lagi dalam hal dokumentasi teknis, namun secara keseluruhan kinerja sangat memuaskan."</p>
                    </blockquote>
                    <figcaption class="blockquote-footer">
                        Pak Budi <cite title="Source Title">(Dosen Pembimbing)</cite>
                    </figcaption>
                </figure>
            </div>
        </div>
    </div>
</div>
@endsection
