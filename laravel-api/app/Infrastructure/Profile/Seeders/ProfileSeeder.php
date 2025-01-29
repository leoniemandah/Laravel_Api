<?php

namespace App\Infrastructure\Profile\Seeders;

use Illuminate\Database\Seeder;
use App\Infrastructure\Profile\Factories\ProfileFactory;

class ProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProfileFactory::new()->count(20)->create();

    }
}
