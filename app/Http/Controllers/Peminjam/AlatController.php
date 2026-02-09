<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Alat::with('kategori')
            ->where('status', 'tersedia')
            ->where('stok_tersedia', '>', 0);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('kode_alat', 'like', "%{$search}%")
                  ->orWhere('deskripsi', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        $alats = $query->latest()->paginate(12);
        $kategoris = Kategori::withCount(['alats' => function($q) {
            $q->where('status', 'tersedia')->where('stok_tersedia', '>', 0);
        }])->get();

        return view('peminjam.alats.index', compact('alats', 'kategoris'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Alat $alat)
    {
        $alat->load('kategori');
        
        // Check if user has active borrowing for this alat
        $hasActiveBorrowing = auth()->user()->peminjamans()
            ->where('alat_id', $alat->id)
            ->whereIn('status', ['dipinjam', 'disetujui', 'menunggu_konfirmasi'])
            ->exists();
        
        return view('peminjam.alats.show', compact('alat', 'hasActiveBorrowing'));
    }
}
