<?php

namespace App\Http\Controllers;

use App\Models\Rapot; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

class RapotController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $rapot = Rapot::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Rapot',
            'data' => [
                'user' => $rapot,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function indexAll()
    {
        $rapot = DB::table('rapot')
        ->select('siswa.nama_siswa', 'kelas.nama_kelas', 'absensi.sakit', 'absensi.izin', 'absensi.tanpa_alasan',
                 'ekskul.kd_ekskul', 'ekskul.nama_ekskul', 'rapot.kriteria_kelulusan', 
                 'tahun_ajaran.tahun_ajar', 'tahun_ajaran.semester', 'rapot.enable_flag')
        ->join('siswa','rapot.siswa_id','=','siswa.id')
        ->join('kelas','siswa.kelas_id','=','kelas.id')
        ->join('absensi','siswa.id','=','absensi.siswa_id')
        ->join('kepribadian','siswa.id','=','kepribadian.siswa_id')
        ->join('anggota_ekstrakulikuler','siswa.id','=','anggota_ekstrakulikuler.siswa_id')
        ->join('ekskul','anggota_ekstrakulikuler.ekskul_id','=','ekskul.id')
        ->join('tahun_ajaran','rapot.tahun_ajar_id','=','tahun_ajaran.id')
        ->get();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Rapot',
            'data' => [
                'user' => $rapot,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function exportRapot()
    {
        $exportRapot = DB::table('rapot')
                    ->select()
                    ->where()
                    ->join()
                    ->get();
                    
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Export Rapot',
            'data' => [
                'user' => $rapot,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');   
    }

    public function show($id)
    {
        $rapot = Rapot::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Rapot',
            'data' => [
                'user' => $rapot,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function showBySiswa($siswa_id)
    {
        // $rapot = Rapot::where('siswa_id', $siswa_id)->first();
        $rapot = DB::table('rapot')
        ->select('siswa.nama_siswa', 'kelas.nama_kelas', 'rapot.predikat', 'absensi.sakit', 
                 'absensi.izin', 'absensi.tanpa_alasan',
                 'ekskul.kd_ekskul', 'ekskul.nama_ekskul', 'rapot.kriteria_kelulusan', 
                 'tahun_ajaran.tahun_ajar', 'tahun_ajaran.semester', 'rapot.enable_flag')
        ->where('rapot.siswa_id', $siswa_id)
        ->join('siswa','rapot.siswa_id','=','siswa.id')
        ->join('kelas','siswa.kelas_id','=','kelas.id')
        ->join('absensi','siswa.id','=','absensi.siswa_id')
        ->join('kepribadian','siswa.id','=','kepribadian.siswa_id')
        ->join('anggota_ekstrakulikuler','siswa.id','=','anggota_ekstrakulikuler.siswa_id')
        ->join('ekskul','anggota_ekstrakulikuler.ekskul_id','=','ekskul.id')
        ->join('tahun_ajaran','rapot.tahun_ajar_id','=','tahun_ajaran.id')
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Rapot By Siswa',
            'data' => [
                'user' => $rapot,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $rapot = new Rapot();
        $rapot->siswa_id = ($request->input('siswa_id'));
        $rapot->kriteria_kelulusan = ($request->input('kriteria_kelulusan'));
        $rapot->enable_flag = ($request->input('enable_flag'));
        $rapot->tahun_ajar_id = ($request->input('tahun_ajar_id'));
        $rapot->predikat = ($request->input('predikat'));
        
        $rapot->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Rapot',
            'data' =>[
                'user' => $rapot,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $rapot = Rapot::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Rapot',
                'data' => [
                    'user' => $rapot,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $rapot = Rapot::where('id', '=',  $id)->first();
        $rapot->enable_flag = 'N';
        $rapot->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Rapot',
            'data' => [
                'user' => $rapot,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}