<?php

namespace App\Services;

use App\Models\Car;
use App\Models\Brand;
use App\Models\BodyType;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Pagination\LengthAwarePaginator;

class CarService
{
    /**
     * Get filtered cars
     */
    public function getFilteredCars(array $filters, int $perPage = 12): LengthAwarePaginator
    {
        try {
            $query = Car::with(['brand', 'carModel', 'bodyType', 'color', 'transmission'])
                       ->where('published', true);
            
            // Apply filters
            $this->applyFilters($query, $filters);
            
            return $query->paginate($perPage);
        } catch (\Exception $e) {
            Log::error('Error in getFilteredCars: ' . $e->getMessage());
            throw $e;
        }
    }
    
    /**
     * Apply filters to query
     */
    private function applyFilters($query, array $filters): void
    {
        if (!empty($filters['brand_id'])) {
            $query->where('brand_id', $filters['brand_id']);
        }
        
        if (!empty($filters['model_id'])) {
            $query->where('car_model_id', $filters['model_id']);
        }
        
        if (!empty($filters['body_type_id'])) {
            $query->where('body_type_id', $filters['body_type_id']);
        }
        
        if (!empty($filters['year_from'])) {
            $query->where('year', '>=', $filters['year_from']);
        }
        
        if (!empty($filters['year_to'])) {
            $query->where('year', '<=', $filters['year_to']);
        }
        
        if (!empty($filters['price_min'])) {
            $query->where('price', '>=', $filters['price_min']);
        }
        
        if (!empty($filters['price_max'])) {
            $query->where('price', '<=', $filters['price_max']);
        }
    }
    
    /**
     * Get car by ID with full data
     */
    public function getCarById(int $id): ?Car
    {
        try {
            return Car::with(['images', 'brand', 'carModel', 'bodyType', 'color', 'transmission'])
                     ->where('published', true)
                     ->find($id);
        } catch (\Exception $e) {
            Log::error('Error in getCarById: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get first available car
     */
    public function getFirstAvailableCar(): ?Car
    {
        try {
            return Car::with(['images', 'brand', 'carModel', 'bodyType', 'color', 'transmission'])
                     ->where('published', true)
                     ->first();
        } catch (\Exception $e) {
            Log::error('Error in getFirstAvailableCar: ' . $e->getMessage());
            return null;
        }
    }
    
    /**
     * Get cached brands
     */
    public function getActiveBrands()
    {
        return Cache::remember('brands_active', 3600, function () {
            return Brand::where('active', true)->orderBy('name')->get();
        });
    }
    
    /**
     * Get cached body types
     */
    public function getActiveBodyTypes()
    {
        return Cache::remember('body_types_active', 3600, function () {
            return BodyType::where('active', true)->orderBy('name')->get();
        });
    }
    
    /**
     * Get car statistics
     */
    public function getCarStatistics(): array
    {
        try {
            return Cache::remember('car_statistics', 1800, function () {
                return [
                    'total' => Car::where('published', true)->count(),
                    'available' => Car::where('published', true)->where('status', 'available')->count(),
                    'sold' => Car::where('published', true)->where('status', 'sold')->count(),
                    'reserved' => Car::where('published', true)->where('status', 'reserved')->count(),
                    'avg_price' => Car::where('published', true)->avg('price'),
                    'min_price' => Car::where('published', true)->min('price'),
                    'max_price' => Car::where('published', true)->max('price'),
                ];
            });
        } catch (\Exception $e) {
            Log::error('Error in getCarStatistics: ' . $e->getMessage());
            return [];
        }
    }
    
    /**
     * Clear cache
     */
    public function clearCache(): void
    {
        Cache::forget('brands_active');
        Cache::forget('body_types_active');
        Cache::forget('car_statistics');
    }
} 