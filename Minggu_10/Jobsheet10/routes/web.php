<?php

use App\Http\Controllers\KategoriController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\LevelController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BarangController;
use App\Http\Controllers\WelcomeController;
use App\Models\SupplierModel;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Models\KategoriModel;

// Route::get('/', function () {
//     return view('welcome');
// });

Route::pattern('id', '[0-9]+'); // artinya ketika ada parameter {id}, maka harus berupa angka

Route::get('login', [AuthController::class, 'login'])->name('login');
Route::post('login', [AuthController::class, 'postlogin']);
Route::get('logout', [AuthController::class, 'logout'])->middleware('auth')->name('logout');

Route::get('register', [AuthController::class, 'register'])->name('register');
Route::post('register', [AuthController::class, 'postregister']);

Route::middleware(['auth'])->group(function () { // artinya semua route di dalam group harus login dulu
    // masukkan semua route yang perlu di autentikasi di sini 

    Route::get('/', [WelcomeController::class, 'index']);
    Route::middleware(['authorize:ADM'])->group(function () {
        Route::group(['prefix' => 'user'], function () {
            Route::get('/', [UserController::class, 'index']); // menampilkan halaman awal user
            Route::post('/list', [UserController::class, 'list']); // menampilkan data user dalam bentuk json untuk datatables
            Route::get('/create', [UserController::class, 'create']); // menampilkan halaman form tambah user
            Route::post('/', [UserController::class, 'store']); // menyimpan data user baru
            Route::get('/create_ajax', [UserController::class, 'create_ajax']); // m
            Route::post('/ajax', [UserController::class, 'store_ajax']); // menampilkan
            Route::get('/{id}', [UserController::class, 'show']); // menampilkan detail user
            Route::get('/{id}/edit', [UserController::class, 'edit']); // menampilkan halaman form edit user
            Route::put('/{id}', [UserController::class, 'update']); // menyimpan perubahan data user
            Route::get('/{id}/edit_ajax', [UserController::class, 'edit_ajax']);    // menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [UserController::class, 'update_ajax']); // mengimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [UserController::class, 'confirm_ajax']); // Untuk tampilan confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [UserController::class, 'delete_ajax']); // untuk hapus data user ajax
            Route::delete('/{id}', [UserController::class, 'destroy']); // menghapus data user
            Route::get('/import', [UserController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [UserController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [UserController::class, 'export_excel']); // export excel
            Route::get('/export_pdf', [UserController::class, 'export_pdf']); // export pdf
        });
    });

        Route::group(['prefix' => 'user'], function () {
            Route::get('/profile', [UserController::class, 'profile']);
            Route::get('/profile_ajax', [UserController::class, 'profile_ajax']);
            Route::post('/profile_update', [UserController::class, 'profile_update']);
        });

    //level
    // Route::group(['prefix' => 'level'], function () {
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::get('/level', [LevelController::class, 'index']);
        Route::post('/level/list', [LevelController::class, 'list']);
        Route::get('/level/create', [LevelController::class, 'create']);
        Route::post('/level', [LevelController::class, 'store']);
        Route::get('/level/create_ajax', [LevelController::class, 'create_ajax']);
        Route::post('/level/ajax', [LevelController::class, 'store_ajax']);
        Route::get('/level/{id}', [LevelController::class, 'show']);
        Route::get('/level/{id}/edit', [LevelController::class, 'edit']);
        Route::put('/level/{id}', [LevelController::class, 'update']);
        Route::get('/level/{id}/edit_ajax', [LevelController::class, 'edit_ajax']);    // menampilkan halaman form edit user ajax
        Route::put('/level/{id}/update_ajax', [LevelController::class, 'update_ajax']); // mengimpan perubahan data user ajax
        Route::get('/level/{id}/delete_ajax', [LevelController::class, 'confirm_ajax']); // Untuk tampilan confirm delete user ajax
        Route::delete('/level/{id}/delete_ajax', [LevelController::class, 'delete_ajax']); // untuk hapus data user ajax 
        Route::delete('/level/{id}', [LevelController::class, 'destroy']);
        Route::get('/level/import', [LevelController::class, 'import']); // ajax form upload excel
        Route::post('/level/import_ajax', [LevelController::class, 'import_ajax']); // ajax import excel
        Route::get('/level/export_excel', [LevelController::class, 'export_excel']); // export excel
        Route::get('/level/export_pdf', [LevelController::class, 'export_pdf']); // export pdf
    });
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'kategori'], function () {
            Route::get('/', [KategoriController::class, 'index']);
            Route::post('/list', [KategoriController::class, 'list']);
            Route::get('/create', [KategoriController::class, 'create']);
            Route::post('/', [KategoriController::class, 'store']);
            Route::get('/create_ajax', [KategoriController::class, 'create_ajax']);
            Route::post('/ajax', [KategoriController::class, 'store_ajax']);
            Route::get('/{id}', [KategoriController::class, 'show']);
            Route::get('/{id}/edit', [KategoriController::class, 'edit']);
            Route::put('/{id}', [KategoriController::class, 'update']);
            Route::get('/{id}/edit_ajax', [KategoriController::class, 'edit_ajax']);    // menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [KategoriController::class, 'update_ajax']); // mengimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [KategoriController::class, 'confirm_ajax']); // Untuk tampilan confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [KategoriController::class, 'delete_ajax']); // untuk hapus data user ajax 
            Route::delete('/{id}', [KategoriController::class, 'destroy']);
            Route::get('/import', [KategoriController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [KategoriController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [KategoriController::class, 'export_excel']); // export excel
            Route::get('/export_pdf', [KategoriController::class, 'export_pdf']); // export pdf
        });
    });
    Route::middleware(['authorize:ADM,MNG'])->group(function () {
        Route::group(['prefix' => 'supplier'], function () {
            Route::get('/', [SupplierController::class, 'index']);
            Route::post('/list', [SupplierController::class, 'list']);
            Route::get('/create', [SupplierController::class, 'create']);
            Route::post('/', [SupplierController::class, 'store']);
            Route::get('/create_ajax', [SupplierController::class, 'create_ajax']);
            Route::post('/ajax', [SupplierController::class, 'store_ajax']);
            Route::get('/{id}', [SupplierController::class, 'show']);
            Route::get('/{id}/edit', [SupplierController::class, 'edit']);
            Route::put('/{id}', [SupplierController::class, 'update']);
            Route::get('/{id}/edit_ajax', [SupplierController::class, 'edit_ajax']);    // menampilkan halaman form edit user ajax
            Route::put('/{id}/update_ajax', [SupplierController::class, 'update_ajax']); // mengimpan perubahan data user ajax
            Route::get('/{id}/delete_ajax', [SupplierController::class, 'confirm_ajax']); // Untuk tampilan confirm delete user ajax
            Route::delete('/{id}/delete_ajax', [SupplierController::class, 'delete_ajax']); // untuk hapus data user ajax 
            Route::delete('/{id}', [SupplierController::class, 'destroy']);
            Route::get('/import', [SupplierController::class, 'import']); // ajax form upload excel
            Route::post('/import_ajax', [SupplierController::class, 'import_ajax']); // ajax import excel
            Route::get('/export_excel', [SupplierController::class, 'export_excel']); // export excel
            Route::get('/export_pdf', [SupplierController::class, 'export_pdf']); // export pdf
        });
    });
    // artinya semua route di grup ini harus punya role admin dan manager
    // Route::group(['prefix' => 'barang'], function () {
    Route::middleware(['authorize:ADM,MNG,STF,CUS'])->group(function () {
        Route::get('/barang', [BarangController::class, 'index']);
        Route::post('/barang/list', [BarangController::class, 'list']);
        Route::get('/barang/create', [BarangController::class, 'create']);
        Route::post('/barang', [BarangController::class, 'store']);
        Route::get('/barang/create_ajax', [BarangController::class, 'create_ajax']);
        Route::post('/barang/ajax', [BarangController::class, 'store_ajax']);
        Route::get('/barang/{id}', [BarangController::class, 'show']);
        Route::get('/barang/{id}/edit', [BarangController::class, 'edit']);
        Route::put('/barang/{id}', [BarangController::class, 'update']);
        Route::get('/barang/{id}/edit_ajax', [BarangController::class, 'edit_ajax']);    // menampilkan halaman form edit user ajax
        Route::put('/barang/{id}/update_ajax', [BarangController::class, 'update_ajax']); // mengimpan perubahan data user ajax
        Route::get('/barang/{id}/delete_ajax', [BarangController::class, 'confirm_ajax']); // Untuk tampilan confirm delete user ajax
        Route::delete('/barang/{id}/delete_ajax', [BarangController::class, 'delete_ajax']); // untuk hapus data user ajax 
        Route::get('/barang/import', [BarangController::class, 'import']); // ajax form upload excel
        Route::post('/barang/import_ajax', [BarangController::class, 'import_ajax']); // ajax import excel
        Route::get('/barang/export_excel', [BarangController::class, 'export_excel']); // export excel
        Route::get('/barang/export_pdf', [BarangController::class, 'export_pdf']); // export pdf
    });
});
