<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Models\Alat;
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
        $query = Peminjaman::with(['alat.kategori', 'disetujuiOleh'])
            ->where('user_id', auth()->id());

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('alat', function($subQ) use ($search) {
                      $subQ->where('nama_alat', 'like', "%{$search}%");
                  });
            });
        }

        $peminjamans = $query->latest()->paginate(15);

        $statusCounts = [
            'menunggu' => Peminjaman::where('user_id', auth()->id())
                ->where('status', 'menunggu_konfirmasi')->count(),
            'disetujui' => Peminjaman::where('user_id', auth()->id())
                ->where('status', 'disetujui')->count(),
            'dipinjam' => Peminjaman::where('user_id', auth()->id())
                ->where('status', 'dipinjam')->count(),
            'dikembalikan' => Peminjaman::where('user_id', auth()->id())
                ->where('status', 'dikembalikan')->count(),
            'ditolak' => Peminjaman::where('user_id', auth()->id())
                ->where('status', 'ditolak')->count(),
        ];

        return view('peminjam.peminjamans.index', compact('peminjamans', 'statusCounts'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request)
    {
        $alat = null;
        
        if ($request->filled('alat_id')) {
            $alat = Alat::findOrFail($request->alat_id);
            
            // Check if alat is available
            if ($alat->status !== 'tersedia' || $alat->stok_tersedia <= 0) {
                return redirect()->route('peminjam.alats.index')
                    ->with('error', 'Alat tidak tersedia untuk dipinjam.');
            }
            
            // Note: allow opening create form even if user has a pending peminjaman;
            // availability will be enforced on store to avoid accidental double-booking.
        }
        
        $alats = Alat::where('status', 'tersedia')
            ->where('stok_tersedia', '>', 0)
            ->get();

        return view('peminjam.peminjamans.create', compact('alats', 'alat'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'alat_id' => ['required', 'exists:alats,id'],
            'jumlah' => ['required', 'integer', 'min:1'],
            'tanggal_peminjaman' => ['required', 'date', 'after_or_equal:today'],
            'tanggal_berakhir_peminjaman' => ['required', 'date', 'after:tanggal_peminjaman'],
            'keperluan' => ['required', 'string', 'max:500'],
        ]);

        $alat = Alat::findOrFail($validated['alat_id']);
        
        // Calculate reserved quantity (including pending) to avoid overbooking
        $reserved = $alat->peminjamans()
            ->whereIn('status', ['menunggu_konfirmasi', 'disetujui', 'dipinjam'])
            ->sum('jumlah');

        $available = $alat->stok - $reserved;

        if ($validated['jumlah'] > $available) {
            return back()->with('error', 'Stok alat tidak mencukupi.');
        }

        DB::transaction(function () use ($validated) {
            // Generate kode peminjaman
            $lastPeminjaman = Peminjaman::latest('id')->first();
            $number = $lastPeminjaman ? ((int) substr($lastPeminjaman->kode_peminjaman, 4)) + 1 : 1;
            $validated['kode_peminjaman'] = 'PMJ' . str_pad($number, 5, '0', STR_PAD_LEFT);
            
            $validated['user_id'] = auth()->id();
            $validated['status'] = 'menunggu_konfirmasi';

            $peminjaman = Peminjaman::create($validated);

            // Log activity
            Aktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Mengajukan Peminjaman',
                'deskripsi' => "Peminjaman {$peminjaman->kode_peminjaman} telah diajukan",
            ]);
        });

        return redirect()->route('peminjam.peminjamans.index')
            ->with('success', 'Pengajuan peminjaman berhasil dibuat. Menunggu persetujuan admin/petugas.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Peminjaman $peminjaman)
    {
        // Make sure user can only see their own peminjaman
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $peminjaman->load(['alat.kategori', 'disetujuiOleh', 'pengembalian.denda']);
        return view('peminjam.peminjamans.show', compact('peminjaman'));
    }

    /**
     * Cancel peminjaman (only if status is menunggu_konfirmasi)
     */
    public function cancel(Peminjaman $peminjaman)
    {
        // Make sure user can only cancel their own peminjaman
        if ($peminjaman->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($peminjaman->status !== 'menunggu_konfirmasi') {
            return back()->with('error', 'Peminjaman tidak dapat dibatalkan.');
        }

        $peminjaman->update([
            'status' => 'ditolak',
            'catatan_admin' => 'Dibatalkan oleh peminjam',
        ]);

        // Log activity
        Aktivitas::create([
            'user_id' => auth()->id(),
            'aktivitas' => 'Membatalkan Peminjaman',
            'deskripsi' => "Peminjaman {$peminjaman->kode_peminjaman} dibatalkan oleh peminjam",
        ]);

        return back()->with('success', 'Peminjaman berhasil dibatalkan.');
    }
}
