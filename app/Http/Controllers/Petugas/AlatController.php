<?php

namespace App\Http\Controllers\Petugas;

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
        $query = Alat::with('kategori')->withCount(['peminjamans' => function($q) {
            $q->whereIn('status', ['dipinjam', 'disetujui']);
        }]);

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_alat', 'like', "%{$search}%")
                  ->orWhere('kode_alat', 'like', "%{$search}%");
            });
        }

        if ($request->filled('kategori_id')) {
            $query->where('kategori_id', $request->kategori_id);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $alats = $query->latest()->paginate(15);
        $kategoris = Kategori::all();

        return view('petugas.alats.index', compact('alats', 'kategoris'));
    }

    /**
     * Display the specified resource.
     */
    public function show(Alat $alat)
    {
        $alat->load(['kategori', 'peminjamans' => function($query) {
            $query->with('user')->latest();
        }]);
        
        return view('petugas.alats.show', compact('alat'));
    }
}
