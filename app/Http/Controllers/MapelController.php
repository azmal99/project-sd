<?php

namespace App\Http\Controllers;

use App\Models\MataPelajaran; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class MapelController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $mata_pelajaran = MataPelajaran::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Mata Pelajaran',
            'data' => [
                'user' => $mata_pelajaran,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function indexMapel()
    {
        // $mata_pelajaran = MataPelajaran::where('guru_id', $guru_id)->first();

        $mata_pelajaran = DB::table('mata_pelajaran')
        ->select( 'mata_pelajaran.kd_mata_pelajaran' , 'mata_pelajaran.nama_mata_pelajaran', 'guru.nama_guru')
        ->join('guru','mata_pelajaran.guru_id','=','guru.id')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Mata Pelajaran',
            'data' => [
                'user' => $mata_pelajaran,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $mata_pelajaran = MataPelajaran::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Mata Pelajaran',
            'data' => [
                'user' => $mata_pelajaran,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showByKdMapel($kd_mata_pelajaran)
    {
        $mata_pelajaran = MataPelajaran::where('kd_mata_pelajaran', $kd_mata_pelajaran)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Mata Pelajaran By Kode Mapel',
            'data' => [
                'user' => $mata_pelajaran,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showByGuruId($guru_id)
    {
        // $mata_pelajaran = MataPelajaran::where('guru_id', $guru_id)->first();
        $mata_pelajaran = DB::table('mata_pelajaran')
        ->select( 'mata_pelajaran.kd_mata_pelajaran' , 'mata_pelajaran.nama_mata_pelajaran', 'guru.nama_guru')
        ->where('mata_pelajaran.guru_id', $guru_id)
        ->join('guru','mata_pelajaran.guru_id','=','guru.id')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Mata Pelajaran By Id Guru',
            'data' => [
                'user' => $mata_pelajaran,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $mata_pelajaran = new MataPelajaran();
        $randomId = rand(1,99);
        $mata_pelajaran->id = $randomId;
        $mata_pelajaran->kd_mata_pelajaran = ($request->input('kd_mata_pelajaran'));
        $mata_pelajaran->nama_mata_pelajaran = ($request->input('nama_mata_pelajaran'));
        $mata_pelajaran->guru_id = ($request->input('guru_id'));
        $mata_pelajaran->enable_flag = ($request->input('enable_flag'));
        
        $mata_pelajaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Mata Pelajaran',
            'data' =>[
                'user' => $mata_pelajaran,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $mata_pelajaran = MataPelajaran::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Mata Pelajaran',
                'data' => [
                    'user' => $mata_pelajaran,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $mata_pelajaran = MataPelajaran::where('id', '=',  $id)->first();
        $mata_pelajaran->enable_flag = 'N';
        $mata_pelajaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Mata Pelajaran',
            'data' => [
                'user' => $mata_pelajaran,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}