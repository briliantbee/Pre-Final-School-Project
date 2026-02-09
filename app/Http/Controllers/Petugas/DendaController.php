<?php

namespace App\Http\Controllers\Petugas;

use App\Http\Controllers\Controller;
use App\Models\Denda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Denda::with(['pengembalian.peminjaman.user', 'pengembalian.peminjaman.alat']);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->whereHas('pengembalian.peminjaman', function($q) use ($search) {
                $q->where('kode_peminjaman', 'like', "%{$search}%")
                  ->orWhereHas('user', function($subQ) use ($search) {
                      $subQ->where('username', 'like', "%{$search}%");
                  });
            });
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $dendas = $query->latest()->paginate(15);

        $stats = [
            'total_denda' => Denda::sum('total_denda'),
            'sudah_dibayar' => Denda::where('status', 'sudah_dibayar')->sum('total_denda'),
            'belum_dibayar' => Denda::where('status', 'belum_dibayar')->sum('total_denda'),
            'jumlah_belum_dibayar' => Denda::where('status', 'belum_dibayar')->count(),
        ];

        return view('petugas.dendas.index', compact('dendas', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Denda $denda)
    {
        $denda->load([
            'pengembalian.peminjaman.user',
            'pengembalian.peminjaman.alat',
            'pengembalian.diterimaDosen'
        ]);
        
        return view('petugas.dendas.show', compact('denda'));
    }

    /**
     * Confirm payment
     */
    public function confirmPayment(Request $request, Denda $denda)
    {
        $request->validate([
            'bukti_pembayaran' => ['required', 'image', 'max:2048'],
        ]);

        if ($request->hasFile('bukti_pembayaran')) {
            // Delete old proof if exists
            if ($denda->bukti_pembayaran) {
                Storage::disk('public')->delete($denda->bukti_pembayaran);
            }
            
            $path = $request->file('bukti_pembayaran')->store('bukti-pembayaran', 'public');
            
            $denda->update([
                'bukti_pembayaran' => $path,
                'status' => 'sudah_dibayar',
            ]);
        }

        return back()->with('success', 'Pembayaran denda berhasil dikonfirmasi.');
    }
}
