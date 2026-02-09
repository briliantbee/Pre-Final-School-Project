<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\Denda;
use App\Models\Aktivitas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengembalian::with(['peminjaman.user', 'peminjaman.alat', 'diterimaDosen']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('peminjaman', function($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('username', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('kondisi')) {
            $query->where('kondisi_alat', $request->kondisi);
        }

        if ($request->filled('terlambat')) {
            $query->where('terlambat', $request->terlambat === 'ya');
        }

        $pengembalians = $query->latest()->paginate(15);

        $stats = [
            'total' => Pengembalian::count(),
            'terlambat' => Pengembalian::where('terlambat', true)->count(),
            'rusak' => Pengembalian::where('kondisi_alat', 'rusak')->count(),
            'hilang' => Pengembalian::where('kondisi_alat', 'hilang')->count(),
        ];

        return view('petugas.pengembalians.index', compact('pengembalians', 'stats'));
    }

    /**
     * Show the form for creating a new resource (processing return).
     */
    public function create(Request $request)
    {
        // Get peminjaman that can be returned
        $query = Peminjaman::with(['user', 'alat'])
            ->whereIn('status', ['dipinjam', 'disetujui'])
            ->whereDoesntHave('pengembalian');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('username', 'like', "%{$search}%");
                  });
            });
        }

        $peminjamans = $query->get();

        return view('petugas.pengembalians.create', compact('peminjamans'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'peminjaman_id' => ['required', 'exists:peminjamans,id'],
            'tanggal_pengembalian' => ['required', 'date'],
            'jumlah_dikembalikan' => ['required', 'integer', 'min:1'],
            'kondisi_alat' => ['required', 'in:baik,rusak,hilang,tidak_lengkap'],
            'catatan' => ['nullable', 'string'],
        ]);

        $peminjaman = Peminjaman::findOrFail($validated['peminjaman_id']);
        
        if ($validated['jumlah_dikembalikan'] > $peminjaman->jumlah) {
            return back()->with('error', 'Jumlah yang dikembalikan melebihi jumlah yang dipinjam.');
        }

        DB::transaction(function () use ($validated, $peminjaman) {
            $validated['diterima_oleh'] = auth()->id();

            // Calculate if late
            $tanggalKembali = Carbon::parse($validated['tanggal_pengembalian']);
            $tanggalBerakhir = Carbon::parse($peminjaman->tanggal_berakhir_peminjaman);
            $terlambat = $tanggalKembali->gt($tanggalBerakhir);
            $hariTerlambat = $terlambat ? $tanggalKembali->diffInDays($tanggalBerakhir) : 0;

            $validated['terlambat'] = $terlambat;
            $validated['hari_terlambat'] = $hariTerlambat;

            $pengembalian = Pengembalian::create($validated);

            // Update peminjaman status
            $peminjaman->update([
                'status' => 'dikembalikan',
            ]);

            // Return stock
            $alat = $peminjaman->alat;
            $alat->increment('stok_tersedia', $validated['jumlah_dikembalikan']);
            
            if ($alat->stok_tersedia > 0 && $alat->status === 'tidak_tersedia') {
                $alat->update(['status' => 'tersedia']);
            }

            // Create denda if needed
            if ($terlambat || $validated['kondisi_alat'] !== 'baik') {
                $totalDenda = 0;

                // Denda keterlambatan (misalnya 5000 per hari)
                if ($terlambat) {
                    $totalDenda += $hariTerlambat * 5000;
                }

                // Denda kerusakan/kehilangan
                if ($validated['kondisi_alat'] === 'rusak') {
                    $totalDenda += 50000; // Misalnya 50k untuk rusak
                } elseif ($validated['kondisi_alat'] === 'hilang') {
                    $totalDenda += 200000; // Misalnya 200k untuk hilang
                } elseif ($validated['kondisi_alat'] === 'tidak_lengkap') {
                    $totalDenda += 25000; // Misalnya 25k untuk tidak lengkap
                }

                if ($totalDenda > 0) {
                    Denda::create([
                        'pengembalian_id' => $pengembalian->id,
                        'total_denda' => $totalDenda,
                        'status' => 'belum_dibayar',
                    ]);
                }
            }

            // Log activity
            Aktivitas::create([
                'user_id' => auth()->id(),
                'aktivitas' => 'Memproses Pengembalian',
                'deskripsi' => "Pengembalian untuk peminjaman {$peminjaman->kode_peminjaman} telah diproses",
            ]);
        });

        return redirect()->route('petugas.pengembalians.index')
            ->with('success', 'Pengembalian berhasil diproses.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengembalian $pengembalian)
    {
        $pengembalian->load([
            'peminjaman.user',
            'peminjaman.alat.kategori',
            'diterimaDosen',
            'denda'
        ]);
        
        return view('petugas.pengembalians.show', compact('pengembalian'));
    }
}
