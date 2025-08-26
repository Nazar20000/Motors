<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\CarEquipment;

class CarEquipmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $cars = Car::all();
        
        if ($cars->isEmpty()) {
            $this->command->error('No cars found. Please run CarSeeder first.');
            return;
        }

        // Equipment for each car
        $equipmentData = [
            // General
            'AIR CONDITIONING' => 'general',
            'POWER DOOR LOCKS' => 'general',
            'AM/FM STEREO' => 'general',
            'GLASS ROOF' => 'general',
            'PUSH BUTTON START' => 'general',
            'DYNAMIC CRUISE CONTROL' => 'general',
            
            // Safety
            'BACKUP CAMERA' => 'safety',
            'ABS (4-WHEEL)' => 'safety',
            'ALARM SYSTEM' => 'safety',
            'LANE KEEP ASSIST' => 'safety',
            'DAYTIME RUNNING LIGHTS' => 'safety',
            
            // Comfort
            'HEATED & VENTILATED SEATS' => 'comfort',
            'POWER WINDOWS' => 'comfort',
            'DUAL POWER SEATS' => 'comfort',
            'LEATHER' => 'comfort',
            'POWER STEERING' => 'comfort',
            
            // Technology
            'LED HEADLAMPS' => 'technology',
            'LEXUS ENFORM' => 'technology',
            'BLUETOOTH WIRELESS' => 'technology',
            'PREMIUM WHEELS 19' => 'technology',
            'PREMIUM SOUND' => 'technology',
            'NAVIGATION SYSTEM' => 'technology',
        ];

        foreach ($cars as $car) {
            $sortOrder = 0;
            
            foreach ($equipmentData as $equipmentName => $category) {
                CarEquipment::create([
                    'car_id' => $car->id,
                    'name' => $equipmentName,
                    'category' => $category,
                    'active' => true,
                    'sort_order' => $sortOrder++
                ]);
            }
        }

        $this->command->info('Car equipment seeded successfully!');
    }
}
