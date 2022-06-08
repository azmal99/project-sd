<?php

namespace App\Http\Controllers;

use App\Models\NilaiKeterampilan; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class NilaiKeterampilanController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $nilai_keterampilan = NilaiKeterampilan::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data NilaiKeterampilan',
            'data' => [
                'user' => $nilai_keterampilan,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $nilai_keterampilan = NilaiKeterampilan::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show NilaiKeterampilan',
            'data' => [
                'user' => $nilai_keterampilan,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $nilai_keterampilan = new NilaiKeterampilan();
        $randomId = rand(1,99);
        $nilai_keterampilan->id = $randomId;
        $nilai_keterampilan->siswa_id = ($request->input('siswa_id'));
        $nilai_keterampilan->kd_nilai_pengetahuan = ($request->input('kd_nilai_keterampilan'));
        $nilai_keterampilan->ph1 = ($request->input('ph1'));
        $nilai_keterampilan->ph2 = ($request->input('ph2'));
        $nilai_keterampilan->ph3 = ($request->input('ph3'));
        $nilai_keterampilan->ph4 = ($request->input('ph4'));
        $nilai_keterampilan->ph5 = ($request->input('ph5'));
        $nilai_keterampilan->ph6 = ($request->input('ph6'));
        $nilai_keterampilan->pts = ($request->input('pts'));
        $nilai_keterampilan->pas = ($request->input('psa'));
        $nilai_keterampilan->tahuan_ajar_id = ($request->input('tahuan_ajar_id'));
        
        $nilai_keterampilan->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah NilaiKeterampilan',
            'data' =>[
                'user' => $nilai_keterampilan,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $nilai_keterampilan = NilaiKeterampilan::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update NilaiKeterampilan',
                'data' => [
                    'user' => $nilai_keterampilan,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $nilai_keterampilan = NilaiKeterampilan::where('id', $id)->first();
        $nilai_keterampilan->delete();

        return response()->json([
                'success' => true,
                'message' => 'Berhasil Delete NilaiKeterampilan',
                'data' => [
                    'user' => $nilai_keterampilan,
                ],
            ],201)
            ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}