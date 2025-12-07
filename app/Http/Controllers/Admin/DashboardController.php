<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\User;
use App\Models\Logbook;
use App\Models\PeriodeMagang;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        // Peserta Aktif (Mahasiswa with active magang status)
        $peserta_aktif = Magang::where('status_magang', 'Aktif')->count();

        // Pembimbing (Dosen and Pembimbing roles)
        $pembimbing = User::whereIn('role', ['Pembimbing', 'Dosen'])->count();

        // Pendaftaran Baru (Pending status)
        $pendaftaran_baru = Magang::where('status_magang', 'Pending')->count();

        // Logbook Hari Ini
        $logbook_hari_ini = Logbook::whereDate('tanggal_logbook', Carbon::today())->count();

        // Statistik Pendaftaran per Periode
        $periode_stats = PeriodeMagang::withCount('magang')
            ->orderBy('tanggal_mulai', 'desc')
            ->limit(4)
            ->get();

        $periode_labels = [];
        $periode_data = [];
        
        foreach ($periode_stats as $periode) {
            $periode_labels[] = $periode->nama_periode;
            $periode_data[] = $periode->magang_count;
        }

        // Reverse to show chronologically
        $periode_labels = array_reverse($periode_labels);
        $periode_data = array_reverse($periode_data);

        // Aktivitas Terbaru (Latest logbooks with mahasiswa info)
        $aktivitas_terbaru = Logbook::with(['magang.mahasiswa'])
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get()
            ->map(function ($logbook) {
                $nama = $logbook->magang->mahasiswa->nama_lengkap ?? 'Unknown';
                $waktu = $logbook->created_at->diffForHumans();
                
                return [
                    'deskripsi' => "{$nama} mengisi logbook",
                    'waktu' => $waktu,
                ];
            });

        // Add new registrations to activity
        $registrasi_baru = Magang::with('mahasiswa')
            ->where('status_magang', 'Pending')
            ->orderBy('created_at', 'desc')
            ->limit(3)
            ->get()
            ->map(function ($magang) {
                $nama = $magang->mahasiswa->nama_lengkap ?? 'Unknown';
                $waktu = $magang->created_at->diffForHumans();
                
                return [
                    'deskripsi' => "{$nama} mendaftar magang",
                    'waktu' => $waktu,
                ];
            });

        $aktivitas_terbaru = $aktivitas_terbaru->concat($registrasi_baru)
            ->sortByDesc(function ($item) {
                return strtotime(str_replace(['ago', 'in'], '', $item['waktu']));
            })
            ->take(5)
            ->values();

        return view('admin.dashboard', compact(
            'peserta_aktif',
            'pembimbing',
            'pendaftaran_baru',
            'logbook_hari_ini',
            'periode_labels',
            'periode_data',
            'aktivitas_terbaru'
        ));
    }
}
