<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\BodyType;
use App\Models\Color;
use App\Models\Transmission;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;

class CarTest extends TestCase
{
    use RefreshDatabase, WithFaker;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Create test data
        $this->brand = Brand::factory()->create(['active' => true]);
        $this->carModel = CarModel::factory()->create(['brand_id' => $this->brand->id]);
        $this->bodyType = BodyType::factory()->create(['active' => true]);
        $this->color = Color::factory()->create();
        $this->transmission = Transmission::factory()->create();
    }

    /** @test */
    public function it_can_display_home_page()
    {
        $response = $this->get('/');
        
        $response->assertStatus(200);
        $response->assertViewIs('home');
        $response->assertViewHas('brands');
        $response->assertViewHas('bodyTypes');
        $response->assertViewHas('years');
    }

    /** @test */
    public function it_can_display_inventory_page()
    {
        $car = Car::factory()->create([
            'brand_id' => $this->brand->id,
            'car_model_id' => $this->carModel->id,
            'body_type_id' => $this->bodyType->id,
            'color_id' => $this->color->id,
            'transmission_id' => $this->transmission->id,
            'published' => true
        ]);

        $response = $this->get('/inventory');
        
        $response->assertStatus(200);
        $response->assertViewIs('inventory');
        $response->assertViewHas('cars');
        $response->assertViewHas('filters');
        $response->assertViewHas('brands');
        $response->assertViewHas('bodyTypes');
    }

    /** @test */
    public function it_can_filter_cars_by_brand()
    {
        $car1 = Car::factory()->create([
            'brand_id' => $this->brand->id,
            'published' => true
        ]);
        
        $brand2 = Brand::factory()->create(['active' => true]);
        $car2 = Car::factory()->create([
            'brand_id' => $brand2->id,
            'published' => true
        ]);

        $response = $this->get('/inventory?brand_id=' . $this->brand->id);
        
        $response->assertStatus(200);
        $response->assertViewHas('cars');
        
        $cars = $response->viewData('cars');
        $this->assertCount(1, $cars);
        $this->assertEquals($car1->id, $cars->first()->id);
    }

    /** @test */
    public function it_can_filter_cars_by_price_range()
    {
        $car1 = Car::factory()->create([
            'price' => 10000,
            'published' => true
        ]);
        
        $car2 = Car::factory()->create([
            'price' => 50000,
            'published' => true
        ]);

        $response = $this->get('/inventory?price_min=15000&price_max=60000');
        
        $response->assertStatus(200);
        
        $cars = $response->viewData('cars');
        $this->assertCount(1, $cars);
        $this->assertEquals($car2->id, $cars->first()->id);
    }

    /** @test */
    public function it_can_display_car_details()
    {
        $car = Car::factory()->create([
            'brand_id' => $this->brand->id,
            'car_model_id' => $this->carModel->id,
            'body_type_id' => $this->bodyType->id,
            'color_id' => $this->color->id,
            'transmission_id' => $this->transmission->id,
            'published' => true
        ]);

        $response = $this->get("/car/{$car->id}");
        
        $response->assertStatus(200);
        $response->assertViewIs('detalis');
        $response->assertViewHas('car');
        
        $responseCar = $response->viewData('car');
        $this->assertEquals($car->id, $responseCar->id);
    }

    /** @test */
    public function it_returns_404_for_non_existent_car()
    {
        $response = $this->get('/car/99999');
        
        $response->assertStatus(404);
    }

    /** @test */
    public function it_validates_filter_parameters()
    {
        $response = $this->get('/inventory?year_from=1800&price_min=-100');
        
        $response->assertStatus(302); // Redirect with validation errors
    }

    /** @test */
    public function it_can_display_about_page()
    {
        $response = $this->get('/about_us');
        
        $response->assertStatus(200);
        $response->assertViewIs('about_us');
    }

    /** @test */
    public function it_can_display_contact_page()
    {
        $response = $this->get('/contact_us');
        
        $response->assertStatus(200);
        $response->assertViewIs('contact_us');
    }

    /** @test */
    public function it_can_display_apply_online_page()
    {
        $response = $this->get('/apply_online');
        
        $response->assertStatus(200);
        $response->assertViewIs('apply_online');
    }

    /** @test */
    public function it_can_display_car_finder_page()
    {
        $response = $this->get('/car_finder');
        
        $response->assertStatus(200);
        $response->assertViewIs('car_finder');
    }

    /** @test */
    public function it_handles_pagination_correctly()
    {
        // Create more cars than fit on one page
        Car::factory()->count(15)->create(['published' => true]);

        $response = $this->get('/inventory');
        
        $response->assertStatus(200);
        
        $cars = $response->viewData('cars');
        $this->assertCount(12, $cars); // Default 12 per page
        $this->assertTrue($cars->hasMorePages());
    }

    /** @test */
    public function it_only_shows_published_cars()
    {
        $publishedCar = Car::factory()->create(['published' => true]);
        $unpublishedCar = Car::factory()->create(['published' => false]);

        $response = $this->get('/inventory');
        
        $response->assertStatus(200);
        
        $cars = $response->viewData('cars');
        $this->assertCount(1, $cars);
        $this->assertEquals($publishedCar->id, $cars->first()->id);
    }
} 