<?php

namespace App\Http\Controllers;

use App\Models\Pembelajaran; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Arr;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class PembelajaranController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $pembelajaran = Pembelajaran::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Pembelajaran',
            'data' => [
                'user' => $pembelajaran,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $pembelajaran = Pembelajaran::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Pembelajaran',
            'data' => [
                'user' => $pembelajaran,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showByKelasMapel(Request $request)
    {
        $kelas = ($request->input('kelas_id'));
        $mapel = ($request->input('mata_pelajaran_id'));
        
        $penilaian = DB::table('pembelajaran')
                    ->select('siswa.id', 'siswa.nama_siswa', 'siswa.nis', 'siswa.nisn', 
                             'mata_pelajaran.nama_mata_pelajaran')
                    ->where('pembelajaran.kelas_id', $kelas)
                    ->where('mata_pelajaran.id', $mapel)
                    ->join('siswa', 'pembelajaran.siswa_id', '=', 'siswa.id')
                    ->join('mata_pelajaran', 'pembelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id')
                    ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Mata Pelajaran By Kelas',
            'data' => [
                'user' => $penilaian,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $pembelajaran = new Pembelajaran();
        $pembelajaran->siswa_id = ($request->input('siswa_id'));
        $pembelajaran->kelas_id = ($request->input('kelas_id'));
        $pembelajaran->mata_pelajaran_id = ($request->input('mata_pelajaran_id'));
        $pembelajaran->kd_nilai_pengetahuan = ($request->input('kd_nilai_pengetahuan'));
        $pembelajaran->kd_nilai_keterampilan = ($request->input('kd_nilai_keterampilan'));
        $pembelajaran->kd_nilai_tugas = ($request->input('kd_nilai_tugas'));
        $pembelajaran->jumlah_nilai = ($request->input('jumlah_nilai'));
        $pembelajaran->tahuan_ajar_id = ($request->input('tahuan_ajar_id'));
        
        $pembelajaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Pembelajaran',
            'data' =>[
                'user' => $pembelajaran,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $pembelajaran = Pembelajaran::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Pembelajaran',
                'data' => [
                    'user' => $pembelajaran,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $pembelajaran = Pembelajaran::where('id', '=',  $id)->first();
        $pembelajaran->enable_flag = 'N';
        $pembelajaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Mata Pelajaran',
            'data' => [
                'user' => $pembelajaran,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}