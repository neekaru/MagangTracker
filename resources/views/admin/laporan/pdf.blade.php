<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Admin - Mahasiswa Magang</title>
    <style>
        @page {
            margin: 15mm;
        }

        body {
            font-family: Arial, sans-serif;
            font-size: 9px;
            line-height: 1.35;
            color: #000000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            padding-bottom: 15px;
            border-bottom: 3px solid #000000;
        }

        .header h1 {
            margin: 0 0 5px 0;
            font-size: 20px;
            color: #000000;
            font-weight: bold;
            text-transform: uppercase;
        }

        .header p {
            margin: 3px 0;
            font-size: 11px;
            color: #000000;
        }

        .info-box {
            background: #f0f0f0;
            color: #000000;
            padding: 12px;
            margin-bottom: 15px;
            border: 1px solid #cccccc;
        }

        .info-box h3 {
            margin: 0 0 8px 0;
            font-size: 13px;
            font-weight: bold;
        }

        .info-grid {
            display: table;
            width: 100%;
        }

        .info-row {
            display: table-row;
        }

        .info-label {
            display: table-cell;
            width: 150px;
            padding: 3px 0;
            font-weight: bold;
        }

        .info-value {
            display: table-cell;
            padding: 3px 0;
        }

        .stats-container {
            margin-bottom: 15px;
        }

        .stats-grid {
            display: table;
            width: 100%;
            border-collapse: separate;
            border-spacing: 8px 0;
        }

        .stat-box {
            display: table-cell;
            width: 24%;
            background: #f8f9fa;
            border-left: 4px solid #3498db;
            padding: 10px;
            text-align: center;
            color: #000000;
        }

        .stat-box.green {
            border-left-color: #27ae60;
        }

        .stat-box.orange {
            border-left-color: #f39c12;
        }

        .stat-box.red {
            border-left-color: #e74c3c;
        }

        .stat-box.purple {
            border-left-color: #9b59b6;
        }

        .stat-number {
            font-size: 20px;
            font-weight: bold;
            color: #000000;
            margin: 5px 0;
        }

        .stat-label {
            font-size: 9px;
            color: #000000;
            text-transform: uppercase;
        }

        .section-title {
            background: #000000;
            color: #ffffff;
            padding: 8px 12px;
            margin: 15px 0 10px 0;
            font-size: 12px;
            font-weight: bold;
            border-radius: 3px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            table-layout: fixed;
            margin-bottom: 15px;
            background: #ffffff;
        }

        th {
            background: #333333;
            color: #ffffff;
            padding: 8px 5px;
            text-align: left;
            font-size: 9px;
            font-weight: bold;
            border: 1px solid #000000;
        }

        td {
            padding: 6px 5px;
            border: 1px solid #ddd;
            font-size: 8px;
            color: #000000;
            word-wrap: break-word;
            overflow-wrap: break-word;
        }

        tr:nth-child(even) {
            background-color: #f8f9fa;
        }

        tr:hover {
            background-color: #e9ecef;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 7px;
            font-weight: bold;
            text-transform: uppercase;
        }

        .badge-success {
            background-color: #27ae60;
            color: white;
        }

        .badge-warning {
            background-color: #f39c12;
            color: white;
        }

        .badge-danger {
            background-color: #e74c3c;
            color: white;
        }

        .badge-info {
            background-color: #3498db;
            color: white;
        }

        .badge-secondary {
            background-color: #95a5a6;
            color: white;
        }

        .text-center {
            text-align: center;
        }

        .col-no {
            width: 3%;
        }

        .col-nim {
            width: 10%;
        }

        .col-nama {
            width: 16%;
        }

        .col-unit {
            width: 13%;
        }

        .col-dosen {
            width: 14%;
        }

        .col-periode {
            width: 11%;
        }

        .col-status {
            width: 7%;
        }

        .col-angka {
            width: 5%;
        }

        .col-persen {
            width: 7%;
        }

        .col-logbook {
            width: 9%;
        }

        .text-small {
            font-size: 7px;
            line-height: 1.25;
        }

        .text-right {
            text-align: right;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 2px solid #2c3e50;
            font-size: 8px;
            color: #000000;
        }

        .footer-left {
            float: left;
            width: 50%;
        }

        .footer-right {
            float: right;
            width: 50%;
            text-align: right;
        }

        .clearfix::after {
            content: "";
            display: table;
            clear: both;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h1>Laporan Mahasiswa Magang</h1>
        <p>Sistem Tracking Magang - Administrasi Akademik</p>
        <p style="font-size: 10px; color: #000000;">Dicetak pada: {{ $filterLabels['tanggal_generate'] }}</p>
    </div>

    <!-- Filter Info -->
    <div class="info-box">
        <h3>FILTER LAPORAN</h3>
        <div class="info-grid">
            <div class="info-row">
                <div class="info-label">Periode Magang</div>
                <div class="info-value">: {{ $filterLabels['periode'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Unit Bisnis</div>
                <div class="info-value">: {{ $filterLabels['unit'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Dosen Pembimbing</div>
                <div class="info-value">: {{ $filterLabels['dosen'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Status Magang</div>
                <div class="info-value">: {{ $filterLabels['status'] }}</div>
            </div>
            <div class="info-row">
                <div class="info-label">Rentang Tanggal</div>
                <div class="info-value">: {{ $filterLabels['tanggal_mulai'] }} s/d {{ $filterLabels['tanggal_selesai'] }}</div>
            </div>
        </div>
    </div>

    <!-- Statistik Global -->
    <div class="section-title">STATISTIK GLOBAL</div>
    <div class="stats-container">
        <div class="stats-grid">
            <div class="stat-box">
                <div class="stat-label">Total Mahasiswa</div>
                <div class="stat-number">{{ $statistik['total_mahasiswa'] }}</div>
            </div>
            <div class="stat-box green">
                <div class="stat-label">Mahasiswa Aktif</div>
                <div class="stat-number">{{ $statistik['mahasiswa_aktif'] }}</div>
            </div>
            <div class="stat-box orange">
                <div class="stat-label">Mahasiswa Selesai</div>
                <div class="stat-number">{{ $statistik['mahasiswa_selesai'] }}</div>
            </div>
            <div class="stat-box red">
                <div class="stat-label">Mahasiswa Nonaktif</div>
                <div class="stat-number">{{ $statistik['mahasiswa_nonaktif'] }}</div>
            </div>
        </div>
    </div>

    <div class="stats-container">
        <div class="stats-grid">
            <div class="stat-box green">
                <div class="stat-label">Total Kehadiran</div>
                <div class="stat-number">{{ $statistik['total_kehadiran'] }}</div>
            </div>
            <div class="stat-box orange">
                <div class="stat-label">Total Izin</div>
                <div class="stat-number">{{ $statistik['total_izin'] }}</div>
            </div>
            <div class="stat-box red">
                <div class="stat-label">Total Sakit</div>
                <div class="stat-number">{{ $statistik['total_sakit'] }}</div>
            </div>
            <div class="stat-box purple">
                <div class="stat-label">Total Logbook</div>
                <div class="stat-number">{{ $statistik['total_logbook'] }}</div>
            </div>
        </div>
    </div>

    <!-- Rekap Per Mahasiswa -->
    <div class="section-title">REKAP DATA MAHASISWA</div>
    <table>
        <thead>
            <tr>
                <th class="col-no">No</th>
                <th class="col-nim">NIM</th>
                <th class="col-nama">Nama</th>
                <th class="col-unit">Unit Bisnis</th>
                <th class="col-dosen">Dosen</th>
                <th class="col-periode">Periode</th>
                <th class="col-status">Status</th>
                <th class="col-angka">Hadir</th>
                <th class="col-angka">Izin</th>
                <th class="col-angka">Sakit</th>
                <th class="col-persen">Hadir %</th>
                <th class="col-logbook">Logbook</th>
            </tr>
        </thead>
        <tbody>
            @forelse($dataMahasiswa as $index => $data)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $data['magang']->mahasiswa->nim ?? '-' }}</td>
                    <td>{{ $data['magang']->mahasiswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $data['magang']->unitBisnis->nama_unit_bisnis ?? '-' }}</td>
                    <td>{{ $data['magang']->dosen->nama_lengkap ?? '-' }}</td>
                    <td class="text-small">{{ $data['magang']->periodeMagang->nama_periode ?? '-' }}</td>
                    <td class="text-center">
                        @if($data['magang']->status_magang == 'Aktif')
                            <span class="badge badge-success">Aktif</span>
                        @elseif($data['magang']->status_magang == 'Selesai')
                            <span class="badge badge-info">Selesai</span>
                        @else
                            <span class="badge badge-secondary">Nonaktif</span>
                        @endif
                    </td>
                    <td class="text-center">{{ $data['total_kehadiran'] }}</td>
                    <td class="text-center">{{ $data['total_izin'] }}</td>
                    <td class="text-center">{{ $data['total_sakit'] }}</td>
                    <td class="text-center"><strong>{{ $data['persentase_kehadiran'] }}%</strong></td>
                    <td class="text-center">
                        {{ $data['total_logbook'] }}
                        <span style="font-size: 7px; color: #27ae60;">(✓{{ $data['logbook_approved'] }})</span>
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="12" class="text-center" style="padding: 20px; color: #7f8c8d;">
                        Tidak ada data mahasiswa
                    </td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer clearfix">
        <div class="footer-left">
            <strong>Sistem Tracking Magang</strong><br>
            Laporan ini dihasilkan secara otomatis oleh sistem
        </div>
        <div class="footer-right">
            <strong>Administrator</strong><br>
            Halaman 1 dari 1
        </div>
    </div>
</body>

</html>
