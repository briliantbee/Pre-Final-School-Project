<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Denda;
use App\Models\Alat;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $userId = auth()->id();

        $data = [
            'total_peminjaman' => Peminjaman::where('user_id', $userId)->count(),
            'peminjaman_aktif' => Peminjaman::where('user_id', $userId)
                ->whereIn('status', ['dipinjam', 'disetujui'])
                ->count(),
            'peminjaman_menunggu' => Peminjaman::where('user_id', $userId)
                ->where('status', 'menunggu_konfirmasi')
                ->count(),
            'denda_belum_dibayar' => Denda::whereHas('pengembalian.peminjaman', function($q) use ($userId) {
                $q->where('user_id', $userId);
            })->where('status', 'belum_dibayar')->sum('total_denda'),
            
            'alat_tersedia' => Alat::where('status', 'tersedia')
                ->where('stok_tersedia', '>', 0)
                ->count(),
            
            'peminjaman_terbaru' => Peminjaman::with(['alat.kategori', 'disetujuiOleh'])
                ->where('user_id', $userId)
                ->latest()
                ->take(5)
                ->get(),
                
            'pengembalian_terbaru' => Pengembalian::with(['peminjaman.alat', 'diterimaDosen', 'denda'])
                ->whereHas('peminjaman', function($q) use ($userId) {
                    $q->where('user_id', $userId);
                })
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('peminjam.dashboard', $data);
    }
}
