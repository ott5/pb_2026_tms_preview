<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountryRegionSeeder extends Seeder
{
    public function run(): void
    {
        $polandRegions = [
            ['name' => 'Masovian', 'code' => 'MZ'],
            ['name' => 'Greater Poland', 'code' => 'WP'],
            ['name' => 'Lesser Poland', 'code' => 'MA'],
            ['name' => 'Lower Silesian', 'code' => 'DS'],
            ['name' => 'Silesian', 'code' => 'SL'],
            ['name' => 'Łódź', 'code' => 'LD'],
            ['name' => 'Pomeranian', 'code' => 'PM'],
            ['name' => 'West Pomeranian', 'code' => 'ZP'],
            ['name' => 'Kuyavian-Pomeranian', 'code' => 'KP'],
            ['name' => 'Subcarpathian', 'code' => 'PK'],
            ['name' => 'Lublin', 'code' => 'LU'],
            ['name' => 'Warmian-Masurian', 'code' => 'WN'],
            ['name' => 'Świętokrzyskie', 'code' => 'SK'],
            ['name' => 'Podlaskie', 'code' => 'PD'],
            ['name' => 'Lubusz', 'code' => 'LB'],
            ['name' => 'Opole', 'code' => 'OP'],
        ];

        $poland = \App\Models\Country::where('code', 'PL')->first();
        if ($poland) {
            foreach ($polandRegions as $region) {
                \App\Models\CountryRegion::updateOrCreate(
                    ['country_id' => $poland->id, 'code' => $region['code']],
                    ['name' => $region['name']]
                );
            }
        }
        $otherRegions = [
            // Austria
            'AT' => [['name' => 'Vienna', 'code' => '9'], ['name' => 'Tyrol', 'code' => '7'], ['name' => 'Salzburg', 'code' => '5']],
            // Germany
            'DE' => [['name' => 'Bavaria', 'code' => 'BY'], ['name' => 'Berlin', 'code' => 'BE'], ['name' => 'North Rhine-Westphalia', 'code' => 'NW']],
            // France
            'FR' => [['name' => 'Île-de-France', 'code' => 'IDF'], ['name' => 'Provence-Alpes-Côte d\'Azur', 'code' => 'PAC'], ['name' => 'Auvergne-Rhône-Alpes', 'code' => 'ARA']],
            // United Kingdom
            'GB' => [['name' => 'England', 'code' => 'ENG'], ['name' => 'Scotland', 'code' => 'SCT'], ['name' => 'Wales', 'code' => 'WLS']],
            // Italy
            'IT' => [['name' => 'Lombardy', 'code' => 'LOM'], ['name' => 'Lazio', 'code' => 'LAZ'], ['name' => 'Veneto', 'code' => 'VEN']],
            // Spain
            'ES' => [['name' => 'Madrid', 'code' => 'MD'], ['name' => 'Catalonia', 'code' => 'CT'], ['name' => 'Andalusia', 'code' => 'AN']],
            // Czech Republic
            'CZ' => [['name' => 'Prague', 'code' => 'PR'], ['name' => 'South Moravian', 'code' => 'JM'], ['name' => 'Central Bohemian', 'code' => 'ST']],
            // Netherlands
            'NL' => [['name' => 'North Holland', 'code' => 'NH'], ['name' => 'South Holland', 'code' => 'ZH'], ['name' => 'Utrecht', 'code' => 'UT']],
        ];
        foreach ($otherRegions as $countryCode => $regions) {
            $country = \App\Models\Country::where('code', $countryCode)->first();
            if ($country) {
                foreach ($regions as $region) {
                    \App\Models\CountryRegion::updateOrCreate(
                        ['country_id' => $country->id, 'code' => $region['code']],
                        ['name' => $region['name']]
                    );
                }
            }
        }
        //$this->call(CitySeeder::class);
        //$this->call(AdministrativeDivisionSeeder::class);
    }
}