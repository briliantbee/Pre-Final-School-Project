<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use Illuminate\Http\Request;

class PengembalianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Pengembalian::with(['peminjaman.alat', 'diterimaDosen', 'denda'])
            ->whereHas('peminjaman', function($q) {
                $q->where('user_id', auth()->id());
            });

        if ($request->filled('kondisi')) {
            $query->where('kondisi_alat', $request->kondisi);
        }

        if ($request->filled('terlambat')) {
            $query->where('terlambat', $request->terlambat === 'ya');
        }

        $pengembalians = $query->latest()->paginate(15);

        $stats = [
            'total' => Pengembalian::whereHas('peminjaman', function($q) {
                $q->where('user_id', auth()->id());
            })->count(),
            'terlambat' => Pengembalian::whereHas('peminjaman', function($q) {
                $q->where('user_id', auth()->id());
            })->where('terlambat', true)->count(),
        ];

        return view('peminjam.pengembalians.index', compact('pengembalians', 'stats'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Pengembalian $pengembalian)
    {
        // Make sure user can only see their own pengembalian
        if ($pengembalian->peminjaman->user_id !== auth()->id()) {
            abort(403, 'Unauthorized action.');
        }

        $pengembalian->load([
            'peminjaman.alat.kategori',
            'diterimaDosen',
            'denda'
        ]);
        
        return view('peminjam.pengembalians.show', compact('pengembalian'));
    }
}
