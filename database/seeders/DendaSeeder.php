<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Denda;
use App\Models\Pengembalian;
use App\Models\User;
use Illuminate\Support\Carbon;

class DendaSeeder extends Seeder
{
    public function run(): void
    {
        $pengembalians = Pengembalian::doesntHave('denda')
            ->where(function($q){
                $q->where('terlambat', true)
                  ->orWhere('kondisi_alat', '!=', 'baik');
            })->get();

        // Fallback: jika tidak ada hasil spesifik, coba semua pengembalians tanpa denda
        if ($pengembalians->isEmpty()) {
            $pengembalians = Pengembalian::doesntHave('denda')->get();
        }

        if ($pengembalians->isEmpty()) {
            return;
        }

        $admin = User::whereHas('role', function($q){ $q->where('nama_role','admin'); })->first() ?? User::first();

        foreach ($pengembalians as $p) {
            $calc = Denda::hitungDenda($p);

            if (empty($calc['total_denda']) || $calc['total_denda'] <= 0) {
                continue;
            }

            // Randomly mark some as already paid for sample data
            $isPaid = (bool) rand(0, 1);

            $data = [
                'pengembalian_id' => $p->id,
                'denda_keterlambatan' => $calc['denda_keterlambatan'],
                'denda_kerusakan' => $calc['denda_kerusakan'],
                'total_denda' => $calc['total_denda'],
                'status' => $isPaid ? 'sudah_dibayar' : 'belum_dibayar',
                'bukti_pembayaran' => null,
                'tanggal_pembayaran' => $isPaid ? Carbon::now()->subDays(rand(0,5)) : null,
                'dikonfirmasi_oleh' => $isPaid ? ($admin ? $admin->id : null) : null,
            ];

            Denda::create($data);
        }
    }
}
