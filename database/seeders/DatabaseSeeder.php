<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            CategorySeeder::class,
            TagSeeder::class,
            CountrySeeder::class,
            StateSeeder::class,
            CitySeeder::class,
            CurrencySeeder::class,
            DocumentTypeSeeder::class,
            PermissionSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
