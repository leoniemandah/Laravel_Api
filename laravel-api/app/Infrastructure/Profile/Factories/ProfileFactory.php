<?php

namespace App\Infrastructure\Profile\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Domain\Profile\Models\Profile;

class ProfileFactory extends Factory
{


    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'lastName' => $this->faker->lastName(),
            'firstName' => $this->faker->firstName(),
            'image' => $this->faker->imageUrl(640, 480),
            'status' => $this->faker->randomElement(['inactif', 'en_attente', 'actif']),
            'created_at' => now(),
            'updated_at' => now(),
        ];
    }
}
