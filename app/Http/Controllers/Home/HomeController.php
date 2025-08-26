<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\BodyType;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Cache;
use Illuminate\Validation\ValidationException;

class HomeController extends Controller
{
    public function home(){
        try {
            // Cache data for better performance
            $brands = Cache::remember('brands_active', 3600, function () {
                return Brand::where('active', true)->orderBy('name')->get();
            });
            
            $bodyTypes = Cache::remember('body_types_active', 3600, function () {
                return BodyType::where('active', true)->orderBy('name')->get();
            });
            
            // Get all active car models for the search form
            $carModels = Cache::remember('car_models_active', 3600, function () {
                return CarModel::where('active', true)->orderBy('name')->get();
            });
            
            // Get published cars for featured vehicles section
            $featuredCars = Car::with(['brand', 'carModel', 'bodyType', 'color', 'transmission', 'images'])
                              ->where('published', true)
                              ->orderBy('created_at', 'desc')
                              ->limit(12)
                              ->get();
            
            // Generate years from current to 1990
            $currentYear = date('Y');
            $years = [];
            for ($year = $currentYear; $year >= 1990; $year--) {
                $years[] = $year;
            }
            
            return view('home', compact('brands', 'bodyTypes', 'years', 'featuredCars', 'carModels'));
        } catch (\Exception $e) {
            Log::error('Error in home method: ' . $e->getMessage());
            return view('home')->with('error', 'An error occurred while loading data');
        }
    }
    
    public function inventory(Request $request){
        try {
            // Validate input data
            $validated = $request->validate([
                'brand_id' => 'nullable|integer|exists:brands,id',
                'model_id' => 'nullable|integer|exists:car_models,id',
                'body_type_id' => 'nullable|integer|exists:body_types,id',
                'year_from' => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
                'year_to' => 'nullable|integer|min:1990|max:' . (date('Y') + 1),
                'price_min' => 'nullable|numeric|min:0',
                'price_max' => 'nullable|numeric|min:0',
                'page' => 'nullable|integer|min:1'
            ]);
            
            $query = Car::with(['brand', 'carModel', 'bodyType', 'color', 'transmission'])
                       ->where('published', true);
            
            // Apply filters with SQL injection protection
            if ($request->filled('brand_id')) {
                $query->where('brand_id', $validated['brand_id']);
            }
            
            if ($request->filled('model_id')) {
                $query->where('car_model_id', $validated['model_id']);
            }
            
            if ($request->filled('body_type_id')) {
                $query->where('body_type_id', $validated['body_type_id']);
            }
            
            if ($request->filled('year_from')) {
                $query->where('year', '>=', $validated['year_from']);
            }
            
            if ($request->filled('year_to')) {
                $query->where('year', '<=', $validated['year_to']);
            }
            
            if ($request->filled('price_min')) {
                $query->where('price', '>=', $validated['price_min']);
            }
            
            if ($request->filled('price_max')) {
                $query->where('price', '<=', $validated['price_max']);
            }
            
            // Check filter logic
            if ($request->filled('year_from') && $request->filled('year_to')) {
                if ($validated['year_from'] > $validated['year_to']) {
                    throw ValidationException::withMessages([
                        'year_from' => 'Year "from" cannot be greater than year "to"'
                    ]);
                }
            }
            
            if ($request->filled('price_min') && $request->filled('price_max')) {
                if ($validated['price_min'] > $validated['price_max']) {
                    throw ValidationException::withMessages([
                        'price_min' => 'Price "from" cannot be greater than price "to"'
                    ]);
                }
            }
            
            $cars = $query->paginate(12);
            
            // Get data for filters (cached)
            $brands = Cache::remember('brands_active', 3600, function () {
                return Brand::where('active', true)->orderBy('name')->get();
            });
            
            $bodyTypes = Cache::remember('body_types_active', 3600, function () {
                return BodyType::where('active', true)->orderBy('name')->get();
            });
            
            // Get filter parameters from URL
            $filters = [
                'year_from' => $request->get('year_from'),
                'year_to' => $request->get('year_to'),
                'brand_id' => $request->get('brand_id'),
                'model_id' => $request->get('model_id'),
                'body_type_id' => $request->get('body_type_id'),
                'price_min' => $request->get('price_min'),
                'price_max' => $request->get('price_max'),
            ];
            
            return view('inventory', compact('cars', 'filters', 'brands', 'bodyTypes'));
        } catch (ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Error in inventory method: ' . $e->getMessage());
            return view('inventory')->with('error', 'An error occurred while loading inventory');
        }
    }

    public function detalis($id = null){
        try {
            // Validate ID
            if ($id && !is_numeric($id)) {
                abort(404, 'Invalid car ID');
            }
            
            if ($id) {
                $car = Car::with(['images', 'brand', 'carModel', 'bodyType', 'color', 'transmission'])
                          ->where('published', true)
                          ->findOrFail($id);
            } else {
                // If ID is not passed, show first available car
                $car = Car::with(['images', 'brand', 'carModel', 'bodyType', 'color', 'transmission'])
                          ->where('published', true)
                          ->first();
                          
                if (!$car) {
                    abort(404, 'No cars found');
                }
            }
            
            return view('detalis', compact('car'));
        } catch (\Illuminate\Database\Eloquent\ModelNotFoundException $e) {
            abort(404, 'Car not found');
        } catch (\Exception $e) {
            Log::error('Error in detalis method: ' . $e->getMessage());
            return view('detalis')->with('error', 'An error occurred while loading car details');
        }
    }

    public function car_finder(){
        try {
            return view('car_finder');
        } catch (\Exception $e) {
            Log::error('Error in car_finder method: ' . $e->getMessage());
            return view('car_finder')->with('error', 'An error occurred while loading search page');
        }
    }

    public function apply_online($car_id = null){
        try {
            $car = null;
            
            if ($car_id) {
                $car = Car::with(['brand', 'carModel', 'bodyType', 'color', 'transmission', 'images'])
                          ->where('published', true)
                          ->find($car_id);
            }
            
            return view('apply_online', compact('car'));
        } catch (\Exception $e) {
            Log::error('Error in apply_online method: ' . $e->getMessage());
            return view('apply_online')->with('error', 'An error occurred while loading application form');
        }
    }

    public function about_us(){
        try {
            return view('about_us');
        } catch (\Exception $e) {
            Log::error('Error in about_us method: ' . $e->getMessage());
            return view('about_us')->with('error', 'An error occurred while loading about us page');
        }
    }

    public function contact_us(){
        try {
            return view('contact_us');
        } catch (\Exception $e) {
            Log::error('Error in contact_us method: ' . $e->getMessage());
            return view('contact_us')->with('error', 'An error occurred while loading contacts');
        }
    }
    
    public function privacy_policy(){
        try {
            return view('privacy_policy');
        } catch (\Exception $e) {
            Log::error('Error in privacy_policy method: ' . $e->getMessage());
            return view('privacy_policy')->with('error', 'An error occurred while loading privacy policy');
        }
    }

    public function admin(){
        try {
            return view('admin.admin');
        } catch (\Exception $e) {
            Log::error('Error in admin method: ' . $e->getMessage());
            return view('admin.admin')->with('error', 'An error occurred while loading admin panel');
        }
    }
}
