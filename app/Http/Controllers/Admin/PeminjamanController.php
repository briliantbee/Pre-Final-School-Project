<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\User;
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
            'ditolak' => Peminjaman::where('status', 'ditolak')->count(),
        ];

        return view('admin.peminjamans.index', compact('peminjamans', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $users = User::whereHas('role', function($q) {
            $q->where('nama_role', 'peminjam');
        })->get();
        
        $alats = Alat::where('status', 'tersedia')
            ->where('stok_tersedia', '>', 0)
            ->get();
            
        return view('admin.peminjamans.create', compact('users', 'alats'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'user_id' => ['required', 'exists:users,id'],
            'alat_id' => ['required', 'exists:alats,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_peminjaman' => ['required', 'date'],
            'tanggal_berakhir_peminjaman' => ['required', 'date', 'after:tanggal_peminjaman'],
            'keperluan' => ['nullable', 'string'],
            'catatan_admin' => ['nullable', 'string'],
        ]);

        $alat = Alat::findOrFail($validated['alat_id']);
        
        if ($alat->stok_tersedia < $validated['jumlah']) {
            return back()->with('error', 'Stok alat tidak mencukupi.');
        }

        DB::transaction(function () use ($validated, $alat) {
            // Generate kode peminjaman
            $lastPeminjaman = Peminjaman::latest('id')->first();
            $number = $lastPeminjaman ? ((int) substr($lastPeminjaman->kode_peminjaman, 4)) + 1 : 1;
            $validated['kode_peminjaman'] = 'PMJ' . str_pad($number, 5, '0', STR_PAD_LEFT);
            
            $validated['status'] = 'disetujui';
            $validated['disetujui_oleh'] = auth()->id();
            $validated['tanggal_disetujui'] = now();

            $peminjaman = Peminjaman::create($validated);

            // Update stok
            $alat->decrement('stok_tersedia', $validated['jumlah']);
            if ($alat->stok_tersedia == 0) {
                $alat->update(['status' => 'tidak_tersedia']);
            }

            // Log activity
            Aktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Membuat Peminjaman',
                'deskripsi' => "Admin membuat peminjaman {$peminjaman->kode_peminjaman} untuk user {$peminjaman->user->username}",
            ]);
        });

        return redirect()->route('admin.peminjamans.index')
            ->with('success', 'Peminjaman berhasil dibuat dan disetujui.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        $peminjaman->load(['user', 'alat.kategori', 'disetujuiOleh', 'pengembalian']);
        return view('admin.peminjamans.show', compact('peminjaman'));
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
                'deskripsi' => "Peminjaman {$peminjaman->kode_peminjaman} disetujui oleh admin",
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
            'deskripsi' => "Peminjaman {$peminjaman->kode_peminjaman} ditolak oleh admin",
        ]);

        return back()->with('success', 'Peminjaman berhasil ditolak.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Peminjaman $peminjaman)
    {
        if (in_array($peminjaman->status, ['dipinjam', 'disetujui'])) {
            return back()->with('error', 'Tidak dapat menghapus peminjaman yang sedang aktif.');
        }

        // If status is approved/borrowed, return the stock
        if ($peminjaman->status === 'disetujui' || $peminjaman->status === 'dipinjam') {
            $alat = $peminjaman->alat;
            $alat->increment('stok_tersedia', $peminjaman->jumlah);
            if ($alat->stok_tersedia > 0) {
                $alat->update(['status' => 'tersedia']);
            }
        }

        $peminjaman->delete();

        return redirect()->route('admin.peminjamans.index')
            ->with('success', 'Peminjaman berhasil dihapus.');
    }
}
