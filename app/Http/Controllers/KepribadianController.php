<?php

namespace App\Http\Controllers;

use App\Models\Kepribadian; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class KepribadianController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $kepribadian = Kepribadian::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Kepribadian',
            'data' => [
                'user' => $kepribadian,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $kepribadian = Kepribadian::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Kepribadian',
            'data' => [
                'user' => $kepribadian,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showBySiswa()
    {
        $kepribadian = DB::table('kepribadian')
                    ->select('siswa.id', 'siswa.nama_siswa', 'kepribadian.*')
                    ->join('siswa', 'kepribadian.siswa_id', '=', 'siswa.id')
                    ->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Kepribadian',
            'data' => [
                'user' => $kepribadian,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showBySiswaID($siswa_id)
    {
        $kepribadian = DB::table('kepribadian')
                    ->select('siswa.id', 'siswa.nama_siswa', 'kepribadian.*')
                    ->where('kepribadian.siswa_id', $siswa_id)
                    ->join('siswa', 'kepribadian.siswa_id', '=', 'siswa.id')
                    ->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Kepribadian',
            'data' => [
                'user' => $kepribadian,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    //CREATE
    public function store(Request $request)
    {
        $kepribadian = new Kepribadian();
        $kepribadian->siswa_id = ($request->input('siswa_id'));
        $kepribadian->sikap_spiritual = ($request->input('sikap_spiritual'));
        $kepribadian->kerajinan = ($request->input('kerajinan'));
        $kepribadian->kebersihan = ($request->input('kebersihan'));
        $kepribadian->kerapihan = ($request->input('kerapihan'));
        $kepribadian->cttn_walikelas = ($request->input('cttn_walikelas'));
        
        $kepribadian->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Kepribadian',
            'data' =>[
                'user' => $kepribadian,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $kepribadian = Kepribadian::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Kepribadian',
                'data' => [
                    'user' => $kepribadian,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $kepribadian = Kepribadian::where('id', $id)->first();
        $kepribadian->delete();

        return response()->json([
                'success' => true,
                'message' => 'Berhasil Delete Kepribadian',
                'data' => [
                    'user' => $kepribadian,
                ],
            ],201)
            ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}