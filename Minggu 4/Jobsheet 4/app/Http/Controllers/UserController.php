<?php

namespace App\Http\Controllers;

use App\Models\UserModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        // tambah data user dengan Eloquent Model
        /*$data = [
            'nama' => 'Pelanggan Pertama',
        ];
        UserModel::where('username', 'customer-1')->update($data);//update data user */
        
        /*$data = [
            'username' => 'customer-1',
            'nama' => 'Pelanggan',
            'password' => Hash::make('12345'),
            'level_id' => 5
        ];*/
        //UserModel::insert($data); //tambahkan data ke tabel m_user

        /*$data = [
            'level_id' => 2,
            'username' => 'manajer_dua',
            'nama' => 'Manajer 2',
            'password' => Hash::make('12345'),
        ];
        UserModel::create($data);*/ //Praktikum 1 no 2

        $data = [
            'level_id' => 2,
            'username' => 'manajer_tiga',
            'nama' => 'Manajer 3',
            'password' => Hash::make('12345'),
        ];
        UserModel::create($data);

        // coba akses model UserModel
        $user = UserModel::all(); //ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);
    }
}
