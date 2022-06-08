<?php

namespace App\Http\Controllers;

use App\Models\NilaiTugas; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class NilaiTugasController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $nilai_tugas = NilaiTugas::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data NilaiTugas',
            'data' => [
                'user' => $nilai_tugas,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $nilai_tugas = NilaiTugas::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show NilaiTugas',
            'data' => [
                'user' => $nilai_tugas,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $nilai_tugas = new NilaiTugas();
        $randomId = rand(1,99);
        $nilai_tugas->id = $randomId;
        $nilai_tugas->siswa_id = ($request->input('siswa_id'));
        $nilai_tugas->kd_nilai_pengetahuan = ($request->input('kd_nilai_tugas'));
        $nilai_tugas->ph1 = ($request->input('ph1'));
        $nilai_tugas->ph2 = ($request->input('ph2'));
        $nilai_tugas->ph3 = ($request->input('ph3'));
        $nilai_tugas->ph4 = ($request->input('ph4'));
        $nilai_tugas->ph5 = ($request->input('ph5'));
        $nilai_tugas->ph6 = ($request->input('ph6'));
        $nilai_tugas->pts = ($request->input('pts'));
        $nilai_tugas->pas = ($request->input('psa'));
        $nilai_tugas->tahuan_ajar_id = ($request->input('tahuan_ajar_id'));
        
        $nilai_tugas->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah NilaiTugas',
            'data' =>[
                'user' => $nilai_tugas,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $nilai_keternilai_tugasampilan = NilaiTugas::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update NilaiTugas',
                'data' => [
                    'user' => $nilai_tugas,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $nilai_tugas = NilaiTugas::where('id', $id)->first();
        $nilai_tugas->delete();

        return response()->json([
                'success' => true,
                'message' => 'Berhasil Delete NilaiTugas',
                'data' => [
                    'user' => $nilai_tugas,
                ],
            ],201)
            ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}