<?php

namespace App\Http\Controllers;

use App\Models\Ekskul; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class EkskulController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $ekskul = Ekskul::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Ekskul',
            'data' => [
                'user' => $ekskul,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showEkskul()
    {
        $ekskul = DB::table('ekskul')
                    // ->select(array('ekskul.id', 'guru.nama_guru', 'guru.id', DB::raw('COUNT(anggota_ekstrakulikuler.siswa_id) as jumlah')))
                    ->select('ekskul.id as ekskul_id', 'ekskul.nama_ekskul', 'guru.nama_guru', 'guru.id as guru_id')
                    ->where('ekskul.enable_flag', '=', 'Y')
                    ->join('guru', 'ekskul.guru_id', '=', 'guru.id')
                    // ->join('anggota_ekstrakulikuler', 'ekskul.id', '=', 'anggota_ekstrakulikuler.ekskul_id')
                    // ->group_by('anggota_ekstrakulikuler.siswa_id')
                    ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Ekskul',
            'data' => [
                'user' => $ekskul,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showBySiswaAll()
    {
        $ekskul = DB::table('siswa')
                    ->select('ekskul.id as ekskul_id', 'ekskul.nama_ekskul', 'siswa.nama_siswa', 'siswa.id as siswa_id',
                             'anggota_ekstrakulikuler.nilai_ekskul')
                    ->where('ekskul.enable_flag', '=', 'Y')
                    ->join('ekskul', 'siswa.ekskul_id', '=', 'ekskul.id')
                    ->join('anggota_ekstrakulikuler', 'ekskul.id', '=', 'anggota_ekstrakulikuler.ekskul_id')
                    // ->orderBy('ekskul.nama_ekskul', 'ASC')
                    ->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Ekskul',
            'data' => [
                'user' => $ekskul,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showBySiswaId($siswa_id)
    {
        $ekskul = DB::table('siswa')
                    ->select('ekskul.id as ekskul_id', 'ekskul.nama_ekskul', 'siswa.nama_siswa', 'siswa.id as siswa_id',
                             'anggota_ekstrakulikuler.nilai_ekskul')
                    ->where('ekskul.enable_flag', '=', 'Y')
                    ->where('siswa.id', $siswa_id)
                    ->join('ekskul', 'siswa.ekskul_id', '=', 'ekskul.id')
                    ->join('anggota_ekstrakulikuler', 'ekskul.id', '=', 'anggota_ekstrakulikuler.ekskul_id')
                    // ->orderBy('ekskul.nama_ekskul', 'ASC')
                    ->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Ekskul',
            'data' => [
                'user' => $ekskul,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function show($id)
    {
        $ekskul = Ekskul::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Ekskul',
            'data' => [
                'user' => $ekskul,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $ekskul = new Ekskul();
        $ekskul->kd_ekskul = ($request->input('kd_ekskul'));
        $ekskul->nama_ekskul = ($request->input('nama_ekskul'));
        $ekskul->enable_flag = ($request->input('enable_flag'));
        
        $ekskul->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Ekskul',
            'data' =>[
                'user' => $ekskul,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $ekskul = Ekskul::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Ekskul',
                'data' => [
                    'user' => $ekskul,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $ekskul = Ekskul::where('id', '=',  $id)->first();
        $ekskul->enable_flag = 'N';
        $ekskul->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Ekskul',
            'data' => [
                'user' => $ekskul,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}