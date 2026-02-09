<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'admin',
                'password' => Hash::make('admin123'),
                'email' => 'admin@pplg.sch.id',
                'nama_lengkap' => 'Administrator',
                'nomor_identitas' => 'ADM001',
                'role_id' => 1, // Admin
            ],
            [
                'name' => 'petugas1',
                'password' => Hash::make('petugas123'),
                'email' => 'petugas1@pplg.sch.id',
                'nama_lengkap' => 'Petugas Satu',
                'nomor_identitas' => 'PTG001',
                'role_id' => 2, // Petugas
            ],
            [
                'name' => 'siswa1',
                'password' => Hash::make('siswa123'),
                'email' => 'siswa1@pplg.sch.id',
                'nama_lengkap' => 'Siswa Contoh',
                'nomor_identitas' => '2024001',
                'role_id' => 3, // Siswa
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}