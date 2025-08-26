<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Transmission;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\File;

class CarSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Get existing data
        $brands = Brand::all();
        $models = CarModel::all();
        $bodyTypes = BodyType::all();
        $colors = Color::all();
        $transmissions = Transmission::all();

        if ($brands->isEmpty() || $models->isEmpty() || $bodyTypes->isEmpty() || $colors->isEmpty() || $transmissions->isEmpty()) {
            $this->command->error('Please run other seeders first: BrandSeeder, CarModelSeeder, BodyTypeSeeder, ColorSeeder, TransmissionSeeder');
            return;
        }

        // List of images for cars (from resurs folder)
        $carImages = [
            'BMW.jpeg',
            'AUDI.jpeg', 
            'MERCEDES.jpeg',
            'PORSHE.jpeg',
            'honda.jpeg',
            'KIA.jpeg',
            'HYUNDAY.jpeg'
        ];

        // Copy images from resurs to storage if they don't exist
        $this->copyImagesToStorage($carImages);

        $cars = [
            [
                'brand_id' => 1, // Toyota
                'car_model_id' => $models->where('brand_id', 1)->first()->id ?? 1,
                'year' => 2020,
                'mileage' => 45000,
                'price' => 25000,
                'color_id' => $colors->first()->id,
                'body_type_id' => $bodyTypes->first()->id,
                'transmission_id' => $transmissions->first()->id,
                'status' => 'available',
                'vin' => '1HGBH41JXMN109186',
                'engine_size' => '2.5L',
                'horsepower' => 203,
                'fuel_type' => 'Gasoline',
                'description' => 'Excellent condition Toyota with low mileage. Well maintained with full service history.',
                'published' => true,
                'image' => 'cars/' . $carImages[0] ?? null,
            ],
            [
                'brand_id' => 2, // BMW
                'car_model_id' => $models->where('brand_id', 2)->first()->id ?? 2,
                'year' => 2019,
                'mileage' => 32000,
                'price' => 35000,
                'color_id' => $colors->first()->id,
                'body_type_id' => $bodyTypes->first()->id,
                'transmission_id' => $transmissions->first()->id,
                'status' => 'available',
                'vin' => 'WBA8A9C50FD123456',
                'engine_size' => '2.0L',
                'horsepower' => 248,
                'fuel_type' => 'Gasoline',
                'description' => 'Luxury BMW in pristine condition. Premium features and excellent performance.',
                'published' => true,
                'image' => 'cars/' . $carImages[1] ?? null,
            ],
            [
                'brand_id' => 1, // Toyota
                'car_model_id' => $models->where('brand_id', 1)->first()->id ?? 1,
                'year' => 2021,
                'mileage' => 18000,
                'price' => 28000,
                'color_id' => $colors->first()->id,
                'body_type_id' => $bodyTypes->first()->id,
                'transmission_id' => $transmissions->first()->id,
                'status' => 'available',
                'vin' => '1HGBH41JXMN109187',
                'engine_size' => '2.0L',
                'horsepower' => 169,
                'fuel_type' => 'Hybrid',
                'description' => 'Recent model Toyota hybrid with excellent fuel economy.',
                'published' => true,
                'image' => 'cars/' . $carImages[2] ?? null,
            ],
            [
                'brand_id' => 2, // BMW
                'car_model_id' => $models->where('brand_id', 2)->first()->id ?? 2,
                'year' => 2020,
                'mileage' => 28000,
                'price' => 42000,
                'color_id' => $colors->first()->id,
                'body_type_id' => $bodyTypes->first()->id,
                'transmission_id' => $transmissions->first()->id,
                'status' => 'available',
                'vin' => 'WBA8A9C50FD123457',
                'engine_size' => '3.0L',
                'horsepower' => 335,
                'fuel_type' => 'Gasoline',
                'description' => 'High-performance BMW with premium features and sport package.',
                'published' => true,
                'image' => 'cars/' . $carImages[3] ?? null,
            ],
            [
                'brand_id' => 1, // Toyota
                'car_model_id' => $models->where('brand_id', 1)->first()->id ?? 1,
                'year' => 2018,
                'mileage' => 65000,
                'price' => 18000,
                'color_id' => $colors->first()->id,
                'body_type_id' => $bodyTypes->first()->id,
                'transmission_id' => $transmissions->first()->id,
                'status' => 'available',
                'vin' => '1HGBH41JXMN109188',
                'engine_size' => '2.5L',
                'horsepower' => 203,
                'fuel_type' => 'Gasoline',
                'description' => 'Reliable Toyota with good value for money. Well maintained.',
                'published' => true,
                'image' => 'cars/' . $carImages[4] ?? null,
            ],
            [
                'brand_id' => 4, // Audi
                'car_model_id' => $models->where('brand_id', 4)->first()->id ?? 4,
                'year' => 2020,
                'mileage' => 25000,
                'price' => 38000,
                'color_id' => $colors->first()->id,
                'body_type_id' => $bodyTypes->first()->id,
                'transmission_id' => $transmissions->first()->id,
                'status' => 'available',
                'vin' => 'WAUZZZ8V4KA123456',
                'engine_size' => '2.0L',
                'horsepower' => 252,
                'fuel_type' => 'Gasoline',
                'description' => 'Premium Audi with quattro all-wheel drive. Excellent condition with premium features.',
                'published' => true,
                'image' => 'cars/' . $carImages[5] ?? null,
            ],
            [
                'brand_id' => 4, // Audi
                'car_model_id' => $models->where('brand_id', 4)->first()->id ?? 4,
                'year' => 2019,
                'mileage' => 35000,
                'price' => 32000,
                'color_id' => $colors->first()->id,
                'body_type_id' => $bodyTypes->first()->id,
                'transmission_id' => $transmissions->first()->id,
                'status' => 'available',
                'vin' => 'WAUZZZ8V4KA123457',
                'engine_size' => '2.0L',
                'horsepower' => 201,
                'fuel_type' => 'Gasoline',
                'description' => 'Well-maintained Audi with great value. Includes premium audio system.',
                'published' => true,
                'image' => 'cars/' . $carImages[6] ?? null,
            ],
        ];

        foreach ($cars as $carData) {
            Car::create($carData);
        }

        $this->command->info('Cars seeded successfully!');
    }

    private function copyImagesToStorage($imageNames)
    {
        $sourceDir = public_path('resurs');
        $targetDir = storage_path('app/public/cars');

        // Create cars directory if it doesn't exist
        if (!File::exists($targetDir)) {
            File::makeDirectory($targetDir, 0755, true);
        }

        foreach ($imageNames as $imageName) {
            $sourcePath = $sourceDir . '/' . $imageName;
            $targetPath = $targetDir . '/' . $imageName;

            if (File::exists($sourcePath)) {
                if (!File::exists($targetPath)) {
                    File::copy($sourcePath, $targetPath);
                    $this->command->info("Copied {$imageName} to storage");
                } else {
                    $this->command->info("{$imageName} already exists in storage");
                }
            } else {
                $this->command->warn("Source image {$imageName} not found in resurs folder");
            }
        }
    }
}
