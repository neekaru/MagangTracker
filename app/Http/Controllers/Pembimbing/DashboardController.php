<?php

namespace App\Http\Controllers\Pembimbing;

use App\Http\Controllers\Controller;
use App\Models\Magang;
use App\Models\Logbook;
use App\Models\Absen;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        $dosenId = $user->id_dosen;

        $peserta_count = Magang::where('dosen_pembimbing_id', $dosenId)->count();

        $logbook_pending = Logbook::whereHas('magang', function($query) use ($dosenId) {
            $query->where('dosen_pembimbing_id', $dosenId);
        })->where('status', 'pending')->count();

        $magangIds = Magang::where('dosen_pembimbing_id', $dosenId)->pluck('id');
        
        $absensi_hadir = Absen::whereIn('magang_id', $magangIds)
            ->where('status_kehadiran', 'Hadir')
            ->whereDate('tanggal', today())
            ->count();
        
        $absensi_total = Absen::whereIn('magang_id', $magangIds)
            ->whereDate('tanggal', today())
            ->count();

        $peserta = Magang::with(['mahasiswa', 'unitBisnis'])
            ->where('dosen_pembimbing_id', $dosenId)
            ->get()
            ->map(function($magang) {
                $startOfWeek = now()->startOfWeek();
                $endOfWeek = now()->endOfWeek();
                
                $logbookThisWeek = Logbook::where('magang_id', $magang->id)
                    ->whereBetween('tanggal_logbook', [$startOfWeek, $endOfWeek])
                    ->count();
                
                $targetWeekly = $magang->target_book_mingguan ?? 5;
                
                return [
                    'id' => $magang->id,
                    'nama' => $magang->mahasiswa->nama_lengkap ?? 'N/A',
                    'nim' => $magang->mahasiswa->nim ?? 'N/A',
                    'unit' => $magang->unitBisnis->nama_unit_bisnis ?? 'N/A',
                    'logbook_count' => $logbookThisWeek,
                    'target_weekly' => $targetWeekly,
                ];
            });

        return view('pembimbing.dashboard', compact('peserta_count', 'logbook_pending', 'absensi_hadir', 'absensi_total', 'peserta'));
    }
}
