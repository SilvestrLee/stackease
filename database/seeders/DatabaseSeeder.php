<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            CategorySeeder::class,
            ProviderSeeder::class,
            BatchWindowSeeder::class,
            DemoDataSeeder::class,
        ]);
    }
}