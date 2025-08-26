<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Color;

class ColorSeeder extends Seeder
{
    public function run(): void
    {
        $colors = [
            ['name' => 'White', 'hex_code' => '#FFFFFF'],
            ['name' => 'Black', 'hex_code' => '#000000'],
            ['name' => 'Silver', 'hex_code' => '#C0C0C0'],
            ['name' => 'Gray', 'hex_code' => '#808080'],
            ['name' => 'Red', 'hex_code' => '#FF0000'],
            ['name' => 'Blue', 'hex_code' => '#0000FF'],
            ['name' => 'Green', 'hex_code' => '#008000'],
            ['name' => 'Yellow', 'hex_code' => '#FFFF00'],
            ['name' => 'Orange', 'hex_code' => '#FFA500'],
            ['name' => 'Purple', 'hex_code' => '#800080'],
            ['name' => 'Brown', 'hex_code' => '#A52A2A'],
            ['name' => 'Beige', 'hex_code' => '#F5F5DC'],
            ['name' => 'Golden', 'hex_code' => '#FFD700'],
            ['name' => 'Metallic', 'hex_code' => '#708090']
        ];
        
        foreach ($colors as $color) {
            Color::create($color);
        }
    }
}
