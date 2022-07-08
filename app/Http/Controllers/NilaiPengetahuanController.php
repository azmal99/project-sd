<?php

namespace App\Http\Controllers;

use App\Models\NilaiPengetahuan; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class NilaiPengetahuanController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $nilai_pengetahuan = NilaiPengetahuan::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data NilaiPengetahuan',
            'data' => [
                'user' => $nilai_pengetahuan,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $nilai_pengetahuan = NilaiPengetahuan::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show NilaiPengetahuan',
            'data' => [
                'user' => $nilai_pengetahuan,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $nilai_pengetahuan = new NilaiPengetahuan();
        $randomId = rand(1,9999999);
        $nilai_pengetahuan->id = $randomId;
        $nilai_pengetahuan->siswa_id = ($request->input('siswa_id'));
        $nilai_pengetahuan->kd_nilai_pengetahuan = ($request->input('kd_nilai_pengetahuan'));
        $nilai_pengetahuan->ph1 = ($request->input('ph1'));
        $nilai_pengetahuan->ph2 = ($request->input('ph2'));
        $nilai_pengetahuan->ph3 = ($request->input('ph3'));
        $nilai_pengetahuan->ph4 = ($request->input('ph4'));
        $nilai_pengetahuan->ph5 = ($request->input('ph5'));
        $nilai_pengetahuan->ph6 = ($request->input('ph6'));
        $nilai_pengetahuan->pts = ($request->input('pts'));
        $nilai_pengetahuan->pas = ($request->input('psa'));
        $nilai_pengetahuan->tahuan_ajar_id = ($request->input('tahuan_ajar_id'));
        
        $nilai_pengetahuan->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah NilaiPengetahuan',
            'data' =>[
                'user' => $nilai_pengetahuan,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $nilai_pengetahuan = NilaiPengetahuan::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update NilaiPengetahuan',
                'data' => [
                    'user' => $nilai_pengetahuan,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $nilai_pengetahuan = NilaiPengetahuan::where('id', $id)->first();
        $nilai_pengetahuan->delete();

        return response()->json([
                'success' => true,
                'message' => 'Berhasil Delete NilaiPengetahuan',
                'data' => [
                    'user' => $nilai_pengetahuan,
                ],
            ],201)
            ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}