<?php

use App\Infrastructure\Admin\Seeders\AdminSeeder;
use App\Infrastructure\Profile\Seeders\ProfileSeeder;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call(AdminSeeder::class);
        $this->call(ProfileSeeder::class);
    }
}
