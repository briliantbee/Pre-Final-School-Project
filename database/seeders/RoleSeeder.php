<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    public function run(): void
    {
        $roles = [
            ['id' => 1, 'nama_role' => 'Admin'],
            ['id' => 2, 'nama_role' => 'Petugas'],
            ['id' => 3, 'nama_role' => 'Siswa'],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }
    }
}