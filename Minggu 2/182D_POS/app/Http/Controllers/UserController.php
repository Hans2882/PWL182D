<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function show($id, $name)
    {
        return view('user', compact('id', 'name'));
    }
}
