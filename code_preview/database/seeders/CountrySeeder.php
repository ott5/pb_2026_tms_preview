<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $countries = [
            ['name' => 'Austria', 'code' => 'AT', 'nationality' => 'Austrian'],
            ['name' => 'Belgium', 'code' => 'BE', 'nationality' => 'Belgian'],
            ['name' => 'Bulgaria', 'code' => 'BG', 'nationality' => 'Bulgarian'],
            ['name' => 'Croatia', 'code' => 'HR', 'nationality' => 'Croatian'],
            ['name' => 'Cyprus', 'code' => 'CY', 'nationality' => 'Cypriot'],
            ['name' => 'Czech Republic', 'code' => 'CZ', 'nationality' => 'Czech'],
            ['name' => 'Denmark', 'code' => 'DK', 'nationality' => 'Danish'],
            ['name' => 'Estonia', 'code' => 'EE', 'nationality' => 'Estonian'],
            ['name' => 'Finland', 'code' => 'FI', 'nationality' => 'Finnish'],
            ['name' => 'France', 'code' => 'FR', 'nationality' => 'French'],
            ['name' => 'Germany', 'code' => 'DE', 'nationality' => 'German'],
            ['name' => 'Greece', 'code' => 'GR', 'nationality' => 'Greek'],
            ['name' => 'Hungary', 'code' => 'HU', 'nationality' => 'Hungarian'],
            ['name' => 'Ireland', 'code' => 'IE', 'nationality' => 'Irish'],
            ['name' => 'Italy', 'code' => 'IT', 'nationality' => 'Italian'],
            ['name' => 'Latvia', 'code' => 'LV', 'nationality' => 'Latvian'],
            ['name' => 'Lithuania', 'code' => 'LT', 'nationality' => 'Lithuanian'],
            ['name' => 'Luxembourg', 'code' => 'LU', 'nationality' => 'Luxembourger'],
            ['name' => 'Malta', 'code' => 'MT', 'nationality' => 'Maltese'],
            ['name' => 'Netherlands', 'code' => 'NL', 'nationality' => 'Dutch'],
            ['name' => 'Poland', 'code' => 'PL', 'nationality' => 'Polish'],
            ['name' => 'Portugal', 'code' => 'PT', 'nationality' => 'Portuguese'],
            ['name' => 'Romania', 'code' => 'RO', 'nationality' => 'Romanian'],
            ['name' => 'Slovakia', 'code' => 'SK', 'nationality' => 'Slovak'],
            ['name' => 'Slovenia', 'code' => 'SI', 'nationality' => 'Slovenian'],
            ['name' => 'Spain', 'code' => 'ES', 'nationality' => 'Spanish'],
            ['name' => 'Sweden', 'code' => 'SE', 'nationality' => 'Swedish'],
            ['name' => 'United Kingdom', 'code' => 'GB', 'nationality' => 'British'],
            ['name' => 'Ukraine', 'code' => 'UA', 'nationality' => 'Ukrainian'],
            ['name' => 'Norway', 'code' => 'NO', 'nationality' => 'Norwegian'],
            ['name' => 'Switzerland', 'code' => 'CH', 'nationality' => 'Swiss'],
        ];
        foreach ($countries as $country) {
            \App\Models\Country::firstOrCreate($country);
        }
        $this->call(CountryRegionSeeder::class);
    }
}
