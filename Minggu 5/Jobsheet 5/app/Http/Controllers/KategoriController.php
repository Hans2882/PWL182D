<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\KategoriModel;
use App\DataTables\KategoriDataTable;

class KategoriController extends Controller
{
    public function index(KategoriDataTable $dataTable)
    {
        return $dataTable->render('kategori.index');
    }
    public function create()
    {
        return view('kategori.create');
    }
    public function store(Request $request)
    {
        KategoriModel::create([
            'kategori_kode' => $request->kodeKategori,
            'kategori_nama' => $request->namaKategori,
        ]);
        return redirect('/kategori');
    }
    public function edit($id)
    {
        $kategori = KategoriModel::find($id);
        return view('kategori.edit', ['kategori' => $kategori]);
    }
    public function update(Request $request, $id)
    {
        $kategori = KategoriModel::find($id);

        if (!$kategori) {
            return redirect('/kategori')->with('error', 'Data kategori tidak ditemukan!');
        }

        $kategori->kategori_nama = $request->kategori_nama;
        $kategori->kategori_kode = $request->kategori_kode;
        $kategori->save();

        return redirect('/kategori')->with('success', 'Kategori berhasil diperbarui!');
    }
    public function delete($id)
    {
        $kategori = KategoriModel::find($id);
        $kategori->delete();

        return redirect('/kategori');
    }
}
