<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;
use App\Models\CarImage;

class AdminController extends Controller
{
    public function index() {
        return view('admin.admin');
    }
    public function users() {
        return view('admin.users');
    }
    public function cars() {
        $cars = Car::all();
        return view('admin.cars', compact('cars'));
    }
    public function carCreate() {
        return view('admin.car_create');
    }
    public function carStore(Request $request) {
        $data = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|integer|min:1900|max:2155',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'images.*' => 'nullable|image|max:4096',
            'published' => 'nullable|boolean',
        ]);
        $data['published'] = $request->has('published');
        $images = $request->file('images', []);
        if (count($images) > 0) {
            // Первое фото — главное
            $data['image'] = $images[0]->store('cars', 'public');
        }
        $car = Car::create($data);
        // Остальные фото — в car_images
        if (count($images) > 1) {
            foreach (array_slice($images, 1) as $img) {
                $path = $img->store('cars', 'public');
                CarImage::create(['car_id' => $car->id, 'image_path' => $path]);
            }
        }
        return redirect()->route('admin.cars')->with('success', 'Автомобиль добавлен!');
    }
    public function carEdit($id) {
        $car = Car::findOrFail($id);
        return view('admin.car_edit', compact('car'));
    }
    public function carUpdate(Request $request, $id) {
        $car = Car::findOrFail($id);
        $data = $request->validate([
            'brand' => 'required',
            'model' => 'required',
            'year' => 'required|integer|min:1900|max:2155',
            'price' => 'required|numeric',
            'description' => 'nullable',
            'images.*' => 'nullable|image|max:4096',
            'published' => 'nullable|boolean',
        ]);
        $data['published'] = $request->has('published');
        $images = $request->file('images', []);
        if (count($images) > 0) {
            // Первое новое фото — новое главное
            $data['image'] = $images[0]->store('cars', 'public');
        }
        $car->update($data);
        // Остальные новые фото — в car_images
        if (count($images) > 1) {
            foreach (array_slice($images, 1) as $img) {
                $path = $img->store('cars', 'public');
                CarImage::create(['car_id' => $car->id, 'image_path' => $path]);
            }
        }
        return redirect()->route('admin.cars')->with('success', 'Автомобиль обновлен!');
    }
    public function carDelete($id) {
        $car = Car::findOrFail($id);
        $car->delete();
        return redirect()->route('admin.cars')->with('success', 'Автомобиль удален!');
    }
    public function requests() {
        return view('admin.requests');
    }
    public function stats() {
        return view('admin.stats');
    }
    public function settings() {
        return view('admin.settings');
    }
} 