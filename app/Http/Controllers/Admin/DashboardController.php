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

        // Status Magang Counts
        $magang_diterima = Magang::where('status_magang', 'Aktif')->count();
        $magang_ditolak = Magang::where('status_magang', 'dibatalkan')->count();
        $magang_selesai = Magang::where('status_magang', 'selesai')->count();
        $magang_nonaktif = Magang::where('status_magang', 'Nonaktif')->count();

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
                    'timestamp' => $logbook->created_at->timestamp,
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
                    'timestamp' => $magang->created_at->timestamp,
                ];
            });

        // Add accepted magang to activity
        $magang_diterima_list = Magang::with('mahasiswa')
            ->where('status_magang', 'Aktif')
            ->orderBy('updated_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($magang) {
                $nama = $magang->mahasiswa->nama_lengkap ?? 'Unknown';
                $waktu = $magang->updated_at->diffForHumans();
                
                return [
                    'deskripsi' => "{$nama} magang diterima",
                    'waktu' => $waktu,
                    'timestamp' => $magang->updated_at->timestamp,
                ];
            });

        // Add rejected magang to activity
        $magang_ditolak_list = Magang::with('mahasiswa')
            ->where('status_magang', 'dibatalkan')
            ->orderBy('updated_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($magang) {
                $nama = $magang->mahasiswa->nama_lengkap ?? 'Unknown';
                $waktu = $magang->updated_at->diffForHumans();
                
                return [
                    'deskripsi' => "{$nama} magang ditolak",
                    'waktu' => $waktu,
                    'timestamp' => $magang->updated_at->timestamp,
                ];
            });

        // Add completed magang to activity
        $magang_selesai_list = Magang::with('mahasiswa')
            ->where('status_magang', 'selesai')
            ->orderBy('updated_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($magang) {
                $nama = $magang->mahasiswa->nama_lengkap ?? 'Unknown';
                $waktu = $magang->updated_at->diffForHumans();
                
                return [
                    'deskripsi' => "{$nama} magang selesai",
                    'waktu' => $waktu,
                    'timestamp' => $magang->updated_at->timestamp,
                ];
            });

        // Add inactive magang to activity
        $magang_nonaktif_list = Magang::with('mahasiswa')
            ->where('status_magang', 'Nonaktif')
            ->orderBy('updated_at', 'desc')
            ->limit(2)
            ->get()
            ->map(function ($magang) {
                $nama = $magang->mahasiswa->nama_lengkap ?? 'Unknown';
                $waktu = $magang->updated_at->diffForHumans();
                
                return [
                    'deskripsi' => "{$nama} magang nonaktif",
                    'waktu' => $waktu,
                    'timestamp' => $magang->updated_at->timestamp,
                ];
            });

        $aktivitas_terbaru = $aktivitas_terbaru
            ->concat($registrasi_baru)
            ->concat($magang_diterima_list)
            ->concat($magang_ditolak_list)
            ->concat($magang_selesai_list)
            ->concat($magang_nonaktif_list)
            ->sortByDesc(function ($item) {
                return $item['timestamp'];
            })
            ->take(10)
            ->values();   

        return view('admin.dashboard', compact(
            'peserta_aktif',
            'pembimbing',
            'pendaftaran_baru',
            'logbook_hari_ini',
            'periode_labels',
            'periode_data',
            'aktivitas_terbaru',
            'magang_diterima',
            'magang_ditolak',
            'magang_selesai',
            'magang_nonaktif'
        ));
    }
}
