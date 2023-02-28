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
            ['title' => 'user_index', 'menu' => 'Administrator', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'user_add', 'menu' => 'Administrator', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'user_edit', 'menu' => 'Administrator', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'user_delete', 'menu' => 'Administrator', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now()],
            // Role
            ['title' => 'role_index', 'menu' => 'Role', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'role_add', 'menu' => 'Role', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'role_edit', 'menu' => 'Role', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'role_delete', 'menu' => 'Role', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now()],
            // Category
            ['title' => 'category_index', 'menu' => 'Category', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'category_add', 'menu' => 'Category', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'category_edit', 'menu' => 'Category', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'category_delete', 'menu' => 'Category', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now()],
            // Post
            ['title' => 'post_index', 'menu' => 'Post', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'post_add', 'menu' => 'Post', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'post_edit', 'menu' => 'Post', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'post_delete', 'menu' => 'Post', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now()],
            // Tags
            ['title' => 'tag_index', 'menu' => 'Tag', 'permission' => 'See', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'tag_add', 'menu' => 'Tag', 'permission' => 'Add', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'tag_edit', 'menu' => 'Tag', 'permission' => 'Edit', 'created_at' => now(), 'updated_at' => now()],
            ['title' => 'tag_delete', 'menu' => 'Tag', 'permission' => 'Delete', 'created_at' => now(), 'updated_at' => now()],
        ];

        Permission::insert($permissions);
    }
}
