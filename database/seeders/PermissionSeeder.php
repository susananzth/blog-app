<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $permissions = [
            // User
            ['id' => 1, 'title' => 'user_index', 'menu' => 'Administrator', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2, 'title' => 'user_add', 'menu' => 'Administrator', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'title' => 'user_edit', 'menu' => 'Administrator', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'title' => 'user_delete', 'menu' => 'Administrator', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now()],
            // Role
            ['id' => 5, 'title' => 'role_index', 'menu' => 'Role', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 6, 'title' => 'role_add', 'menu' => 'Role', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 7, 'title' => 'role_edit', 'menu' => 'Role', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 8, 'title' => 'role_delete', 'menu' => 'Role', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now()],
            // Category
            ['id' => 9, 'title' => 'category_index', 'menu' => 'Category', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 10, 'title' => 'category_add', 'menu' => 'Category', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 11, 'title' => 'category_edit', 'menu' => 'Category', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 12, 'title' => 'category_delete', 'menu' => 'Category', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now()],
            // Post
            ['id' => 13, 'title' => 'post_index', 'menu' => 'Post', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 14, 'title' => 'post_add', 'menu' => 'Post', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 15, 'title' => 'post_edit', 'menu' => 'Post', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now()],
            ['id' => 16, 'title' => 'post_delete', 'menu' => 'Post', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now()],
        ];

        Permission::insert($permissions);
    }
}
