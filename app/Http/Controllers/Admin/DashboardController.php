<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Alat;
use App\Models\Peminjaman;
use App\Models\Pengembalian;
use App\Models\Denda;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $data = [
            'total_users' => User::count(),
            'total_alat' => Alat::count(),
            'total_alat_tersedia' => Alat::where('status', 'tersedia')->count(),
            'total_peminjaman_aktif' => Peminjaman::whereIn('status', ['dipinjam', 'disetujui'])->count(),
            'peminjaman_menunggu' => Peminjaman::where('status', 'menunggu_konfirmasi')->count(),
            'total_pengembalian' => Pengembalian::count(),
            'total_denda_belum_dibayar' => Denda::where('status', 'belum_dibayar')->sum('total_denda'),
            // breakdown per status for charts
            'status_counts' => [
                'menunggu_konfirmasi' => Peminjaman::where('status', 'menunggu_konfirmasi')->count(),
                'disetujui' => Peminjaman::where('status', 'disetujui')->count(),
                'dipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
                'dikembalikan' => Peminjaman::where('status', 'dikembalikan')->count(),
                'ditolak' => Peminjaman::where('status', 'ditolak')->count(),
            ],
            
            'peminjaman_terbaru' => Peminjaman::with(['user', 'alat'])
                ->latest()
                ->take(5)
                ->get(),
                
            'pengembalian_terbaru' => Pengembalian::with(['peminjaman.user', 'peminjaman.alat'])
                ->latest()
                ->take(5)
                ->get(),
        ];

        return view('admin.dashboard', $data);
    }
}
