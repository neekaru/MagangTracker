<?php

namespace App\Http\Controllers\Mahasiswa;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\Logbook;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $mahasiswa = $user->mahasiswa;
        
        if (!$mahasiswa) {
            return redirect()->back()->with('error', 'Data mahasiswa tidak ditemukan.');
        }
        
        // Get magang data with relationships
        $magang = Magang::with(['absen', 'logbook', 'unitBisnis', 'periodeMagang'])
            ->where('id_mahasiswa', $mahasiswa->id)
            ->first();

        if ($magang) {
            // Status Magang
            $status_magang = $magang->status_magang ?? 'Tidak Aktif';
            $unit_penempatan = $magang->unitBisnis->nama_unit_bisnis ?? 'N/A';
            
            // Calculate attendance (kehadiran)
            $total_absen = $magang->absen()->count();
            $absen_hadir = $magang->absen()
                ->where('status_kehadiran', 'Hadir')
                ->count();
            
            $periode = $magang->periodeMagang;
            $start_date = $periode?->tanggal_mulai ? Carbon::parse($periode->tanggal_mulai) : null;
            $end_date = $periode?->tanggal_selesai ? Carbon::parse($periode->tanggal_selesai) : null;
            $today = Carbon::now();

            if ($start_date && $end_date) {
                if ($today->gt($end_date)) {
                    $today = $end_date;
                }
                $kehadiran_max = 0;
                $current = $start_date->copy();
                while ($current->lte($today)) {
                    if ($current->isWeekday()) {
                        $kehadiran_max++;
                    }
                    $current->addDay();
                }
            } else {
                $kehadiran_max = 0;
            }
            
            $kehadiran_total = $absen_hadir;
            $kehadiran_persen = $kehadiran_max > 0 ? round(($absen_hadir / $kehadiran_max) * 100) : 0;
            
            // Logbook this week
            $startOfWeek = Carbon::now()->startOfWeek();
            $endOfWeek = Carbon::now()->endOfWeek();
            
            $logbook_minggu_ini = $magang->logbook()
                ->whereBetween('tanggal_logbook', [$startOfWeek, $endOfWeek])
                ->count();
            
            $logbook_target = $magang->target_book_mingguan ?? 5;
            
            // Get latest logbook entries
            $latest_logbook = $magang->logbook()
                ->orderBy('tanggal_logbook', 'desc')
                ->limit(5)
                ->get();
            
        } else {
            // Default values when no magang data
            $status_magang = 'Tidak Aktif';
            $unit_penempatan = 'N/A';
            $kehadiran_persen = 0;
            $kehadiran_total = 0;
            $kehadiran_max = 0;
            $logbook_minggu_ini = 0;
            $logbook_target = 5;
            $latest_logbook = collect();
        }

        return view('mahasiswa.dashboard', compact(
            'status_magang',
            'unit_penempatan',
            'kehadiran_persen',
            'kehadiran_total',
            'kehadiran_max',
            'logbook_minggu_ini',
            'logbook_target',
            'latest_logbook'
        ));
    }
}
