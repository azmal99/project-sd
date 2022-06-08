<?php

namespace App\Http\Controllers;

use App\Models\Siswa; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class SiswaController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $siswa = Siswa::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Siswa',
            'data' => [
                'user' => $siswa,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $siswa = Siswa::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Siswa',
            'data' => [
                'user' => $siswa,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $siswa = new Siswa();
        $randomId = rand(1,99);
        $siswa->id = $randomId;
        $siswa->nis = ($request->input('nis'));
        $siswa->nama_siswa = ($request->input('nama_siswa'));
        $siswa->nisn = ($request->input('nisn'));
        $siswa->kelas_id = ($request->input('kelas_id'));
        $siswa->enable_flag = ($request->input('enable_flag'));
        
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Siswa',
            'data' =>[
                'user' => $siswa,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Siswa',
                'data' => [
                    'user' => $siswa,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $siswa = Siswa::where('id', '=',  $id)->first();
        $siswa->enable_flag = 'N';
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Siswa',
            'data' => [
                'user' => $siswa,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}