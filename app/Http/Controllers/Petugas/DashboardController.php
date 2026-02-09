<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Alat;
use App\Models\Denda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'peminjaman_menunggu' => Peminjaman::where('status', 'menunggu_konfirmasi')->count(),
            'peminjaman_aktif' => Peminjaman::whereIn('status', ['dipinjam', 'disetujui'])->count(),
            'pengembalian_hari_ini' => Pengembalian::whereDate('tanggal_pengembalian', today())->count(),
            'denda_belum_dibayar' => Denda::where('status', 'belum_dibayar')->count(),
            'total_denda_belum_dibayar' => Denda::where('status', 'belum_dibayar')->sum('total_denda'),
            'alat_tidak_tersedia' => Alat::where('status', 'tidak_tersedia')->count(),
            
            'peminjaman_menunggu_list' => Peminjaman::with(['user', 'alat'])
                ->where('status', 'menunggu_konfirmasi')
                ->latest()
                ->take(5)
                ->get(),
                
            'peminjaman_aktif_list' => Peminjaman::with(['user', 'alat'])
                ->whereIn('status', ['dipinjam', 'disetujui'])
                ->latest()
                ->take(5)
                ->get(),
                
            'pengembalian_terbaru' => Pengembalian::with(['peminjaman.user', 'peminjaman.alat'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('petugas.dashboard', $data);
    }
}
