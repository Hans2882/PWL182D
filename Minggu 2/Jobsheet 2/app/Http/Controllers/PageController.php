<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PageController extends Controller
{
    public function index()
    {
        return 'Selamat Datang';
    }
    public function about()
    {
        return "Nim : 2341720181
        Nama : Nakita Gayuh Cakrawala";
    }
    public function articles($id)
    {
        return 'Halaman artikel dengan id ' . $id;
    }
}
