<?php

namespace App\Http\Controllers;

use App\Models\Ekskul; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class EkskulController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $ekskul = Ekskul::all()->where('enable_flag', 'Y');
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Ekskul',
            'data' => [
                'user' => $ekskul,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $ekskul = Ekskul::where('id', $id)->first()->where('enable_flag', 'Y');
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Ekskul',
            'data' => [
                'user' => $ekskul,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $ekskul = new Ekskul();
        $randomId = rand(1,99);
        $ekskul->id = $randomId;
        $ekskul->kd_ekskul = ($request->input('kd_ekskul'));
        $ekskul->nama_ekskul = ($request->input('nama_ekskul'));
        $ekskul->guru_id = ($request->input('guru_id'));
        $ekskul->enable_flag = ($request->input('enable_flag'));
        
        $ekskul->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Ekskul',
            'data' =>[
                'user' => $ekskul,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $ekskul = Ekskul::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Ekskul',
                'data' => [
                    'user' => $ekskul,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $ekskul = Ekskul::where('id', '=',  $id)->first();
        $ekskul->enable_flag = 'N';
        $ekskul->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Ekskul',
            'data' => [
                'user' => $ekskul,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}