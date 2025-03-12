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

        /*$data = [
            'level_id' => 2,
            'username' => 'manajer_tiga',
            'nama' => 'Manajer 3',
            'password' => Hash::make('12345'),
        ];
        UserModel::create($data);*/ //Praktikum 1 no 5

        /*$user = UserModel::find(1);
        return view('user', ['data' => $user]);*/ //Praktikum 2.1 no 1

        /*$user = UserModel::where('level_id', 1)->first();
        return view('user', ['data' => $user]);*/ //Praktikum 2.1 no 4

        /*$user = UserModel::firstWhere('level_id', 1);
        return view('user', ['data' => $user]);*/

        /*$user = UserModel::findOr(1, ['username', 'nama'], function () {
            abort(404);
        });
        return view('user', ['data' => $user]);*/ //Praktikum 2.1 no 8

        /*$user = UserModel::findOr(20, ['username', 'nama'], function () {
            abort(404);
        });
        return view('user', ['data' => $user]);*/ //Praktikum 2.1 no 10

        /*$user = UserModel::findOrfail(1);
        return view('user', ['data' => $user]);*/ // Praktikum 2.2 no 1

        /*$user = UserModel::where('username', 'manager9')->firstOrFail();
        return view('user', ['data' => $user]);*/ // Praktikum 2.2 no 3

        /*$user = UserModel::where('level_id', 2)->count();
        dd($user);
        return view('user', ['data' => $user]);*/ // Praktikum 2.3 no 1

        /*$user = UserModel::where('level_id', 2)->count();
        return view('user', ['user' => $user]);*/ // Praktikum 2.3 no 3

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'manager'
        //     ],
        //     );
        // return view ('user', ['data' => $user]); //Praktikum 2.4 no 1

        // $user = UserModel::firstOrCreate(
        //     [
        //         'username' => 'manager22',
        //         'nama' => 'manager Dua Dua',
        //         'password' => Hash::make('12345'),
        //         'level_id' => 2
        //     ],
        // );
        // return view('user', ['data' => $user]); // Praktikum 2.4 no 4

        // $user = UserModel::firstOrNew(
        //     [
        //         'username' => 'manager',
        //         'nama' => 'manager'
        //     ]
        // );
        // return view('user', ['data' => $user]); //Praktikum 2.4 no 6

        $user = UserModel::firstOrNew(
            [
                'username' => 'manager33',
                'nama'  => 'Manager Tiga Tiga',
                'password' => Hash::make('12345'),
                'level_id' => 2
            ],
        );
        $user->save(); // Praktikum 2.4 no 10

        return view('user', ['data' => $user]); // Praktikum 2.4 no 8



        // coba akses model UserModel
        /*$user = UserModel::all(); //ambil semua data dari tabel m_user
        return view('user', ['data' => $user]);*/
    }
}
