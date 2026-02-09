<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Alat;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlatController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Alat::with('kategori');

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

        return view('admin.alats.index', compact('alats', 'kategoris'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $kategoris = Kategori::all();
        return view('admin.alats.create', compact('kategoris'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'nama_alat' => ['required', 'string', 'max:255'],
            'kode_alat' => ['required', 'string', 'max:255', 'unique:alats'],
            'deskripsi' => ['nullable', 'string'],
            'stok' => ['required', 'integer', 'min:0'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        $validated['stok_tersedia'] = $validated['stok'];
        $validated['status'] = $validated['stok'] > 0 ? 'tersedia' : 'tidak_tersedia';

        if ($request->hasFile('foto')) {
            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }

        Alat::create($validated);

        return redirect()->route('admin.alats.index')
            ->with('success', 'Alat berhasil ditambahkan.');
    }

    /**
     * Display the specified resource.
     */
    public function show(Alat $alat)
    {
        $alat->load(['kategori', 'peminjamans.user']);
        return view('admin.alats.show', compact('alat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alat $alat)
    {
        $kategoris = Kategori::all();
        return view('admin.alats.edit', compact('alat', 'kategoris'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alat $alat)
    {
        $validated = $request->validate([
            'nama_alat' => ['required', 'string', 'max:255'],
            'kode_alat' => ['required', 'string', 'max:255', 'unique:alats,kode_alat,' . $alat->id],
            'deskripsi' => ['nullable', 'string'],
            'stok' => ['required', 'integer', 'min:0'],
            'kategori_id' => ['required', 'exists:kategoris,id'],
            'status' => ['required', 'in:tersedia,tidak_tersedia'],
            'foto' => ['nullable', 'image', 'max:2048'],
        ]);

        // Update stok_tersedia if stok changed
        $stokDifference = $validated['stok'] - $alat->stok;
        $validated['stok_tersedia'] = max(0, $alat->stok_tersedia + $stokDifference);

        if ($request->hasFile('foto')) {
            // Delete old image
            if ($alat->foto) {
                Storage::disk('public')->delete($alat->foto);
            }
            $validated['foto'] = $request->file('foto')->store('alat', 'public');
        }

        $alat->update($validated);

        return redirect()->route('admin.alats.index')
            ->with('success', 'Alat berhasil diupdate.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alat $alat)
    {
        // Check if alat has active peminjaman
        $hasActivePeminjaman = $alat->peminjamans()
            ->whereIn('status', ['dipinjam', 'disetujui', 'menunggu_konfirmasi'])
            ->exists();

        if ($hasActivePeminjaman) {
            return back()->with('error', 'Tidak dapat menghapus alat yang sedang dipinjam atau menunggu konfirmasi.');
        }

        if ($alat->foto) {
            Storage::disk('public')->delete($alat->foto);
        }

        $alat->delete();

        return redirect()->route('admin.alats.index')
            ->with('success', 'Alat berhasil dihapus.');
    }
}
