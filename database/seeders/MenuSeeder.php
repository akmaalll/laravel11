<?php

namespace Database\Seeders;

use App\Models\Menu;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $menu = [
            ['name' => 'APPS', 'icon' => '', 'url' => '#', 'index' => 1, 'main_menu' => 'APPS', 'active' => '1', 'parent' => '0'],
            ['name' => 'DATA MASTER', 'icon' => '', 'url' => '#', 'index' => 2, 'main_menu' => 'DATA MASTER', 'active' => '1', 'parent' => '0'],
            ['name' => 'USER', 'icon' => '', 'url' => '#', 'index' => 3, 'main_menu' => 'USER',  'active' => '1', 'parent' => '0'],
            ['name' => 'USER SETTING', 'icon' => '', 'url' => '#', 'index' => 4, 'main_menu' => 'USER SETTING', 'active' => '1', 'parent' => '0'],

            // APPS
            ['name' => 'Pengajuan Judul', 'icon' => 'bi-stack', 'url' => 'pengajuan-judul', 'index' => 1, 'main_menu' => 'DATA MASTER', 'active' => '1', 'parent' => '1'],
            ['name' => 'Pembimbing', 'icon' => 'bi-stack', 'url' => 'pembimbing', 'index' => 1, 'main_menu' => 'DATA MASTER', 'active' => '1', 'parent' => '1'],
            ['name' => 'Assignment Pembimbing', 'icon' => 'bi-robot', 'url' => 'pembimbing/assignment', 'index' => 2, 'main_menu' => 'DATA MASTER', 'active' => '1', 'parent' => '1'],

            // DATA MASTER
            ['name' => 'Judul', 'icon' => 'bi-stack', 'url' => 'judul', 'index' => 1, 'main_menu' => 'DATA MASTER', 'active' => '1', 'parent' => '2'],
            ['name' => 'Dosen', 'icon' => 'bi-stack', 'url' => 'dosen', 'index' => 1, 'main_menu' => 'DATA MASTER', 'active' => '1', 'parent' => '2'],
            ['name' => 'Prodi', 'icon' => 'bi-stack', 'url' => 'prodi', 'index' => 1, 'main_menu' => 'DATA MASTER', 'active' => '1', 'parent' => '2'],
            ['name' => 'Keahlian', 'icon' => 'bi-stack', 'url' => 'keahlian', 'index' => 1, 'main_menu' => 'DATA MASTER', 'active' => '1', 'parent' => '2'],
            ['name' => 'Matkul Dosen', 'icon' => 'bi-stack', 'url' => 'matkul-dosen', 'index' => 1, 'main_menu' => 'DATA MASTER', 'active' => '1', 'parent' => '2'],


            // USER
            ['name' => 'User', 'icon' => 'bi-people-fill', 'url' => 'users', 'index' => 0, 'main_menu' => 'USERS', 'active' => '1', 'parent' => '3'],

            // USER SETTING
            ['name' => 'Role', 'icon' => 'bi-gear-wide', 'url' => 'roles', 'index' => 0, 'main_menu' => 'USER SETTING', 'active' => '1', 'parent' => '4'],
            ['name' => 'Menu', 'icon' => 'bi-card-list', 'url' => 'menus', 'index' => 0, 'main_menu' => 'USER SETTING', 'active' => '1', 'parent' => '4'],
            ['name' => 'User Menu', 'icon' => 'bi-gear-fill', 'url' => 'user-menus', 'index' => 0, 'main_menu' => 'USER SETTING', 'active' => '1', 'parent' => '4'],
            ['name' => 'Settings', 'icon' => 'bi-gear-fill', 'url' => 'settings', 'index' => 0, 'main_menu' => 'USER SETTING', 'active' => '1', 'parent' => '4'],

        ];

        foreach ($menu as $v) {
            Menu::create([
                'main_menu' => 'APPS',
                'sub_parent' => '0',
                'parent' => $v['parent'],
                'name' => $v['name'],
                'icon' => $v['icon'],
                'url' => $v['url'],
                'index' => $v['index'],
                'active' => $v['active'],
            ]);
        }
    }
}
