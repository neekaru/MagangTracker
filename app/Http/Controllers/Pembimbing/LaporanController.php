<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\PeriodeMagang;
use App\Models\Dosen;
use App\Models\Logbook;
use App\Models\Absen;
use App\Models\Mahasiswa;
use App\Exports\MagangExport;
use App\Exports\PembimbingLaporanExport;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;

class LaporanController extends Controller
{
    public function index()
    {
        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();
        $periodes = PeriodeMagang::orderBy('tanggal_mulai', 'desc')->get();
        
        // Get all magang dari dosen pembimbing ini
        $magangs = Magang::with(['mahasiswa', 'periodeMagang', 'unitBisnis'])
            ->where('dosen_pembimbing_id', $dosen->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('pembimbing.laporan.index', compact('periodes', 'dosen', 'magangs'));
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
        ]);

        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();
        $mahasiswa = Mahasiswa::with(['user'])->findOrFail($request->mahasiswa_id);

        // Get magang info
        $magang = Magang::with(['unitBisnis', 'periodeMagang'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('dosen_pembimbing_id', $dosen->id);

        if ($request->periode_id) {
            $magang->where('periode_id', $request->periode_id);
        }

        $magang = $magang->first();

        if (!$magang) {
            return redirect()->back()->with('error', 'Data magang tidak ditemukan.');
        }

        // Query Absensi
        $queryAbsensi = Absen::with(['magang.unitBisnis'])
            ->where('magang_id', $magang->id);

        if ($request->tanggal_mulai) {
            $queryAbsensi->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $queryAbsensi->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        if ($request->status_validasi_absensi) {
            $queryAbsensi->where('status_validasi', $request->status_validasi_absensi);
        }

        $absensis = $queryAbsensi->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();

        // Query Logbook
        $queryLogbook = Logbook::with(['magang.unitBisnis'])
            ->where('magang_id', $magang->id);

        if ($request->tanggal_mulai) {
            $queryLogbook->whereDate('tanggal_logbook', '>=', $request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $queryLogbook->whereDate('tanggal_logbook', '<=', $request->tanggal_selesai);
        }

        if ($request->status_validasi_logbook) {
            $queryLogbook->where('status', $request->status_validasi_logbook);
        }

        $logbooks = $queryLogbook->orderBy('tanggal_logbook', 'desc')->get();

        // Hitung Statistik
        $totalKehadiran = $absensis->where('status_kehadiran', 'Hadir')->count();
        $totalIzin = $absensis->where('status_kehadiran', 'Izin')->count();
        $totalSakit = $absensis->where('status_kehadiran', 'Sakit')->count();
        $totalAbsensi = $absensis->count();
        $persentaseKehadiran = $totalAbsensi > 0 ? round(($totalKehadiran / $totalAbsensi) * 100, 2) : 0;

        $totalLogbook = $logbooks->count();
        $logbookApproved = $logbooks->where('status', 'approved')->count();
        $logbookPending = $logbooks->where('status', 'pending')->count();
        $logbookRejected = $logbooks->where('status', 'rejected')->count();

        $statistik = [
            'total_kehadiran' => $totalKehadiran,
            'total_izin' => $totalIzin,
            'total_sakit' => $totalSakit,
            'total_absensi' => $totalAbsensi,
            'persentase_kehadiran' => $persentaseKehadiran,
            'total_logbook' => $totalLogbook,
            'logbook_approved' => $logbookApproved,
            'logbook_pending' => $logbookPending,
            'logbook_rejected' => $logbookRejected,
        ];

        // Get filter labels
        $filterLabels = [
            'tanggal_mulai' => $request->tanggal_mulai ? \Carbon\Carbon::parse($request->tanggal_mulai)->format('d/m/Y') : 'Semua',
            'tanggal_selesai' => $request->tanggal_selesai ? \Carbon\Carbon::parse($request->tanggal_selesai)->format('d/m/Y') : 'Semua',
            'dosen' => $dosen->nama_lengkap,
            'tanggal_generate' => \Carbon\Carbon::now()->locale('id')->translatedFormat('d F Y H:i:s'),
        ];

        $pdf = Pdf::loadView('pembimbing.laporan.pdf', compact('mahasiswa', 'magang', 'absensis', 'logbooks', 'statistik', 'filterLabels'));
        $pdf->setPaper('a4', 'portrait');

        return $pdf->download('laporan-magang-' . $mahasiswa->nim . '-' . date('Y-m-d') . '.pdf');
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswa,id',
        ]);

        $dosen = Dosen::where('user_id', auth()->id())->firstOrFail();
        $mahasiswa = Mahasiswa::with(['user'])->findOrFail($request->mahasiswa_id);

        // Get magang info
        $magang = Magang::with(['unitBisnis', 'periodeMagang'])
            ->where('mahasiswa_id', $mahasiswa->id)
            ->where('dosen_pembimbing_id', $dosen->id);

        if ($request->periode_id) {
            $magang->where('periode_id', $request->periode_id);
        }

        $magang = $magang->first();

        if (!$magang) {
            return redirect()->back()->with('error', 'Data magang tidak ditemukan.');
        }

        // Query Absensi
        $queryAbsensi = Absen::with(['magang.unitBisnis'])
            ->where('magang_id', $magang->id);

        if ($request->tanggal_mulai) {
            $queryAbsensi->whereDate('tanggal', '>=', $request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $queryAbsensi->whereDate('tanggal', '<=', $request->tanggal_selesai);
        }

        if ($request->status_validasi_absensi) {
            $queryAbsensi->where('status_validasi', $request->status_validasi_absensi);
        }

        $absensis = $queryAbsensi->orderBy('tanggal', 'desc')->orderBy('jenis_absen', 'asc')->get();

        // Query Logbook
        $queryLogbook = Logbook::with(['magang.unitBisnis'])
            ->where('magang_id', $magang->id);

        if ($request->tanggal_mulai) {
            $queryLogbook->whereDate('tanggal_logbook', '>=', $request->tanggal_mulai);
        }

        if ($request->tanggal_selesai) {
            $queryLogbook->whereDate('tanggal_logbook', '<=', $request->tanggal_selesai);
        }

        if ($request->status_validasi_logbook) {
            $queryLogbook->where('status', $request->status_validasi_logbook);
        }

        $logbooks = $queryLogbook->orderBy('tanggal_logbook', 'desc')->get();

        // Hitung Statistik
        $totalKehadiran = $absensis->where('status_kehadiran', 'Hadir')->count();
        $totalIzin = $absensis->where('status_kehadiran', 'Izin')->count();
        $totalSakit = $absensis->where('status_kehadiran', 'Sakit')->count();
        $totalAbsensi = $absensis->count();
        $persentaseKehadiran = $totalAbsensi > 0 ? round(($totalKehadiran / $totalAbsensi) * 100, 2) : 0;

        $totalLogbook = $logbooks->count();
        $logbookApproved = $logbooks->where('status', 'approved')->count();
        $logbookPending = $logbooks->where('status', 'pending')->count();
        $logbookRejected = $logbooks->where('status', 'rejected')->count();

        // Create Excel with multiple sheets
        return Excel::download(
            new PembimbingLaporanExport($absensis, $logbooks),
            'laporan-magang-' . $mahasiswa->nim . '-' . date('Y-m-d') . '.xlsx'
        );
    }
}
