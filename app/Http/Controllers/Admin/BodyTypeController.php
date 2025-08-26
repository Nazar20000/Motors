<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\BodyType;
use Illuminate\Support\Str;

class BodyTypeController extends Controller
{
    public function index()
    {
        $bodyTypes = BodyType::paginate(20);
        return view('admin.body_types.index', compact('bodyTypes'));
    }

    public function create()
    {
        return view('admin.body_types.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:body_types,name',
            'active' => 'boolean'
        ]);

        BodyType::create([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'active' => $request->has('active')
        ]);

                    return redirect()->route('admin.body-types.index')->with('success', 'Body type successfully added!');
    }

    public function edit(BodyType $bodyType)
    {
        return view('admin.body_types.edit', compact('bodyType'));
    }

    public function update(Request $request, BodyType $bodyType)
    {
        $request->validate([
            'name' => 'required|string|max:255|unique:body_types,name,' . $bodyType->id,
            'active' => 'boolean'
        ]);

        $bodyType->update([
            'name' => $request->name,
            'slug' => Str::slug($request->name),
            'active' => $request->has('active')
        ]);

                    return redirect()->route('admin.body-types.index')->with('success', 'Body type successfully updated!');
    }

    public function destroy(BodyType $bodyType)
    {
        $bodyType->delete();
                    return redirect()->route('admin.body-types.index')->with('success', 'Body type successfully deleted!');
    }
} 