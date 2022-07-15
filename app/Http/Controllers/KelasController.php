<?php

namespace App\Http\Controllers;

use App\Models\Kelas; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function indexKelas()
    {
        $kelas = DB::table('guru')
        ->select( 'kelas.kd_kelas' , 'kelas.nama_kelas', 'guru.nama_guru')
        ->where('kelas.enable_flag', 'Y')
        ->join('kelas','guru.kelas_id','=','kelas.id')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Kelas',
            'data' => [
                'user' => $kelas,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showBymapel($kelas_id)
    {
        $kelas_siswa = DB::table('kelas')
                        ->select('kd_kelas')
                        ->where('id', '=', $kelas_id)->first();
        $kd_kelas = $kelas_siswa->kd_kelas;
        $mapel_siswa = DB::table('guru')
                        ->select('mata_pelajaran.kd_mata_pelajaran', 'mata_pelajaran.nama_mata_pelajaran', 'guru.id',
                                 'guru.nama_guru')
                        ->where('mata_pelajaran.kd_mata_pelajaran', 'like', $kd_kelas.'%')
                        ->join('mata_pelajaran','guru.mata_pelajaran_id','=','mata_pelajaran.id')
                        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Kelas',
            'data' => [
                'user' => $mapel_siswa,
                ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function show($id)
    {
        $kelas = Kelas::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Kelas',
            'data' => [
                'user' => $kelas,
                ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showByGuru($guru_id)
    {
        // $kelas = Kelas::where('guru_id', $guru_id)->first();
        $kelas = DB::table('guru')
        ->select( 'kelas.id' ,'kelas.kd_kelas' , 'kelas.nama_kelas', 'guru.nama_guru')
        ->where('guru.id', $guru_id)
        ->where('kelas.enable_flag', 'Y')
        ->join('kelas','guru.kelas_id','=','kelas.id')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Kelas',
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
        $kelas->kd_kelas = ($request->input('kd_kelas'));
        $kelas->nama_kelas = ($request->input('nama_kelas'));
        $kelas->enable_flag = ($request->input('enable_flag'));
        
        $kelas->save();

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