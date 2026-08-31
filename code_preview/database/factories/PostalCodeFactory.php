<?php

namespace Database\Factories;

use App\Models\PostalCode;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PostalCode>
 */
class PostalCodeFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'code' => $this->faker->postcode(),
        ];
    }
    public function configure()
    {
        return $this->afterCreating(function (PostalCode $postalCode) {
            // Attach the postal code to a random city
            $city = \App\Models\City::inRandomOrder()->first();
            if ($city) {
                $postalCode->cities()->attach($city);
            }
        });
    }
}
