<?php

namespace App\Http\Controllers;

use App\Models\Guru; //File Model
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class GuruController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List Guru
    public function index()
    {
        $guru = Guru::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Guru',
            'data' => [
                'user' => $guru,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $guru = Guru::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Guru',
            'data' => [
                'user' => $guru,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $guru = new Guru();
        $randomId = rand(1,99);
        $guru->id = $randomId;
        $guru->kd_guru = ($request->input('kd_guru'));
        $guru->nama_guru = ($request->input('nama_guru'));
        $guru->enable_flag = ($request->input('enable_flag'));
        
        $guru->save();
        
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Guru',
            'data' =>[
                'user' => $guru,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $guru = Guru::find($id)->update($request->all()); 

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Update Guru',
            'data' => [
                'user' => $guru,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // DELETE
    public function delete($id)
    {
        $guru = Guru::where('id', '=',  $id)->first();
        $guru->enable_flag = 'N';
        $guru->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Guru',
            'data' => [
                'user' => $guru,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // HARD DELETE
    public function hardDelete($id)
    {
        $guru = Guru::where('id', '=',  $id)->first();
        $guru->each->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Hard Delete Guru',
            'data' => [
                'user' => $guru,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}