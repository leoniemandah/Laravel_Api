<?php

namespace App\Infrastructure\Admin\Seeders;

use App\Infrastructure\Admin\Factories\AdminFactory;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        AdminFactory::new()->count(10)->create();

    }
}
