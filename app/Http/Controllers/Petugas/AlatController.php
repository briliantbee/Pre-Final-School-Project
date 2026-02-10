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

    /**
     * Export alat data to Excel (CSV format)
     */
    public function exportExcel(Request $request)
    {
        $query = Alat::with('kategori')->withCount(['peminjamans' => function($q) {
            $q->whereIn('status', ['dipinjam', 'disetujui']);
        }]);

        // Apply filters from request
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

        $alats = $query->latest()->get();

        $filename = 'laporan_alat_' . date('Y-m-d_His') . '.csv';

        $headers = [
            'Content-Type' => 'text/csv; charset=UTF-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0'
        ];

        $callback = function() use ($alats) {
            $file = fopen('php://output', 'w');
            
            // Add BOM for UTF-8 encoding
            fprintf($file, chr(0xEF).chr(0xBB).chr(0xBF));

            // Header row
            fputcsv($file, [
                'Kode Alat',
                'Nama Alat',
                'Kategori',
                'Spesifikasi',
                'Stok Total',
                'Stok Tersedia',
                'Peminjaman Aktif',
                'Status',
                'Lokasi Penyimpanan'
            ]);

            // Data rows
            foreach ($alats as $alat) {
                fputcsv($file, [
                    $alat->kode_alat,
                    $alat->nama_alat,
                    $alat->kategori->nama_kategori ?? '-',
                    $alat->spesifikasi ?? '-',
                    $alat->stok_total,
                    $alat->stok_tersedia,
                    $alat->peminjamans_count ?? 0,
                    match($alat->status) {
                        'tersedia' => 'Tersedia',
                        'dipinjam' => 'Dipinjam',
                        'maintenance' => 'Maintenance',
                        'tidak_tersedia' => 'Tidak Tersedia',
                        default => $alat->status
                    },
                    $alat->lokasi_penyimpanan ?? '-'
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
