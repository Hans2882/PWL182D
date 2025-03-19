<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\KategoriModel;
use Illuminate\Http\Request;

class EditController extends Controller
{
    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::find($id);

        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->save();

        return redirect('/kategori');
    }
}
