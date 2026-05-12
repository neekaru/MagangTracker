<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Mahasiswa Magang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
            line-height: 1.45;
            color: #000000;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000000;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 5px 0;
            font-size: 19px;
            color: #000000;
            font-weight: 700;
            letter-spacing: 0.3px;
        }

        .header p {
            margin: 2px 0;
            font-size: 10px;
            color: #000000;
        }

        .info-section {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f0f0f0;
            border: 1px solid #cccccc;
        }

        .info-section h3 {
            margin: 0 0 10px 0;
            font-size: 13px;
            color: #000000;
        }

        .info-row {
            margin-bottom: 5px;
            color: #000000;
        }

        .info-label {
            display: inline-block;
            width: 180px;
            font-weight: bold;
            color: #000000;
        }

        .statistik-box {
            width: 100%;
            padding: 8px;
            background-color: #e9ecef;
            border: 1px solid #cccccc;
            vertical-align: top;
        }

        .statistik-layout {
            width: 100%;
            border-collapse: separate;
            border-spacing: 0 0;
            table-layout: fixed;
        }

        .statistik-layout td {
            width: 50%;
            vertical-align: top;
            padding: 0;
            border: 0;
        }

        .statistik-layout td:first-child {
            padding-right: 8px;
        }

        .statistik-layout td:last-child {
            padding-left: 8px;
        }

        .statistik-box h4 {
            margin: 0 0 8px 0;
            font-size: 12px;
            color: #000000;
        }

        .stat-item {
            margin-bottom: 4px;
            font-size: 10px;
            color: #000000;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 15px;
        }

        th,
        td {
            border: 1px solid #000000;
            padding: 6px 4px;
            text-align: left;
            font-size: 9px;
            vertical-align: top;
        }

        th {
            background-color: #333333;
            color: #ffffff;
            font-weight: bold;
        }

        .section-title {
            background-color: #000000;
            color: #ffffff;
            padding: 8px;
            margin-top: 15px;
            margin-bottom: 10px;
            font-size: 13px;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            padding-top: 10px;
            border-top: 1px solid #000000;
            font-size: 9px;
            color: #000000;
        }

        .badge {
            display: inline-block;
            padding: 2px 6px;
            border-radius: 3px;
            font-size: 8px;
            font-weight: bold;
        }

        .badge-success {
            background-color: #28a745;
            color: #ffffff;
        }

        .badge-warning {
            background-color: #ffc107;
            color: #000000;
        }

        .badge-danger {
            background-color: #dc3545;
            color: #ffffff;
        }

        .badge-secondary {
            background-color: #6c757d;
            color: #ffffff;
        }

        .badge-primary {
            background-color: #007bff;
            color: #ffffff;
        }

        .text-center {
            text-align: center;
        }

        .filter-box {
            margin-bottom: 15px;
            padding: 8px;
            background-color: #fff3cd;
            border: 1px solid #ffc107;
            color: #000000;
        }
    </style>
</head>

