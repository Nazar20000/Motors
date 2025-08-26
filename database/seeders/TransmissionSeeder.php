<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Transmission;

class TransmissionSeeder extends Seeder
{
    public function run(): void
    {
        $transmissions = [
            ['name' => 'Manual', 'slug' => 'manual'],
            ['name' => 'Automatic', 'slug' => 'automatic'],
            ['name' => 'Robot', 'slug' => 'robot'],
            ['name' => 'CVT', 'slug' => 'cvt']
        ];
        
        foreach ($transmissions as $transmission) {
            Transmission::create($transmission);
        }
    }
}
