<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function home(){

        return view('home');
    }
    
    public function inventory(){

        return view('inventory');
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
}
