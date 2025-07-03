<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $role = [
            ['role' => 'SU', 'role_name' => 'SuperUser'],
            ['role' => 'KP', 'role_name' => 'Kaprodi'],
            ['role' => 'MK', 'role_name' => 'Mahasiswa'],
        ];

        foreach ($role as $key => $v) {
            Role::create([
                'code' => $v['role'],
                'name' => $v['role_name'],
            ]);
        };
    }
}
