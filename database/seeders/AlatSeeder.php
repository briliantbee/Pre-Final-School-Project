<?php

namespace Database\Seeders;

use App\Models\Alat;
use Illuminate\Database\Seeder;

class AlatSeeder extends Seeder
{
    public function run(): void
    {
        $alats = [
            // Perangkat Komputer
            [
                'nama_alat' => 'Laptop ASUS',
                'kode_alat' => 'LPT-001',
                'deskripsi' => 'Laptop ASUS ROG untuk pembelajaran programming',
                'stok' => 10,
                'stok_tersedia' => 10,
                'kategori_id' => 1,
                'status' => 'tersedia',
            ],
            [
                'nama_alat' => 'PC Rakitan',
                'kode_alat' => 'PC-001',
                'deskripsi' => 'PC Rakitan Intel Core i5',
                'stok' => 5,
                'stok_tersedia' => 5,
                'kategori_id' => 1,
                'status' => 'tersedia',
            ],
            // Perangkat Jaringan
            [
                'nama_alat' => 'Router MikroTik',
                'kode_alat' => 'RTR-001',
                'deskripsi' => 'Router MikroTik RB750',
                'stok' => 3,
                'stok_tersedia' => 3,
                'kategori_id' => 2,
                'status' => 'tersedia',
            ],
            [
                'nama_alat' => 'Switch 24 Port',
                'kode_alat' => 'SWT-001',
                'deskripsi' => 'Switch Gigabit 24 Port',
                'stok' => 4,
                'stok_tersedia' => 4,
                'kategori_id' => 2,
                'status' => 'tersedia',
            ],
            // Tools
            [
                'nama_alat' => 'Tang Crimping',
                'kode_alat' => 'TLS-001',
                'deskripsi' => 'Tang Crimping RJ45',
                'stok' => 15,
                'stok_tersedia' => 15,
                'kategori_id' => 3,
                'status' => 'tersedia',
            ],
            [
                'nama_alat' => 'LAN Tester',
                'kode_alat' => 'TLS-002',
                'deskripsi' => 'LAN Cable Tester',
                'stok' => 10,
                'stok_tersedia' => 10,
                'kategori_id' => 3,
                'status' => 'tersedia',
            ],
            // Komponen Elektronik
            [
                'nama_alat' => 'Arduino Uno',
                'kode_alat' => 'ARD-001',
                'deskripsi' => 'Arduino Uno R3 Original',
                'stok' => 20,
                'stok_tersedia' => 20,
                'kategori_id' => 4,
                'status' => 'tersedia',
            ],
            // Multimedia
            [
                'nama_alat' => 'Kamera DSLR',
                'kode_alat' => 'CAM-001',
                'deskripsi' => 'Kamera DSLR Canon EOS',
                'stok' => 2,
                'stok_tersedia' => 2,
                'kategori_id' => 5,
                'status' => 'tersedia',
            ],
        ];

        foreach ($alats as $alat) {
            Alat::create($alat);
        }
    }
}