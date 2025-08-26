<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CarModel;
use App\Models\Brand;
use Illuminate\Support\Str;

class CarModelController extends Controller
{
    public function index()
    {
        $models = CarModel::with('brand')->orderBy('name')->paginate(20);
        return view('admin.car_models.index', compact('models'));
    }

    public function create()
    {
        $brands = Brand::where('active', true)->orderBy('name')->get();
        return view('admin.car_models.create', compact('brands'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'active' => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['active'] = $request->has('active');
        CarModel::create($data);
                    return redirect()->route('admin.car-models.index')->with('success', 'Model successfully added!');
    }

    public function edit(CarModel $carModel)
    {
        $brands = Brand::where('active', true)->orderBy('name')->get();
        return view('admin.car_models.edit', compact('carModel', 'brands'));
    }

    public function update(Request $request, CarModel $carModel)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'brand_id' => 'required|exists:brands,id',
            'active' => 'boolean',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $data['active'] = $request->has('active');
        $carModel->update($data);
                    return redirect()->route('admin.car-models.index')->with('success', 'Model successfully updated!');
    }

    public function destroy(CarModel $carModel)
    {
        $carModel->delete();
                    return redirect()->route('admin.car-models.index')->with('success', 'Model successfully deleted!');
    }
} 