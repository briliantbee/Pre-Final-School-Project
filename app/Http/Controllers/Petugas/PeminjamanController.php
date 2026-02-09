<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PeminjamanController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Peminjaman::with(['user', 'alat', 'disetujuiOleh']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('username', 'like', "%{$search}%");
                  })
                  ->orWhereHas('alat', function($subQ) use ($search) {
                      $subQ->where('nama_alat', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $peminjamans = $query->latest()->paginate(15);

        $statusCounts = [
            'menunggu' => Peminjaman::where('status', 'menunggu_konfirmasi')->count(),
            'disetujui' => Peminjaman::where('status', 'disetujui')->count(),
            'dipinjam' => Peminjaman::where('status', 'dipinjam')->count(),
            'dikembalikan' => Peminjaman::where('status', 'dikembalikan')->count(),
        ];

        return view('petugas.peminjamans.index', compact('peminjamans', 'statusCounts'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'alat.kategori', 'disetujuiOleh', 'pengembalian']);
        return view('petugas.peminjamans.show', compact('peminjaman'));
    }

    /**
     * Approve peminjaman
     */
    public function approve(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Peminjaman tidak dapat disetujui.');
        }

        $alat = $peminjaman->alat;
        
        if ($alat->stok_tersedia < $peminjaman->jumlah) {
            return back()->with('error', 'Stok alat tidak mencukupi.');
        }

        DB::transaction(function () use ($peminjaman, $alat) {
            $peminjaman->update([
                'status' => 'disetujui',
                'disetujui_oleh' => auth()->id(),
                'tanggal_disetujui' => now(),
            ]);

            // Update stok
            $alat->decrement('stok_tersedia', $peminjaman->jumlah);
            if ($alat->stok_tersedia == 0) {
                $alat->update(['status' => 'tidak_tersedia']);
            }

            // Log activity
            Aktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Menyetujui Peminjaman',
                'deskripsi' => "Peminjaman {$peminjaman->kode_peminjaman} disetujui oleh petugas",
            ]);
        });

        return back()->with('success', 'Peminjaman berhasil disetujui.');
    }

    /**
     * Reject peminjaman
     */
    public function reject(Request $request, Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Peminjaman tidak dapat ditolak.');
        }

        $request->validate([
            'catatan_admin' => ['required', 'string'],
        ]);

        $peminjaman->update([
            'status' => 'ditolak',
            'catatan_admin' => $request->catatan_admin,
            'disetujui_oleh' => auth()->id(),
            'tanggal_disetujui' => now(),
        ]);

        // Log activity
        Aktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menolak Peminjaman',
            'deskripsi' => "Peminjaman {$peminjaman->kode_peminjaman} ditolak oleh petugas",
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Hand over equipment (change status to dipinjam)
     */
    public function handOver(Peminjaman $peminjaman)
    {
        if ($peminjaman->status !== 'disetujui') {
            return back()->with('error', 'Peminjaman belum disetujui atau sudah diserahkan.');
        }

        $peminjaman->update([
            'status' => 'dipinjam',
        ]);

        // Log activity
        Aktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Menyerahkan Alat',
            'deskripsi' => "Alat untuk peminjaman {$peminjaman->kode_peminjaman} telah diserahkan kepada {$peminjaman->user->username}",
        ]);

        return back()->with('success', 'Alat berhasil diserahkan kepada peminjam.');
    }
}
