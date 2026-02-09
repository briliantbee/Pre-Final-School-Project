<?php

namespace App\Http\Controllers\Peminjam;

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
        $query = Denda::with(['pengembalian.peminjaman.alat'])
            ->whereHas('pengembalian.peminjaman', function($q) {
                $q->where('user_id', auth()->id());
            });

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $dendas = $query->latest()->paginate(15);

        $stats = [
            'total_denda' => Denda::whereHas('pengembalian.peminjaman', function($q) {
                $q->where('user_id', auth()->id());
            })->sum('total_denda'),
            'sudah_dibayar' => Denda::whereHas('pengembalian.peminjaman', function($q) {
                $q->where('user_id', auth()->id());
            })->where('status', 'sudah_dibayar')->sum('total_denda'),
            'belum_dibayar' => Denda::whereHas('pengembalian.peminjaman', function($q) {
                $q->where('user_id', auth()->id());
            })->where('status', 'belum_dibayar')->sum('total_denda'),
        ];

        return view('peminjam.dendas.index', compact('dendas', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Denda $denda)
    {
        // Make sure user can only see their own denda
        if ($denda->pengembalian->peminjaman->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $denda->load([
            'pengembalian.peminjaman.alat',
            'pengembalian.diterimaDosen'
        ]);
        
        return view('peminjam.dendas.show', compact('denda'));
    }

    /**
     * Upload bukti pembayaran
     */
    public function uploadBukti(Request $request, Denda $denda)
    {
        // Make sure user can only upload for their own denda
        if ($denda->pengembalian->peminjaman->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        if ($denda->status === 'sudah_dibayar') {
            return back()->with('error', 'Denda sudah dibayar.');
        }

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
            ]);
        }

        return back()->with('success', 'Bukti pembayaran berhasil diupload. Menunggu konfirmasi dari petugas.');
    }
}
