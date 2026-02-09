<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Pengembalian;
use App\Models\Peminjaman;
use App\Models\User;
use Illuminate\Support\Carbon;

class PengembalianSeeder extends Seeder
{
    public function run(): void
    {
        $peminjamans = Peminjaman::where('status', 'dikembalikan')->get();
        if ($peminjamans->isEmpty()) {
            return;
        }

        $admin = User::whereHas('role', function($q){ $q->where('nama_role','admin'); })->first() ?? User::first();

        $kondisiOptions = ['baik', 'rusak', 'hilang', 'tidak_lengkap'];

        foreach ($peminjamans as $pmj) {
            if ($pmj->pengembalian) {
                continue; // already has a pengembalian
            }

            $jumlah = $pmj->jumlah ?? 1;
            $baseDate = $pmj->tanggal_berakhir_peminjaman ? Carbon::parse($pmj->tanggal_berakhir_peminjaman) : Carbon::today();
            $tanggal_pengembalian = (clone $baseDate)->addDays(rand(0, 3));

            $terlambat = $tanggal_pengembalian->gt($baseDate);
            $hari_terlambat = $terlambat ? $tanggal_pengembalian->diffInDays($baseDate) : 0;

            $kondisi = $kondisiOptions[array_rand($kondisiOptions)];

            $data = [
                'peminjaman_id' => $pmj->id,
                'tanggal_pengembalian' => $tanggal_pengembalian->toDateString(),
                'jumlah_dikembalikan' => $jumlah,
                'kondisi_alat' => $kondisi,
                'diterima_oleh' => $admin ? $admin->id : null,
                'terlambat' => $terlambat,
                'hari_terlambat' => $hari_terlambat,
                'catatan' => null,
            ];

            $pengembalian = Pengembalian::create($data);

            // adjust alat stok jika barang dikembalikan (kecuali hilang)
            try {
                if ($pmj->alat && $kondisi !== 'hilang') {
                    $pmj->alat->increment('stok_tersedia', $jumlah);
                    if ($pmj->alat->stok_tersedia > 0) {
                        $pmj->alat->update(['status' => 'tersedia']);
                    }
                }
            } catch (\Exception $e) {
                // ignore stok update errors in seeder
            }
        }
    }
}
