<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ArticleController extends Controller
{
    public function articles($id)
    {
        return 'Halaman artikel dengan id ' . $id;
    }
}
