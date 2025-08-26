<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Brand;
use Illuminate\Support\Str;

class BrandController extends Controller
{
    public function index()
    {
        $brands = Brand::paginate(20);
        return view('admin.brands.index', compact('brands'));
    }

    public function create()
    {
        return view('admin.brands.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name',
            'active' => 'boolean'
        ]);

        Brand::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'active' => $request->has('active')
        ]);

                    return redirect()->route('admin.brands.index')->with('success', 'Brand successfully added!');
    }

    public function edit(Brand $brand)
    {
        return view('admin.brands.edit', compact('brand'));
    }

    public function update(Request $request, Brand $brand)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:brands,name,' . $brand->id,
            'active' => 'boolean'
        ]);

        $brand->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'active' => $request->has('active')
        ]);

                    return redirect()->route('admin.brands.index')->with('success', 'Brand successfully updated!');
    }

    public function destroy(Brand $brand)
    {
        $brand->delete();
                    return redirect()->route('admin.brands.index')->with('success', 'Brand successfully deleted!');
    }
} 