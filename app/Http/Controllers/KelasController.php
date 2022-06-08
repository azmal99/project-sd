<?php

namespace App\Http\Controllers;

use App\Models\Kelas; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class KelasController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $kelas = Kelas::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Kelas',
            'data' => [
                'user' => $kelas,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $kelas = Kelas::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Siswa',
            'data' => [
                'user' => $kelas,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $kelas = new Kelas();
        $randomId = rand(1,99);
        $kelas->id = $randomId;
        $kelas->kd_kelas = ($request->input('kd_kelas'));
        $kelas->nama_kelas = ($request->input('nama_kelas'));
        $kelas->guru_id = ($request->input('guru_id'));
        $kelas->enable_flag = ($request->input('enable_flag'));
        
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Kelas',
            'data' =>[
                'user' => $kelas,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $kelas = Kelas::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Kelas',
                'data' => [
                    'user' => $kelas,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $kelas = Kelas::where('id', '=',  $id)->first();
        $kelas->enable_flag = 'N';
        $kelas->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Siswa',
            'data' => [
                'user' => $kelas,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}