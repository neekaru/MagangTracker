<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\PeriodeMagang;
use App\Models\UnitBisnis;
use App\Models\Dosen;
use App\Models\Absen;
use App\Models\Logbook;
use App\Exports\MagangExport;
use App\Exports\AdminLaporanExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $periodes = PeriodeMagang::orderBy('tanggal_mulai', 'desc')->get();
        $units = UnitBisnis::orderBy('nama_unit_bisnis')->get();
        $dosens = Dosen::orderBy('nama_lengkap')->get();

        return view('admin.laporan.index', compact('periodes', 'units', 'dosens'));
    }

    public function exportPdf(Request $request)
    {
        $query = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang', 'dosen']);

        // Apply filters
        if ($request->status) {
            $query->where('status_magang', $request->status);
        }

        if ($request->periode_id) {
            $query->where('periode_id', $request->periode_id);
        }

        if ($request->unit_bisnis_id) {
            $query->where('unit_bisnis_id', $request->unit_bisnis_id);
        }

        if ($request->dosen_id) {
            $query->where('dosen_pembimbing_id', $request->dosen_id);
        }

        $magangs = $query->orderBy('created_at', 'desc')->get();

        // Hitung statistik global
        $totalMahasiswa = $magangs->count();
        $mahasiswaAktif = $magangs->where('status_magang', 'Aktif')->count();
        $mahasiswaSelesai = $magangs->where('status_magang', 'Selesai')->count();
        $mahasiswaNonaktif = $magangs->where('status_magang', 'Nonaktif')->count();

        // Query absensi untuk semua mahasiswa
        $magangIds = $magangs->pluck('id');
        
        $queryAbsensi = Absen::whereIn('magang_id', $magangIds);
        if ($request->tanggal_mulai) {
            $queryAbsensi->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_selesai) {
            $queryAbsensi->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        $absensis = $queryAbsensi->get();

        $totalKehadiran = $absensis->where('status_kehadiran', 'Hadir')->count();
        $totalIzin = $absensis->where('status_kehadiran', 'Izin')->count();
        $totalSakit = $absensis->where('status_kehadiran', 'Sakit')->count();
        $totalAbsensi = $absensis->count();

        // Query logbook untuk semua mahasiswa
        $queryLogbook = Logbook::whereIn('magang_id', $magangIds);
        if ($request->tanggal_mulai) {
            $queryLogbook->whereDate('tanggal_logbook', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_selesai) {
            $queryLogbook->whereDate('tanggal_logbook', '<=', $request->tanggal_selesai);
        }
        $logbooks = $queryLogbook->get();

        $totalLogbook = $logbooks->count();
        $logbookApproved = $logbooks->where('status', 'approved')->count();
        $logbookPending = $logbooks->where('status', 'pending')->count();
        $logbookRejected = $logbooks->where('status', 'rejected')->count();

        $statistik = [
            'total_mahasiswa' => $totalMahasiswa,
            'mahasiswa_aktif' => $mahasiswaAktif,
            'mahasiswa_selesai' => $mahasiswaSelesai,
            'mahasiswa_nonaktif' => $mahasiswaNonaktif,
            'total_kehadiran' => $totalKehadiran,
            'total_izin' => $totalIzin,
            'total_sakit' => $totalSakit,
            'total_absensi' => $totalAbsensi,
            'total_logbook' => $totalLogbook,
            'logbook_approved' => $logbookApproved,
            'logbook_pending' => $logbookPending,
            'logbook_rejected' => $logbookRejected,
        ];

        // Hitung data per mahasiswa
        $dataMahasiswa = [];
        foreach ($magangs as $magang) {
            $absensiMhs = $absensis->where('magang_id', $magang->id);
            $logbookMhs = $logbooks->where('magang_id', $magang->id);
            
            $hadirMhs = $absensiMhs->where('status_kehadiran', 'Hadir')->count();
            $totalAbsensiMhs = $absensiMhs->count();
            $persentaseKehadiran = $totalAbsensiMhs > 0 ? round(($hadirMhs / $totalAbsensiMhs) * 100, 2) : 0;

            $dataMahasiswa[] = [
                'magang' => $magang,
                'total_kehadiran' => $hadirMhs,
                'total_izin' => $absensiMhs->where('status_kehadiran', 'Izin')->count(),
                'total_sakit' => $absensiMhs->where('status_kehadiran', 'Sakit')->count(),
                'persentase_kehadiran' => $persentaseKehadiran,
                'total_logbook' => $logbookMhs->count(),
                'logbook_approved' => $logbookMhs->where('status', 'approved')->count(),
            ];
        }

        // Get filter labels
        $filterLabels = [
            'status' => $request->status ?? 'Semua',
            'periode' => $request->periode_id ? PeriodeMagang::find($request->periode_id)->nama_periode : 'Semua',
            'unit' => $request->unit_bisnis_id ? optional(UnitBisnis::find($request->unit_bisnis_id))->nama_unit_bisnis ?? 'Semua' : 'Semua',
            'dosen' => $request->dosen_id ? optional(Dosen::find($request->dosen_id))->nama_lengkap ?? 'Semua' : 'Semua',
            'tanggal_mulai' => $request->tanggal_mulai ? \Carbon\Carbon::parse($request->tanggal_mulai)->format('d/m/Y') : 'Semua',
            'tanggal_selesai' => $request->tanggal_selesai ? \Carbon\Carbon::parse($request->tanggal_selesai)->format('d/m/Y') : 'Semua',
            'tanggal_generate' => \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y H:i:s'),
        ];

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('dataMahasiswa', 'statistik', 'filterLabels'));
        $pdf->setPaper('a4', 'landscape');

        return $pdf->download('laporan-admin-magang-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $query = Magang::with(['mahasiswa', 'unitBisnis', 'periodeMagang', 'dosen']);

        // Apply filters
        if ($request->status) {
            $query->where('status_magang', $request->status);
        }

        if ($request->periode_id) {
            $query->where('periode_id', $request->periode_id);
        }

        if ($request->unit_bisnis_id) {
            $query->where('unit_bisnis_id', $request->unit_bisnis_id);
        }

        if ($request->dosen_id) {
            $query->where('dosen_pembimbing_id', $request->dosen_id);
        }

        $magangs = $query->orderBy('created_at', 'desc')->get();

        // Query absensi dan logbook
        $magangIds = $magangs->pluck('id');
        
        $queryAbsensi = Absen::with(['magang.mahasiswa'])->whereIn('magang_id', $magangIds);
        if ($request->tanggal_mulai) {
            $queryAbsensi->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_selesai) {
            $queryAbsensi->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }
        $absensis = $queryAbsensi->orderBy('tanggal', 'desc')->get();

        $queryLogbook = Logbook::with(['magang.mahasiswa'])->whereIn('magang_id', $magangIds);
        if ($request->tanggal_mulai) {
            $queryLogbook->whereDate('tanggal_logbook', '>=', $request->tanggal_mulai);
        }
        if ($request->tanggal_selesai) {
            $queryLogbook->whereDate('tanggal_logbook', '<=', $request->tanggal_selesai);
        }
        $logbooks = $queryLogbook->orderBy('tanggal_logbook', 'desc')->get();

        // Hitung statistik per mahasiswa
        $dataMahasiswa = [];
        foreach ($magangs as $magang) {
            $absensiMhs = $absensis->where('magang_id', $magang->id);
            $logbookMhs = $logbooks->where('magang_id', $magang->id);
            
            $hadirMhs = $absensiMhs->where('status_kehadiran', 'Hadir')->count();
            $totalAbsensiMhs = $absensiMhs->count();
            $persentaseKehadiran = $totalAbsensiMhs > 0 ? round(($hadirMhs / $totalAbsensiMhs) * 100, 2) : 0;

            $dataMahasiswa[] = [
                'nim' => $magang->mahasiswa->nim ?? '-',
                'nama' => $magang->mahasiswa->nama_lengkap ?? '-',
                'prodi' => $magang->mahasiswa->program_studi ?? '-',
                'unit' => $magang->unitBisnis->nama_unit_bisnis ?? '-',
                'dosen' => $magang->dosen->nama_lengkap ?? '-',
                'periode' => $magang->periodeMagang->nama_periode ?? '-',
                'status' => $magang->status_magang,
                'total_kehadiran' => $hadirMhs,
                'total_izin' => $absensiMhs->where('status_kehadiran', 'Izin')->count(),
                'total_sakit' => $absensiMhs->where('status_kehadiran', 'Sakit')->count(),
                'persentase_kehadiran' => $persentaseKehadiran,
                'total_logbook' => $logbookMhs->count(),
                'logbook_approved' => $logbookMhs->where('status', 'approved')->count(),
                'logbook_pending' => $logbookMhs->where('status', 'pending')->count(),
                'logbook_rejected' => $logbookMhs->where('status', 'rejected')->count(),
            ];
        }

        // Create Excel with multiple sheets
        return Excel::download(
            new AdminLaporanExport($dataMahasiswa, $absensis, $logbooks),
            'laporan-admin-magang-' . date('Y-m-d') . '.xlsx'
        );
    }
}
