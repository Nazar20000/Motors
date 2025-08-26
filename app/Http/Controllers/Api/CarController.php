<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\BodyType;

class CarController extends Controller
{
    public function index(Request $request)
    {
        $query = Car::with(['brand', 'carModel', 'color', 'bodyType', 'transmission'])
            ->where('published', true);

                    // Filter by brand
        if ($request->has('brand_id') && $request->brand_id) {
            $query->where('brand_id', $request->brand_id);
        }

                    // Filter by model
        if ($request->has('model_id') && $request->model_id) {
            $query->where('car_model_id', $request->model_id);
        }

                    // Filter by body type
        if ($request->has('body_type_id') && $request->body_type_id) {
            $query->where('body_type_id', $request->body_type_id);
        }

                    // Filter by year
        if ($request->has('year_min') && $request->year_min) {
            $query->where('year', '>=', $request->year_min);
        }
        if ($request->has('year_max') && $request->year_max) {
            $query->where('year', '<=', $request->year_max);
        }

                    // Filter by price
        if ($request->has('price_min') && $request->price_min) {
            $query->where('price', '>=', $request->price_min);
        }
        if ($request->has('price_max') && $request->price_max) {
            $query->where('price', '<=', $request->price_max);
        }

                    // Filter by mileage
        if ($request->has('mileage_min') && $request->mileage_min) {
            $query->where('mileage', '>=', $request->mileage_min);
        }
        if ($request->has('mileage_max') && $request->mileage_max) {
            $query->where('mileage', '<=', $request->mileage_max);
        }

                    // Sorting
        $sortBy = $request->get('sort_by', 'created_at');
        $sortOrder = $request->get('sort_order', 'desc');
        $query->orderBy($sortBy, $sortOrder);

                    // Pagination
        $perPage = $request->get('per_page', 12);
        $cars = $query->paginate($perPage);

        return response()->json([
            'success' => true,
            'data' => $cars->items(),
            'pagination' => [
                'current_page' => $cars->currentPage(),
                'last_page' => $cars->lastPage(),
                'per_page' => $cars->perPage(),
                'total' => $cars->total(),
            ]
        ]);
    }

    public function show($id)
    {
        $car = Car::with(['brand', 'carModel', 'color', 'bodyType', 'transmission', 'images'])
            ->where('published', true)
            ->findOrFail($id);

        return response()->json([
            'success' => true,
            'data' => $car
        ]);
    }

    public function brands()
    {
        $brands = Brand::where('active', true)->orderBy('name')->get(['id', 'name']);
        return response()->json([
            'success' => true,
            'data' => $brands
        ]);
    }

    public function models(Request $request)
    {
        \Log::info('🔍 API Models called with brand_id: ' . $request->get('brand_id'));
        
        $query = CarModel::where('active', true);
        
        if ($request->has('brand_id') && $request->brand_id) {
            \Log::info('🔍 Filtering by brand_id: ' . $request->brand_id);
            $query->where('brand_id', $request->brand_id);
        }
        
        $models = $query->orderBy('name')->get(['id', 'name', 'brand_id']);
        
        \Log::info('✅ Models found: ' . $models->count());
        \Log::info('📝 Models data: ' . $models->toJson());
        
        return response()->json([
            'success' => true,
            'data' => $models
        ]);
    }

    public function bodyTypes()
    {
        $bodyTypes = BodyType::where('active', true)->orderBy('name')->get(['id', 'name']);
        return response()->json([
            'success' => true,
            'data' => $bodyTypes
        ]);
    }
} 