<?php

namespace App\Http\Controllers;

use App\Models\BarangModel;
use App\Models\KategoriModel;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class BarangController extends Controller
{
    public function index()
    {
        $barang = BarangModel::all();
        $breadcrumb = (object) [
            'title' => 'Daftar Barang',
            'list' => ['Home', 'Barang']
        ];

        $page = (object) [
            'title' => 'Daftar Barang yang terdaftar dalam sistem'
        ];


        $activeMenu = 'barang'; // set menu yang sedang aktif

        $kategori = KategoriModel::all();

        return view('barang.index', ['breadcrumb' => $breadcrumb, 'page' => $page, 'kategori' => $kategori, 'activeMenu' => $activeMenu]);
    }

    public function create_ajax()
    {
        $kategori = KategoriModel::select('Kategori_id', 'kategori_nama')->get();
        return view('barang.create_ajax')->with('kategori', $kategori);
    }

    public function store_ajax(Request $request)
    {
        // cek apakah request berupa ajax
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id' => 'required|integer',
                'barang_kode' => 'required|string|min:3|max:10|unique:m_barang,barang_kode',
                'barang_nama' => 'required|string|min:3|max:100',
                'harga_beli' => 'required|numeric|min:0',
                'harga_jual' => 'required|numeric|min:0'
            ];


            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status' => false, // response status, false: error/gagal, true: berhasil
                    'message' => 'Validasi Gagal',
                    'msgField' => $validator->errors() // pesan error validasi
                ]);
            }

            BarangModel::create($request->all());

            return response()->json([
                'status' => true,
                'message' => 'Data barang berhasil disimpan'
            ]);
        }

        redirect('/');
    }

    public function edit_ajax(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::select('Kategori_id', 'kategori_nama')->get();
        return view('barang.edit_ajax', ['barang' => $barang, 'kategori' => $kategori]);
    }

    public function update_ajax(Request $request, $id)
    {
        if ($request->ajax() || $request->wantsJson()) {
            $rules = [
                'kategori_id'  => 'required|integer',
                'barang_kode'  => 'required|string|unique:m_barang,barang_kode,' . $id . ',barang_id',
                'barang_nama'  => 'required|string|max:100',
                'harga_beli'   => 'required|numeric|min:0',
                'harga_jual'   => 'required|numeric|min:0',
            ];

            $validator = Validator::make($request->all(), $rules);

            if ($validator->fails()) {
                return response()->json([
                    'status'   => false,
                    'message'  => 'Validasi gagal.',
                    'msgField' => $validator->errors(),
                ]);
            }

            $barang = BarangModel::find($id);
            if ($barang) {
                $barang->update($request->all());

                return response()->json([
                    'status'  => true,
                    'message' => 'Data barang berhasil diupdate.',
                ]);
            }

            return response()->json([
                'status'  => false,
                'message' => 'Data tidak ditemukan.',
            ]);
        }

        return redirect('/');
    }

    public function confirm_ajax(string $id)
    {
        $barang = BarangModel::find($id);

        return view('barang.confirm_ajax', ['barang' => $barang]);
    }

    public function delete_ajax(Request $request, $id)
    {
        // cek apakah request dari ajax
        if ($request->ajax() || $request->wantsJson()) {
            try {
                $barang = BarangModel::find($id);
                if ($barang) {
                    $barang->delete();
                    return response()->json([
                        'status' => true,
                        'message' => 'Data berhasil dihapus'
                    ]);
                } else {
                    return response()->json([
                        'status' => false,
                        'message' => 'Data tidak ditemukan'
                    ]);
                }
            } catch (\Illuminate\Database\QueryException $e) {
                return response()->json([
                    'status' => false,
                    'message' => 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini'
                ]);
            }
        }

        return redirect('/');
    }

    // Ambil data user dalam bentuk json untuk datatables
    public function list(Request $request)
    {
        $barang = BarangModel::select('barang_id', 'barang_kode', 'barang_nama', 'harga_jual', 'harga_beli', 'kategori_id')

            ->with('kategori'); // relasi ke tabel kategori

        // Filter data berdasarkan Kategori_id
        if ($request->Kategori_id) {
            $barang->where('kategori_id', $request->Kategori_id);
        }

        return DataTables::of($barang)
            ->addIndexColumn()
            ->addColumn('aksi', function ($barang) {
                // return '<a href="' . url('/barang/' . $barang->barang_id) . '" class="btn btn-info btn-sm">Detail</a> ' .
                //     '<a href="' . url('/barang/' . $barang->barang_id . '/edit') . '" class="btn btn-warning btn-sm">Edit</a> ' .
                //     '<form class="d-inline-block" method="POST" action="' . url('/barang/' . $barang->barang_id) . '">' .
                //     csrf_field() . method_field('DELETE') .
                //     '<button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Apakah Anda yakin menghapus data ini?\');">Hapus</button></form>';
                
                $btn = '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/show_ajax') . '\')" class="btn btn-info btn-sm">Detail</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/edit_ajax') . '\')" class="btn btn-warning btn-sm">Edit</button> ';
                $btn .= '<button onclick="modalAction(\'' . url('/barang/' . $barang->barang_id .
                    '/delete_ajax') . '\')" class="btn btn-danger btn-sm">Hapus</button> ';
                return $btn;
            })
            ->rawColumns(['aksi'])
            ->make(true);
    }

    // Menampilkan halaman form tambah user
    public function create()
    {
        $breadcrumb = (object) [
            'title' => 'Tambah Barang',
            'list' => ['Home', 'Barang', 'Tambah']
        ];

        $page = (object) [
            'title' => 'Tambah Barang baru'
        ];
        $kategori = KategoriModel::all();
        $activeMenu = 'barang'; // set menu yang sedang aktif

        return view('barang.create', ['breadcrumb' => $breadcrumb, 'page' => $page, 'activeMenu' => $activeMenu, 'kategori' => $kategori]);
    }

    // Menyimpan data user baru
    public function store(Request $request)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_kode' => 'required|string|max:10|unique:m_barang,barang_kode',
            'barang_nama' => 'required|string|max:100',
            'harga_jual'   => 'required|numeric',
            'harga_beli'   => 'required|numeric'
        ]);

        barangModel::create([
            'kategori_id' => $request->Kategori_id,
            'barang_kode'     => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_jual'   => $request->harga_jual,
            'harga_beli'   => $request->harga_beli,
        ]);

        return redirect('/barang')->with('success', 'Data berhasil disimpan');
    }
    // Menampilkan detail user
    public function show(string $id)
    {
        // Gunakan with('kategori') agar bisa menampilkan info kategori di detail
        $barang = BarangModel::with('kategori')->find($id);

        $breadcrumb = (object) [
            'title' => 'Detail Barang',
            'list'  => ['Home', 'Barang', 'Detail']
        ];

        $page = (object) [
            'title' => 'Detail Barang'
        ];

        $activeMenu = 'barang'; // set menu yang sedang aktif

        return view('barang.show', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'barang' => $barang,
            'activeMenu' => $activeMenu
        ]);
    }
    // Menampilkan halaman form edit user
    public function edit(string $id)
    {
        $barang = BarangModel::find($id);
        $kategori = KategoriModel::all();

        $breadcrumb = (object) [
            'title' => 'Edit Barang',
            'list'  => ['Home', 'Barang', 'Edit']
        ];

        $page = (object) [
            'title' => 'Edit Barang'
        ];

        $activeMenu = 'barang'; // set menu yang sedang aktif

        return view('barang.edit', [
            'breadcrumb' => $breadcrumb,
            'page'       => $page,
            'barang'      => $barang,
            'kategori' => $kategori,
            'activeMenu' => $activeMenu
        ]);
    }

    // Menyimpan perubahan data user
    public function update(Request $request, string $id)
    {
        $request->validate([
            'kategori_id' => 'required|integer',
            'barang_kode'  => 'required|string|max:10|unique:m_barang,barang_kode,' . $id . ',barang_id',
            'barang_nama' => 'required|string|max:100',
            'harga_jual'   => 'required|numeric',
            'harga_beli'   => 'required|numeric'
        ]);

        barangModel::find($id)->update([
            'kategori_id' => $request->Kategori_id,
            'barang_kode'     => $request->barang_kode,
            'barang_nama' => $request->barang_nama,
            'harga_jual'   => $request->harga_jual,
            'harga_beli'   => $request->harga_beli
        ]);

        return redirect('/barang')->with('success', 'Data Barang berhasil diubah');
    }
    // Menghapus data user
    public function destroy(string $id)
    {
        $check = barangModel::find($id);
        if (!$check) {  // untuk mengecek apakah data user dengan id yang dimaksud ada atau tidak
            return redirect('/barang')->with('error', 'Data Barang tidak ditemukan');
        }

        try {
            barangModel::destroy($id);  // Hapus data level

            return redirect('/barang')->with('success', 'Data berhasil dihapus');
        } catch (\Illuminate\Database\QueryException $e) {

            // Jika terjadi error ketika menghapus data, redirect kembali ke halaman dengan membawa pesan error
            return redirect('/barang')->with('error', 'Data gagal dihapus karena masih terdapat tabel lain yang terkait dengan data ini');
        }
    }
}
