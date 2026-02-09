<?php

namespace Database\Seeders;

use App\Models\Kategori;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    public function run(): void
    {
        $kategoris = [
            [
                'nama_kategori' => 'Perangkat Komputer',
                'deskripsi' => 'Laptop, PC, dan perangkat komputer lainnya'
            ],
            [
                'nama_kategori' => 'Perangkat Jaringan',
                'deskripsi' => 'Router, Switch, Kabel UTP, dan perangkat jaringan'
            ],
            [
                'nama_kategori' => 'Tools & Peralatan',
                'deskripsi' => 'Obeng, Tang Crimping, LAN Tester, dan tools lainnya'
            ],
            [
                'nama_kategori' => 'Komponen Elektronik',
                'deskripsi' => 'Arduino, Sensor, Resistor, dan komponen elektronik'
            ],
            [
                'nama_kategori' => 'Multimedia',
                'deskripsi' => 'Kamera, Microphone, Speaker, dan peralatan multimedia'
            ],
        ];

        foreach ($kategoris as $kategori) {
            Kategori::create($kategori);
        }
    }
}