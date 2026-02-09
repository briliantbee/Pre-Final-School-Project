<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Peminjaman;
use App\Models\Alat;
use App\Models\User;
use Illuminate\Support\Carbon;

class PeminjamanSeeder extends Seeder
{
    public function run(): void
    {
        // pick some users (peminjam role) and alats
        $users = User::whereHas('role', function($q){ $q->where('nama_role', 'peminjam'); })->get();
        if ($users->isEmpty()) {
            $users = User::all();
        }

        $alats = Alat::where('stok_tersedia', '>', 0)->get();
        if ($alats->isEmpty()) {
            $alats = Alat::all();
        }

        if ($users->isEmpty() || $alats->isEmpty()) {
            return; // nothing to seed
        }

        $admin = User::whereHas('role', function($q){ $q->where('nama_role','admin'); })->first() ?? User::first();

        // helper to generate kode
        $nextNumber = function() {
            $last = Peminjaman::latest('id')->first();
            $num = $last ? ((int) substr($last->kode_peminjaman, 3)) + 1 : 1;
            return 'PMJ' . str_pad($num, 5, '0', STR_PAD_LEFT);
        };

        // create sample peminjaman with different statuses
        $samples = [
            'menunggu_konfirmasi',
            'disetujui',
            'dipinjam',
            'dikembalikan',
            'ditolak',
        ];

        foreach ($samples as $status) {
            $user = $users->random();
            $alat = $alats->random();
            $jumlah = 1;

            $tanggal_peminjaman = Carbon::today()->subDays(rand(0, 10));
            $tanggal_berakhir = (clone $tanggal_peminjaman)->addDays(rand(1, 7));

            $data = [
                'kode_peminjaman' => $nextNumber(),
                'user_id' => $user->id,
                'alat_id' => $alat->id,
                'jumlah' => $jumlah,
                'tanggal_peminjaman' => $tanggal_peminjaman->toDateString(),
                'tanggal_berakhir_peminjaman' => $tanggal_berakhir->toDateString(),
                'keperluan' => 'Testing seeder',
                'catatan_admin' => null,
                'status' => $status,
            ];

            if (in_array($status, ['disetujui','dipinjam','dikembalikan'])) {
                $data['disetujui_oleh'] = $admin ? $admin->id : null;
                $data['tanggal_disetujui'] = Carbon::now();
            }

            if ($status === 'ditolak') {
                $data['catatan_admin'] = 'Ditolak oleh admin (contoh)';
            }

            $p = Peminjaman::create($data);

            // adjust alat stok_tersedia for approved/borrowed
            if (in_array($status, ['disetujui','dipinjam'])) {
                $alat->decrement('stok_tersedia', $jumlah);
                if ($alat->stok_tersedia <= 0) {
                    $alat->update(['status' => 'tidak_tersedia']);
                }
            }
        }
    }
}
