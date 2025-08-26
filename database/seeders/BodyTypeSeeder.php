<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BodyType;

class BodyTypeSeeder extends Seeder
{
    public function run(): void
    {
        $bodyTypes = [
            ['name' => 'Sedan', 'slug' => 'sedan'],
            ['name' => 'Hatchback', 'slug' => 'hatchback'],
            ['name' => 'Wagon', 'slug' => 'wagon'],
            ['name' => 'Coupe', 'slug' => 'coupe'],
            ['name' => 'Convertible', 'slug' => 'convertible'],
            ['name' => 'SUV', 'slug' => 'suv'],
            ['name' => 'Crossover', 'slug' => 'crossover'],
            ['name' => 'Minivan', 'slug' => 'minivan'],
            ['name' => 'Pickup', 'slug' => 'pickup'],
            ['name' => 'Van', 'slug' => 'van']
        ];
        
        foreach ($bodyTypes as $bodyType) {
            BodyType::create($bodyType);
        }
    }
}
