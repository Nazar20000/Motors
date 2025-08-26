<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Brand;

class BrandSeeder extends Seeder
{
    public function run(): void
    {
        $brands = [
            ['name' => 'Toyota', 'slug' => 'toyota'],
            ['name' => 'BMW', 'slug' => 'bmw'],
            ['name' => 'Mercedes', 'slug' => 'mercedes'],
            ['name' => 'Audi', 'slug' => 'audi'],
            ['name' => 'Ford', 'slug' => 'ford'],
        ];
        foreach ($brands as $brand) {
            Brand::create($brand);
        }
    }
}
