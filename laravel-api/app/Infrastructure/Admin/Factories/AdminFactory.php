<?php

namespace App\Infrastructure\Admin\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use App\Domain\Admin\Models\Admin;

class AdminFactory extends Factory
{


    protected $model = Admin::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'password' => Hash::make('password'), // Mot de passe par défaut
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
