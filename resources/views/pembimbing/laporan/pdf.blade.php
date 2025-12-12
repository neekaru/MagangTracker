<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Laporan Bimbingan Magang</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 10px;
        }

        .header {
            text-align: center;
            margin-bottom: 20px;
            border-bottom: 2px solid #000;
            padding-bottom: 10px;
        }

        .header h2 {
            margin: 5px 0;
        }

        .filter-info {
            margin-bottom: 15px;
            padding: 10px;
            background-color: #f0f0f0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #4CAF50;
            color: white;
            font-weight: bold;
        }

        .footer {
            margin-top: 20px;
            text-align: right;
            font-size: 9px;
        }
    </style>
</head>

<body>
    <div class="header">
        <h2>LAPORAN BIMBINGAN MAGANG</h2>
        <p>Sistem Tracking Magang</p>
        <p><strong>Dosen Pembimbing: {{ $filterLabels['dosen'] }}</strong></p>
    </div>

    <div class="filter-info">
        <strong>Filter Laporan:</strong><br>
        Status: {{ $filterLabels['status'] }} |
        Periode: {{ $filterLabels['periode'] }}<br>
        <strong>Total Data: {{ $magangs->count() }} peserta bimbingan</strong>
    </div>

    <table>
        <thead>
            <tr>
                <th style="width: 3%;">No</th>
                <th style="width: 10%;">NIM</th>
                <th style="width: 18%;">Nama</th>
                <th style="width: 15%;">Unit</th>
                <th style="width: 15%;">Periode</th>
                <th style="width: 15%;">Pembimbing Lap.</th>
                <th style="width: 10%;">Mulai</th>
                <th style="width: 10%;">Selesai</th>
                <th style="width: 4%;">Status</th>
            </tr>
        </thead>
        <tbody>
            @forelse($magangs as $index => $magang)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $magang->mahasiswa->nim ?? '-' }}</td>
                    <td>{{ $magang->mahasiswa->nama_lengkap ?? '-' }}</td>
                    <td>{{ $magang->unitBisnis->nama_unit_bisnis ?? '-' }}</td>
                    <td>{{ $magang->periodeMagang->nama_periode ?? '-' }}</td>
                    <td>{{ $magang->pembimbing_lapangan ?? '-' }}</td>
                    <td>{{ $magang->tanggal_mulai ? $magang->tanggal_mulai->format('d/m/Y') : '-' }}</td>
                    <td>{{ $magang->tanggal_selesai ? $magang->tanggal_selesai->format('d/m/Y') : '-' }}</td>
                    <td>{{ $magang->status_magang }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="9" style="text-align: center;">Tidak ada data</td>
                </tr>
            @endforelse
        </tbody>
    </table>

    <div class="footer">
        <p>Dicetak pada: {{ date('d F Y H:i:s') }}</p>
    </div>
</body>

</html>
