<?php

namespace Database\Seeders;

use App\Models\Role;
use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $admin_permissions = Permission::all();
        Role::findOrFail(2)->permissions()->sync($admin_permissions->pluck('id'));

        $user_permissions = Permission::where('permission', '<>', 'Delete')->get();
        Role::findOrFail(3)->permissions()->sync($user_permissions->pluck('id'));
    }
}
