<?php

namespace App\Http\Controllers;

use App\Models\AnggotaEkstrakulikuler; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AnggotaEkskulController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $anggota_ekstrakulikuler = AnggotaEkstrakulikuler::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data AnggotaEkstrakulikuler',
            'data' => [
                'user' => $anggota_ekstrakulikuler,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $anggota_ekstrakulikuler = AnggotaEkstrakulikuler::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show AnggotaEkstrakulikuler',
            'data' => [
                'user' => $anggota_ekstrakulikuler,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $anggota_ekstrakulikuler = new AnggotaEkstrakulikuler();
        $randomId = rand(1,99);
        $anggota_ekstrakulikuler->id = $randomId;
        $anggota_ekstrakulikuler->siswa_id = ($request->input('siswa_id'));
        $anggota_ekstrakulikuler->nilai_ekskul = ($request->input('nilai_ekskul'));
        $anggota_ekstrakulikuler->ekskul_id = ($request->input('ekskul_id'));
        $anggota_ekstrakulikuler->enable_flag = ($request->input('enable_flag'));
        
        $anggota_ekstrakulikuler->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah AnggotaEkstrakulikuler',
            'data' =>[
                'user' => $anggota_ekstrakulikuler,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $anggota_ekstrakulikuler = AnggotaEkstrakulikuler::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update AnggotaEkstrakulikuler',
                'data' => [
                    'user' => $anggota_ekstrakulikuler,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $anggota_ekstrakulikuler = AnggotaEkstrakulikuler::where('id', '=',  $id)->first();
        $anggota_ekstrakulikuler->enable_flag = 'N';
        $anggota_ekstrakulikuler->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Mata Pelajaran',
            'data' => [
                'user' => $anggota_ekstrakulikuler,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}