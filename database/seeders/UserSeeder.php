<?php

namespace Database\Seeders;

use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = \App\Models\User::factory()->create([
            'name' => 'admin',
            'email' => 'admin@example.com',
            'email_verified_at' => now(),
            'password' => Hash::make('12345678'),
            'remember_token' => Str::random(10),
        ])->each(function ($user) {
            $user->roles()->save(\App\Models\Role::find(2));
            $user->save();
        });

        \App\Models\User::factory()->count(4)->create()->each(function ($user) {
            $user->roles()->save(\App\Models\Role::find(1));
            $user->save();
        });
    }
}
