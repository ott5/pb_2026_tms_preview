<?php

namespace Database\Factories;

use App\Models\City;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<City>
 */
class CityFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $region=\App\Models\CountryRegion::inRandomOrder()->first()??\App\Models\CountryRegion::factory();
        return [
            'name' => $this->faker->city(),
            'country_region_id' => $region->id
        ];
    }
}
