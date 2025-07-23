<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Car;

class HomeController extends Controller
{
    public function home(){

        return view('home');
    }
    
    public function inventory(){
        $cars = Car::where('published', true)->get();
        return view('inventory', compact('cars'));
    }

    public function detalis(){

        return view('detalis');
    }

    public function car_finder(){

        return view('car_finder');
    }

    public function apply_online(){

        return view('apply_online');
    }

    public function about_us(){

        return view('about_us');
    }

    public function contact_us(){

        return view('contact_us');
    }

    public function admin(){
        return view('admin.admin');
    }

    public function carDetails($id) {
        $car = Car::with('images')->where('published', true)->findOrFail($id);
        return view('detalis', compact('car'));
    }
}
