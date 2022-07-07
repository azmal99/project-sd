<?php

namespace App\Http\Controllers;

use App\Models\Siswa; //File Model
use App\Models\Absensi; //File Model
use App\Models\Kepribadian; //File Model
use App\Models\NilaiPelajaran; //File Model
use App\Models\NilaiKeterampilan; //File Model
use App\Models\NilaiTugas; //File Model
use App\Models\Pembelajaran; //File Model
use App\Models\Rapot; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class SiswaController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List User
    public function index()
    {
        $siswa = Siswa::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Siswa',
            'data' => [
                'user' => $siswa,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $siswa = Siswa::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Siswa',
            'data' => [
                'user' => $siswa,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $siswa = new Siswa();
        $randomId = rand(1,99);
        $siswa->id = $randomId;
        $siswa->nis = ($request->input('nis'));
        $siswa->nama_siswa = ($request->input('nama_siswa'));
        $siswa->nisn = ($request->input('nisn'));
        $siswa->kelas_id = ($request->input('kelas_id'));
        $siswa->jns_kelamin = ($request->input('jns_kelamin'));
        $siswa->tempat_lahir = ($request->input('tempat_lahir'));
        $tgl_lahir = ($request->input('tgl_lahir'));
        $siswa->tgl_lahir = Carbon::createFromFormat('m/d/Y', $tgl_lahir)->format('Y-m-d');
        $siswa->alamat = ($request->input('alamat'));
        $siswa->enable_flag = ($request->input('enable_flag'));
        
        $siswa->save();

        $absensi = new Absensi();
        $randomId = rand(1,99);
        $absensi->id = $randomId;
        $absensi->siswa_id = $siswa->id;
        $absensi->sakit = null;
        $absensi->izin = null;
        $absensi->tanpa_alasan = null;
        $absensi->tahun_ajar_id = null;

        $absensi->save();

        $kepribadian = new Kepribadian();
        $randomId = rand(1,99);
        $kepribadian->id = $randomId;
        $kepribadian->siswa_id = $siswa->id;
        $kepribadian->sikap_spiritual = null;
        $kepribadian->kerajinan = null;
        $kepribadian->kebersihan = null;
        $kepribadian->kerapihan = null;
        $kepribadian->cttn_walikelas = null;

        $kepribadian->save();

        $nilai_keterampilan = new NilaiKeterampilan();
        $randomId = rand(1,99);
        $nilai_keterampilan->id = $randomId;
        $nilai_keterampilan->siswa_id = $siswa->id;
        $nilai_keterampilan->kd_nilai_keterampilan = null;
        $nilai_keterampilan->ph1 = null;
        $nilai_keterampilan->ph2 = null;
        $nilai_keterampilan->ph3 = null;
        $nilai_keterampilan->ph4 = null;
        $nilai_keterampilan->ph5 = null;
        $nilai_keterampilan->ph6 = null;
        $nilai_keterampilan->pts = null;
        $nilai_keterampilan->pas = null;
        $nilai_keterampilan->tahuan_ajar_id = null;

        $nilai_keterampilan->save();

        $nilai_pengetahuan = new NilaiPengetahuan();
        $randomId = rand(1,99);
        $nilai_pengetahuan->id = $randomId;
        $nilai_pengetahuan->siswa_id = $siswa->id;
        $nilai_pengetahuan->kd_nilai_pengetahuan = null;
        $nilai_pengetahuan->ph1 = null;
        $nilai_pengetahuan->ph2 = null;
        $nilai_pengetahuan->ph3 = null;
        $nilai_pengetahuan->ph4 = null;
        $nilai_pengetahuan->ph5 = null;
        $nilai_pengetahuan->ph6 = null;
        $nilai_pengetahuan->pts = null;
        $nilai_pengetahuan->pas = null;
        $nilai_pengetahuan->tahuan_ajar_id = null;
        
        $nilai_pengetahuan->save();

        $nilai_tugas = new NilaiTugas();
        $randomId = rand(1,99);
        $nilai_tugas->id = $randomId;
        $nilai_tugas->siswa_id = $siswa->id;
        $nilai_tugas->kd_nilai_tugas = null;
        $nilai_tugas->ph1 = null;
        $nilai_tugas->ph2 = null;
        $nilai_tugas->ph3 = null;
        $nilai_tugas->ph4 = null;
        $nilai_tugas->ph5 = null;
        $nilai_tugas->ph6 = null;
        $nilai_tugas->pts = null;
        $nilai_tugas->pas = null;
        $nilai_tugas->tahuan_ajar_id = null;
        
        $nilai_tugas->save();

        $pembelajaran = new Pembelajaran();
        $randomId = rand(1,99);
        $pembelajaran->id = $randomId;
        $pembelajaran->siswa_id = $siswa->id;
        $pembelajaran->kelas_id = $siswa->kelas_id;
        $pembelajaran->mata_pelajaran_id = null;
        $pembelajaran->kd_nilai_pengetahuan = null;
        $pembelajaran->kd_nilai_keterampilan = null;
        $pembelajaran->kd_nilai_tugas = null;
        $pembelajaran->jumlah_nilai = null;
        $pembelajaran->tahuan_ajar_id = null;

        $pembelajaran->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Tambah Siswa',
            'data' =>[
                'user' => $siswa,
                ],
        ], 201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $siswa = Siswa::find($id)->update($request->all()); 
        
        return response()->json([
                'success' => true,
                'message' => 'Berhasil Update Siswa',
                'data' => [
                    'user' => $siswa,
                ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //DELETE
    public function delete($id)
    {
        $siswa = Siswa::where('id', '=',  $id)->first();
        $siswa->enable_flag = 'N';
        $siswa->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Siswa',
            'data' => [
                'user' => $siswa,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }



    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}