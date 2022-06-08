<?php

namespace App\Http\Controllers;

use App\Models\TahunAjaran; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class TahunAjaranController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $tahun_ajaran = TahunAjaran::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Tahun Ajaran',
            'data' => [
                'user' => $tahun_ajaran,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $tahun_ajaran = TahunAjaran::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Tahun Ajaran',
            'data' => [
                'user' => $tahun_ajaran,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $tahun_ajaran = new TahunAjaran();
        $randomId = rand(1,99);
        $tahun_ajaran->id = $randomId;
        $tahun_ajaran->kd_tahun_ajar = ($request->input('kd_tahun_ajar'));
        $tahun_ajaran->tahun_ajar = ($request->input('tahun_ajar'));
        $tahun_ajaran->semester = ($request->input('semester'));
        $tahun_ajaran->enable_flag = ($request->input('enable_flag'));
        
        $tahun_ajaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Tahun Ajaran',
            'data' =>[
                'user' => $tahun_ajaran,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $tahun_ajaran = TahunAjaran::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Tahun Ajaran',
                'data' => [
                    'user' => $tahun_ajaran,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $tahun_ajaran = TahunAjaran::where('id', '=',  $id)->first();
        $tahun_ajaran->enable_flag = 'N';
        $tahun_ajaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Tahun Ajaran',
            'data' => [
                'user' => $tahun_ajaran,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}