<body>
    <!-- Header -->
    <div class="header">
        <h2>LAPORAN MAHASISWA MAGANG</h2>
        <p>Sistem Tracking Magang</p>
        <p><strong>Dosen Pembimbing: {{ $filterLabels['dosen'] }}</strong></p>
    </div>

    <!-- Informasi Mahasiswa -->
    <div class="info-section">
        <h3>INFORMASI MAHASISWA</h3>
        <div class="info-row">
            <span class="info-label">Nama Mahasiswa</span>: {{ $mahasiswa->nama_lengkap }}
        </div>
        <div class="info-row">
            <span class="info-label">NIM</span>: {{ $mahasiswa->nim }}
        </div>
        <div class="info-row">
            <span class="info-label">Program Studi</span>: {{ $mahasiswa->program_studi ?? '-' }}
        </div>
        <div class="info-row">
            <span class="info-label">Unit Bisnis / Tempat Magang</span>: {{ $magang->unitBisnis->nama_unit_bisnis ?? '-' }}
        </div>
        <div class="info-row">
            <span class="info-label">Periode Magang</span>: {{ $magang->periodeMagang->nama_periode ?? '-' }}
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Mulai</span>: {{ $magang->periodeMagang?->tanggal_mulai ? \Carbon\Carbon::parse($magang->periodeMagang->tanggal_mulai)->locale('id')->translatedFormat('d F Y') : '-' }}
        </div>
        <div class="info-row">
            <span class="info-label">Tanggal Selesai</span>: {{ $magang->periodeMagang?->tanggal_selesai ? \Carbon\Carbon::parse($magang->periodeMagang->tanggal_selesai)->locale('id')->translatedFormat('d F Y') : '-' }}
        </div>
        <div class="info-row">
            <span class="info-label">Pembimbing Lapangan</span>: {{ $magang->pembimbing_lapangan ?? '-' }}
        </div>
    </div>

    <!-- Statistik Ringkasan -->
    <div class="info-section">
        <h3>STATISTIK RINGKASAN</h3>
        <table class="statistik-layout">
            <tr>
                <td>
                    <div class="statistik-box">
                        <h4>Rekap Kehadiran</h4>
                        <div class="stat-item">Total Kehadiran: <strong>{{ $statistik['total_kehadiran'] }}</strong></div>
                        <div class="stat-item">Total Izin: <strong>{{ $statistik['total_izin'] }}</strong></div>
                        <div class="stat-item">Total Sakit: <strong>{{ $statistik['total_sakit'] }}</strong></div>
                        <div class="stat-item">Total Absensi: <strong>{{ $statistik['total_absensi'] }}</strong></div>
                        <div class="stat-item">Persentase Kehadiran: <strong>{{ $statistik['persentase_kehadiran'] }}%</strong></div>
                    </div>
                </td>
                <td>
                    <div class="statistik-box">
                        <h4>Rekap Jurnal Kegiatan</h4>
                        <div class="stat-item">Total Logbook: <strong>{{ $statistik['total_logbook'] }}</strong></div>
                        <div class="stat-item">Approved: <strong>{{ $statistik['logbook_approved'] }}</strong></div>
                        <div class="stat-item">Pending: <strong>{{ $statistik['logbook_pending'] }}</strong></div>
                        <div class="stat-item">Rejected: <strong>{{ $statistik['logbook_rejected'] }}</strong></div>
                    </div>
                </td>
            </tr>
        </table>
    </div>

    <!-- Filter Info -->
    <div class="filter-box">
        <strong>Filter Laporan:</strong>
        @if ($filterLabels['tanggal_mulai'] === 'Semua' && $filterLabels['tanggal_selesai'] === 'Semua')
            Semua
        @else
            {{ $filterLabels['tanggal_mulai'] }} s/d {{ $filterLabels['tanggal_selesai'] }}
        @endif
    </div>

    <!-- Rekap Absensi -->
    <div class="section-title">REKAP ABSENSI</div>
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 10%;">Jenis</th>
                <th style="width: 8%;">Jam</th>
                <th style="width: 12%;">Status</th>
                <th style="width: 14%;">Keabsahan (Logbook)</th>
                <th style="width: 40%;">Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($absensis as $index => $absensi)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($absensi->tanggal)->format('d/m/Y') }}</td>
                    <td>
                        @if($absensi->jenis_absen == 'masuk')
                            <span class="badge badge-primary">Masuk</span>
                        @elseif($absensi->jenis_absen == 'pulang')
                            <span class="badge badge-secondary">Pulang</span>
                        @else
                            -
                        @endif
                    </td>
                    <td>{{ $absensi->jam ? \Carbon\Carbon::parse($absensi->jam)->format('H:i') : '-' }}</td>
                    <td>
                        @if($absensi->status_kehadiran == 'Hadir')
                            <span class="badge badge-success">Hadir</span>
                        @elseif($absensi->status_kehadiran == 'Izin')
                            <span class="badge badge-warning">Izin</span>
                        @else
                            <span class="badge badge-danger">Sakit</span>
                        @endif
                    </td>
                    <td>
                        @if($absensi->status_validasi == 'approved')
                            <span class="badge badge-success">Disetujui</span>
                        @elseif($absensi->status_validasi == 'rejected')
                            <span class="badge badge-danger">Ditolak</span>
                        @else
                            <span class="badge badge-secondary">Menunggu</span>
                        @endif
                    </td>
                    <td>{{ $absensi->keterangan ?? '-' }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="7" class="text-center">Tidak ada data absensi</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Rekap Logbook -->
    <div class="section-title">REKAP JURNAL KEGIATAN HARIAN</div>
    <table>
        <thead>
            <tr>
                <th style="width: 4%;">No</th>
                <th style="width: 12%;">Tanggal</th>
                <th style="width: 10%;">Jam</th>
                <th style="width: 35%;">Deskripsi Kegiatan</th>
                <th style="width: 27%;">Hasil Kegiatan</th>
                <th style="width: 12%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($logbooks as $index => $logbook)
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ \Carbon\Carbon::parse($logbook->tanggal_logbook)->format('d/m/Y') }}</td>
                    <td>
                        {{ $logbook->jam_mulai ? \Carbon\Carbon::parse($logbook->jam_mulai)->format('H:i') : '-' }} -
                        {{ $logbook->jam_selesai ? \Carbon\Carbon::parse($logbook->jam_selesai)->format('H:i') : '-' }}
                    </td>
                    <td>{{ $logbook->deskripsi_kegiatan ?? '-' }}</td>
                    <td>{{ $logbook->hasil_kegiatan ?? '-' }}</td>
                    <td>
                        @if($logbook->status == 'approved')
                            <span class="badge badge-success">Approved</span>
                        @elseif($logbook->status == 'rejected')
                            <span class="badge badge-danger">Rejected</span>
                        @else
                            <span class="badge badge-secondary">Pending</span>
                        @endif
                    </td>
                </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center">Tidak ada data jurnal kegiatan</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <!-- Footer -->
    <div class="footer">
        <div style="float: left;">
            <strong>Dicetak pada:</strong> {{ $filterLabels['tanggal_generate'] }}
        </div>
        <div style="float: right;">
            <strong>Dosen Pembimbing:</strong> {{ $filterLabels['dosen'] }}
        </div>
        <div style="clear: both;"></div>
    </div>
</body>

</html>
