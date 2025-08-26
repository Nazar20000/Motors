<?php

namespace Tests\Unit;

use App\Models\Car;
use PHPUnit\Framework\TestCase;

class CarTest extends TestCase
{
    public function test_car_model_fields()
    {
        $car = new Car([
            'brand_id' => 1,
            'car_model_id' => 1,
            'transmission_id' => 1,
            'body_type_id' => 1,
            'color_id' => 1,
            'year' => 2020,
            'price' => 10000,
        ]);
        $this->assertEquals(2020, $car->year);
        $this->assertEquals(10000, $car->price);
    }
} 