<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarImage;
use App\Models\CarEquipment;
use App\Models\Brand;
use App\Models\CarModel;
use App\Models\ContactRequest;
use Illuminate\Support\Facades\Storage;

class AdminController extends Controller
{
    public function index() {
        return view('admin.admin');
    }
    
    public function users() {
        return view('admin.users');
    }
    
    public function userCreate() {
        return view('admin.users.create');
    }
    
    public function userStore(Request $request) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'role' => 'required|in:admin,user',
        ]);
        
        // Здесь будет логика создания пользователя
        // Пока просто возвращаем успех
        return redirect()->route('admin.users')->with('success', 'User created successfully!');
    }
    
    public function userEdit($id) {
        return view('admin.users.edit', compact('id'));
    }
    
    public function userUpdate(Request $request, $id) {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $id,
            'role' => 'required|in:admin,user',
        ]);
        
        // Здесь будет логика обновления пользователя
        return redirect()->route('admin.users')->with('success', 'User updated successfully!');
    }
    
    public function userDelete($id) {
        // Здесь будет логика удаления пользователя
        return redirect()->route('admin.users')->with('success', 'User deleted successfully!');
    }
    
    public function cars() {
        $cars = Car::with(['brand', 'carModel'])->paginate(20);
        return view('admin.cars', compact('cars'));
    }
    
    public function carCreate() {
        $brands = Brand::where('active', true)->get();
        $models = CarModel::all(); // Load all models
        return view('admin.car_create', compact('brands', 'models'));
    }
    
    public function carStore(Request $request) {
        try {
            $data = $request->validate([
                'brand_id' => 'required|exists:brands,id',
                'car_model_id' => 'required|exists:car_models,id',
                'year' => 'required|integer|min:1900|max:2155',
                'price' => 'required|numeric|min:0',
                'mileage' => 'nullable|integer|min:0',
                'color_id' => 'nullable|exists:colors,id',
                'body_type_id' => 'nullable|exists:body_types,id',
                'transmission_id' => 'nullable|exists:transmissions,id',
                'vin' => 'nullable|string|max:17|unique:cars,vin',
                'engine_size' => 'nullable|string|max:50',
                'horsepower' => 'nullable|integer|min:0',
                'fuel_type' => 'nullable|string|max:50',
                'drivetrain' => 'nullable|string|max:20',
                'doors' => 'nullable|integer|min:2|max:5',
                'interior_color' => 'nullable|string|max:50',
                'carfax_url' => 'nullable|url|max:500',
                'description' => 'nullable|string|max:1000',
                'images' => 'nullable|array',
                'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
                'published' => 'nullable|boolean',
            ]);

            $data['published'] = $request->has('published');
            
            // Create car without image
            $car = Car::create($data);
            
            // Process images separately
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                
                // Check if it's an array
                if (!is_array($images)) {
                    $images = [$images];
                }
                
                // Filter only valid images
                $validImages = [];
                foreach ($images as $index => $image) {
                    try {
                        if ($image && $image->isValid()) {
                            // Check file size (maximum 10MB)
                            if ($image->getSize() > 10 * 1024 * 1024) {
                                \Log::warning("Image too large: " . $image->getClientOriginalName());
                                continue;
                            }
                            
                            // Check MIME type
                            $mimeType = $image->getMimeType();
                            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                            if (!in_array($mimeType, $allowedTypes)) {
                                \Log::warning("Invalid image type: " . $mimeType . " for file: " . $image->getClientOriginalName());
                                continue;
                            }
                            
                            $validImages[] = $image;
                        } else {
                            \Log::warning("Invalid image at index " . $index . ": " . ($image ? $image->getClientOriginalName() : 'null'));
                        }
                    } catch (\Exception $e) {
                        \Log::error("Error processing image at index " . $index . ": " . $e->getMessage());
                    }
                }
                
                if (!empty($validImages)) {
                    try {
                        // Save all images to car_images
                        foreach ($validImages as $image) {
                            $path = $image->store('cars', 'public');
                            CarImage::create(['car_id' => $car->id, 'image_path' => $path]);
                            \Log::info("Image stored: " . $path . " for car ID: " . $car->id);
                        }
                        
                        \Log::info("Successfully uploaded " . count($validImages) . " images for car ID: " . $car->id);
                    } catch (\Exception $e) {
                        \Log::error("Error storing images: " . $e->getMessage());
                        // Don't interrupt car creation if images failed to upload
                    }
                } else {
                    \Log::warning("No valid images found for car ID: " . $car->id);
                }
            }
            
            // Process equipment
            if ($request->has('equipment') || $request->has('custom_equipment')) {
                $equipmentData = [];
                
                // Standard equipment
                if ($request->has('equipment')) {
                    foreach ($request->equipment as $equipmentName) {
                        $equipmentData[] = [
                            'car_id' => $car->id,
                            'name' => $equipmentName,
                            'category' => $this->getEquipmentCategory($equipmentName),
                            'active' => true,
                            'sort_order' => count($equipmentData)
                        ];
                    }
                }
                
                // Custom equipment
                if ($request->has('custom_equipment')) {
                    $customEquipment = $request->custom_equipment;
                    $customCategories = $request->custom_equipment_category;
                    
                    for ($i = 0; $i < count($customEquipment); $i++) {
                        if (!empty($customEquipment[$i])) {
                            $equipmentData[] = [
                                'car_id' => $car->id,
                                'name' => $customEquipment[$i],
                                'category' => $customCategories[$i] ?? 'general',
                                'active' => true,
                                'sort_order' => count($equipmentData)
                            ];
                        }
                    }
                }
                
                // Save equipment
                if (!empty($equipmentData)) {
                    CarEquipment::insert($equipmentData);
                }
            }
            
            return redirect()->route('admin.cars')->with('success', 'Car successfully added!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Car creation error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error creating car: ' . $e->getMessage()])->withInput();
        }
    }
    
    public function carEdit($id) {
        $car = Car::findOrFail($id);
        $brands = Brand::where('active', true)->get();
        $models = CarModel::all(); // Load all models
        return view('admin.car_edit', compact('car', 'brands', 'models'));
    }
    
    public function carUpdate(Request $request, $id) {
        $car = Car::findOrFail($id);
        
        $data = $request->validate([
            'brand_id' => 'required|exists:brands,id',
            'car_model_id' => 'required|exists:car_models,id',
            'year' => 'required|integer|min:1900|max:2155',
            'price' => 'required|numeric|min:0',
            'mileage' => 'nullable|integer|min:0',
            'color_id' => 'nullable|exists:colors,id',
            'body_type_id' => 'nullable|exists:body_types,id',
            'transmission_id' => 'nullable|exists:transmissions,id',
            'vin' => 'nullable|string|max:17|unique:cars,vin,' . $car->id,
            'engine_size' => 'nullable|string|max:50',
            'horsepower' => 'nullable|integer|min:0',
            'fuel_type' => 'nullable|string|max:50',
            'drivetrain' => 'nullable|string|max:20',
            'doors' => 'nullable|integer|min:2|max:5',
            'interior_color' => 'nullable|string|max:50',
            'carfax_url' => 'nullable|url|max:500',
            'description' => 'nullable|string|max:1000',
            'images' => 'nullable|array',
            'images.*' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:10240',
            'published' => 'nullable|boolean',
        ]);

        try {
            $data['published'] = $request->has('published');
            
            // Update car
            $car->update($data);
            
            // Process images separately
            if ($request->hasFile('images')) {
                $images = $request->file('images');
                
                // Check if it's an array
                if (!is_array($images)) {
                    $images = [$images];
                }
                
                // Filter only valid images
                $validImages = [];
                foreach ($images as $index => $image) {
                    try {
                        if ($image && $image->isValid()) {
                            // Check file size (maximum 10MB)
                            if ($image->getSize() > 10 * 1024 * 1024) {
                                \Log::warning("Image too large: " . $image->getClientOriginalName());
                                continue;
                            }
                            
                            // Check MIME type
                            $mimeType = $image->getMimeType();
                            $allowedTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];
                            if (!in_array($mimeType, $allowedTypes)) {
                                \Log::warning("Invalid image type: " . $mimeType . " for file: " . $image->getClientOriginalName());
                                continue;
                            }
                            
                            $validImages[] = $image;
                        } else {
                            \Log::warning("Invalid image at index " . $index . ": " . ($image ? $image->getClientOriginalName() : 'null'));
                        }
                    } catch (\Exception $e) {
                        \Log::error("Error processing image at index " . $index . ": " . $e->getMessage());
                    }
                }
                
                if (!empty($validImages)) {
                    try {
                        // Save all images to car_images
                        foreach ($validImages as $image) {
                            $path = $image->store('cars', 'public');
                            CarImage::create(['car_id' => $car->id, 'image_path' => $path]);
                            \Log::info("Image stored: " . $path . " for car ID: " . $car->id);
                        }
                        
                        \Log::info("Successfully uploaded " . count($validImages) . " images for car ID: " . $car->id);
                    } catch (\Exception $e) {
                        \Log::error("Error storing images: " . $e->getMessage());
                        // Don't interrupt car update if images failed to upload
                    }
                } else {
                    \Log::warning("No valid images found for car ID: " . $car->id);
                }
            }
            
            // Process equipment
            if ($request->has('equipment') || $request->has('custom_equipment')) {
                // Remove old equipment
                $car->equipment()->delete();
                
                $equipmentData = [];
                
                // Standard equipment
                if ($request->has('equipment')) {
                    foreach ($request->equipment as $equipmentName) {
                        $equipmentData[] = [
                            'car_id' => $car->id,
                            'name' => $equipmentName,
                            'category' => $this->getEquipmentCategory($equipmentName),
                            'active' => true,
                            'sort_order' => count($equipmentData)
                        ];
                    }
                }
                
                // Custom equipment
                if ($request->has('custom_equipment')) {
                    $customEquipment = $request->custom_equipment;
                    $customCategories = $request->custom_equipment_category;
                    
                    for ($i = 0; $i < count($customEquipment); $i++) {
                        if (!empty($customEquipment[$i])) {
                            $equipmentData[] = [
                                'car_id' => $car->id,
                                'name' => $customEquipment[$i],
                                'category' => $customCategories[$i] ?? 'general',
                                'active' => true,
                                'sort_order' => count($equipmentData)
                            ];
                        }
                    }
                }
                
                // Save equipment
                if (!empty($equipmentData)) {
                    CarEquipment::insert($equipmentData);
                }
            }
            
            return redirect()->route('admin.cars')->with('success', 'Car successfully updated!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            \Log::error('Car update error: ' . $e->getMessage());
            return back()->withErrors(['error' => 'Error updating car: ' . $e->getMessage()])->withInput();
        }
    }
    
    public function carDelete($id) {
        try {
            $car = Car::findOrFail($id);
            
            // Delete images
            if ($car->image) {
                Storage::disk('public')->delete($car->image);
            }
            
            // Delete additional images
            foreach ($car->images as $image) {
                Storage::disk('public')->delete($image->image_path);
            }
            
            $car->delete();
            
            return redirect()->route('admin.cars')->with('success', 'Car successfully deleted!');
        } catch (\Exception $e) {
            return back()->withErrors(['error' => 'Error deleting car: ' . $e->getMessage()]);
        }
    }
    
    public function requests() {
        $requests = ContactRequest::with('car')->paginate(20);
        return view('admin.requests', compact('requests'));
    }
    
    public function stats() {
        $totalCars = Car::count();
        $availableCars = Car::where('status', 'available')->count();
        $publishedCars = Car::where('published', true)->count();
        $totalBrands = Brand::count();
        
        return view('admin.stats', compact('totalCars', 'availableCars', 'publishedCars', 'totalBrands'));
    }
    
    public function settings() {
        return view('admin.settings');
    }
    
    public function deleteMainImage($id) {
        try {
            $car = Car::findOrFail($id);
            
            if ($car->image) {
                // Delete file from disk
                Storage::disk('public')->delete($car->image);
                
                // Clear image field in database
                $car->update(['image' => null]);
                
                return response()->json(['success' => true, 'message' => 'Main photo successfully deleted']);
            }
            
            return response()->json(['success' => false, 'message' => 'Main photo not found']);
        } catch (\Exception $e) {
            \Log::error('Error deleting main image: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting photo']);
        }
    }
    
    public function deleteImage($imageId) {
        try {
            $image = CarImage::findOrFail($imageId);
            
            // Delete file from disk
            Storage::disk('public')->delete($image->image_path);
            
            // Delete record from database
            $image->delete();
            
            return response()->json(['success' => true, 'message' => 'Photo successfully deleted']);
        } catch (\Exception $e) {
            \Log::error('Error deleting image: ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Error deleting photo']);
        }
    }
    
    private function getEquipmentCategory($equipmentName)
    {
        $safetyEquipment = [
            'BACKUP CAMERA', 'ABS (4-WHEEL)', 'ALARM SYSTEM', 
            'LANE KEEP ASSIST', 'DAYTIME RUNNING LIGHTS'
        ];
        
        $comfortEquipment = [
            'HEATED & VENTILATED SEATS', 'POWER WINDOWS', 'DUAL POWER SEATS',
            'LEATHER', 'POWER STEERING'
        ];
        
        $technologyEquipment = [
            'LED HEADLAMPS', 'LEXUS ENFORM', 'BLUETOOTH WIRELESS',
            'PREMIUM WHEELS 19', 'PREMIUM SOUND', 'NAVIGATION SYSTEM'
        ];
        
        if (in_array($equipmentName, $safetyEquipment)) {
            return 'safety';
        } elseif (in_array($equipmentName, $comfortEquipment)) {
            return 'comfort';
        } elseif (in_array($equipmentName, $technologyEquipment)) {
            return 'technology';
        } else {
            return 'general';
        }
    }
}