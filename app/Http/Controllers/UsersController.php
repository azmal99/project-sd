<?php

namespace App\Http\Controllers;

use App\Models\Users; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class UsersController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $users = Users::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data User',
            'data' => [
                'user' => $users,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $users = Users::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Guru',
            'data' => [
                'user' => $users,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $users = new Users();
        $randomId = rand(1,99);
        $users->id = $randomId;
        $users->username = ($request->input('username'));
        $users->password = Hash::make($request->newPassword);
        $users->enable_flag = ($request->input('enable_flag'));
        $users->lvl_akses = ($request->input('lvl_akses'));
        $users->guru_id = $request->input('guru_id');
        
        $users->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah User',
            'data' =>[
                'user' => $users,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $users = Users::where('id', $id)->first();
        if ($users){
            $users->update($request->all());
        }
        $users->username = $request->input('username');
        $users->password = Hash::make($request->newPassword);
        $users->lvl_akses = $request->input('lvl_akses');
        $users->enable_flag = $request->input('enable_flag');
        $users->guru_id = $request->input('guru_id');
        $users->save();
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update User',
                'data' => [
                    'user' => $users,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $users = Users::where('id', '=',  $id)->first();
        $users->enable_flag = 'N';
        $users->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Users',
            'data' => [
                'user' => $users,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}