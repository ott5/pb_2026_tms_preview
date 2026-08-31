<?php

namespace Database\Factories;

use App\Models\Address;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Address>
 */
class AddressFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'city_postal_code_id' => \App\Models\CityPostalCode::inRandomOrder()->first()->id,
            'street' => fake()->optional()->streetName(),
            'building_number' => fake()->buildingNumber(),
            'apartment_number' => fake()->optional()->randomNumber(2),
        ];
    }
}
