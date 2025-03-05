<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function foodBeverage()
    {
        return view('kategori.foodbeverage');
    }

    public function beautyHealth()
    {
        return view('kategori.beautyhealth');
    }

    public function homeCare()
    {
        return view('kategori.homecare');
    }

    public function babyKid()
    {
        return view('kategori.babykid');
    }
}
