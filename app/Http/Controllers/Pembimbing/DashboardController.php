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

        $peserta_count = Magang::where('id_dosen', $dosenId)->count();

        $logbook_pending = Logbook::whereHas('magang', function($query) use ($dosenId) {
            $query->where('id_dosen', $dosenId);
        })->where('status', 'pending')->count();

        $magangIds = Magang::where('id_dosen', $dosenId)->pluck('id');
        
        $absensi_hadir = Absen::whereIn('magang_id', $magangIds)
            ->where('status_kehadiran', 'hadir')
            ->whereDate('tanggal', today())
            ->count();
        
        $absensi_total = Absen::whereIn('magang_id', $magangIds)
            ->whereDate('tanggal', today())
            ->count();

        return view('pembimbing.dashboard', compact('peserta_count', 'logbook_pending', 'absensi_hadir', 'absensi_total'));
    }
}
