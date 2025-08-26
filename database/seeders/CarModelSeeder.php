<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\CarModel;

class CarModelSeeder extends Seeder
{
    public function run(): void
    {
        $models = [
            ['name' => 'Corolla', 'brand_id' => 1, 'slug' => 'corolla'],
            ['name' => 'X5', 'brand_id' => 2, 'slug' => 'x5'],
            ['name' => 'C-Class', 'brand_id' => 3, 'slug' => 'c-class'],
            ['name' => 'A4', 'brand_id' => 4, 'slug' => 'a4'],
            ['name' => 'Focus', 'brand_id' => 5, 'slug' => 'focus'],
        ];
        foreach ($models as $model) {
            CarModel::create($model);
        }
    }
}
