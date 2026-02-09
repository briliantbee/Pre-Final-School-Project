<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use Illuminate\Http\Request;

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

        return view('admin.pengembalians.index', compact('pengembalians', 'stats'));
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
        
        return view('admin.pengembalians.show', compact('pengembalian'));
    }
}
