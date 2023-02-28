<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            [
                'title' => 'Cliente',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Super Administrador',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'title' => 'Editor',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        Role::insert($roles);
    }
}
