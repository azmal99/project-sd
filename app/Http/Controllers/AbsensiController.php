<?php

namespace App\Http\Controllers;

use App\Models\Absensi; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class AbsensiController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $absensi = Absensi::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Absensi',
            'data' => [
                'user' => $absensi,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $absensi = Absensi::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Absensi',
            'data' => [
                'user' => $absensi,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $absensi = new Absensi();
        $absensi->siswa_id = ($request->input('siswa_id'));
        $absensi->sakit = ($request->input('sakit'));
        $absensi->izin = ($request->input('izin'));
        $absensi->tanpa_alassan = ($request->input('tanpa_alassan'));
        $absensi->tahun_ajar_id = ($request->input('tahun_ajar_id'));
        
        $absensi->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Absensi',
            'data' =>[
                'user' => $absensi,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $absensi = Absensi::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Absensi',
                'data' => [
                    'user' => $absensi,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $absensi = Absensi::where('id', $id)->first();
        $absensi->delete();

        return response()->json([
                'success' => true,
                'message' => 'Berhasil Delete Absensi',
                'data' => [
                    'user' => $absensi,
                ],
            ],201)
            ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}