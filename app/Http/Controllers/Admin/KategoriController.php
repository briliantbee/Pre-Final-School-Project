<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;

class KategoriController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Kategori::withCount('alats');

        if ($request->filled('search')) {
            $query->where('nama_kategori', 'like', "%{$request->search}%");
        }

        $kategoris = $query->latest()->paginate(15);

        return view('admin.kategoris.index', compact('kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.kategoris.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategoris'],
        ]);

        Kategori::create($validated);

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Kategori $kategori)
    {
        $kategori->load(['alats' => function($query) {
            $query->withCount('peminjamans');
        }]);
        
        return view('admin.kategoris.show', compact('kategori'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Kategori $kategori)
    {
        return view('admin.kategoris.edit', compact('kategori'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $validated = $request->validate([
            'nama_kategori' => ['required', 'string', 'max:255', 'unique:kategoris,nama_kategori,' . $kategori->id],
        ]);

        $kategori->update($validated);

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Kategori $kategori)
    {
        if ($kategori->alats()->count() > 0) {
            return back()->with('error', 'Tidak dapat menghapus kategori yang masih memiliki alat.');
        }

        $kategori->delete();

        return redirect()->route('admin.kategoris.index')
            ->with('success', 'Kategori berhasil dihapus.');
    }
}
