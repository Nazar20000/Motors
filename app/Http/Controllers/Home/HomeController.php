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
}
