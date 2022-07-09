<?php

namespace App\Http\Controllers;

use TahunAjaranController;
use App\Models\Siswa; //File Model
use App\Models\Absensi; //File Model
use App\Models\Kepribadian; //File Model
use App\Models\NilaiPengetahuan; //File Model
use App\Models\NilaiKeterampilan; //File Model
use App\Models\NilaiTugas; //File Model
use App\Models\Pembelajaran; //File Model
use App\Models\Rapot; //File Model
use App\Models\TahunAjaran; //File Model
use App\Models\AnggotaEkstrakulikuler; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $randomIdSiswa = $siswa->id;

        $absensi = new Absensi();
        $absensi->siswa_id = $randomIdSiswa;
        $absensi->sakit = null;
        $absensi->izin = null;
        $absensi->tanpa_alasan = null;
        $absensi->tahun_ajar_id = null;

        $kepribadian = new Kepribadian();
        $kepribadian->siswa_id = $randomIdSiswa;
        $kepribadian->sikap_spiritual = null;
        $kepribadian->kerajinan = null;
        $kepribadian->kebersihan = null;
        $kepribadian->kerapihan = null;
        $kepribadian->cttn_walikelas = null;

        $nilai_keterampilan = new NilaiKeterampilan();
        $nilai_keterampilan->siswa_id = $randomIdSiswa;
        $nilai_keterampilan->kd_nilai_keterampilan = null;
        $nilai_keterampilan->ph1 = null;
        $nilai_keterampilan->ph2 = null;
        $nilai_keterampilan->ph3 = null;
        $nilai_keterampilan->ph4 = null;
        $nilai_keterampilan->ph5 = null;
        $nilai_keterampilan->ph6 = null;
        $nilai_keterampilan->pts = null;
        $nilai_keterampilan->pas = null;
        $nilai_keterampilan->tahun_ajar_id = null;

        $nilai_pengetahuan = new NilaiPengetahuan();
        $nilai_pengetahuan->siswa_id = $randomIdSiswa;
        $nilai_pengetahuan->kd_nilai_pengetahuan = null;
        $nilai_pengetahuan->ph1 = null;
        $nilai_pengetahuan->ph2 = null;
        $nilai_pengetahuan->ph3 = null;
        $nilai_pengetahuan->ph4 = null;
        $nilai_pengetahuan->ph5 = null;
        $nilai_pengetahuan->ph6 = null;
        $nilai_pengetahuan->pts = null;
        $nilai_pengetahuan->pas = null;
        $nilai_pengetahuan->tahun_ajar_id = null;

        $nilai_tugas = new NilaiTugas();
        $nilai_tugas->siswa_id = $randomIdSiswa;
        $nilai_tugas->kd_nilai_tugas = null;
        $nilai_tugas->ph1 = null;
        $nilai_tugas->ph2 = null;
        $nilai_tugas->ph3 = null;
        $nilai_tugas->ph4 = null;
        $nilai_tugas->ph5 = null;
        $nilai_tugas->ph6 = null;
        $nilai_tugas->pts = null;
        $nilai_tugas->pas = null;
        $nilai_tugas->tahun_ajar_id = null;

        $rapot = new Rapot();
        $rapot->siswa_id = $randomIdSiswa;
        $rapot->kriteria_kelulusan = null;
        $rapot->enable_flag = 'Y';
        $rapot->tahun_ajar_id = null;
        $rapot->predikat = null;

        if ($request->input('ekskul_id') <> null){
            $ekskul_id = $request->input('ekskul_id');

            $anggota_ekstrakulikuler = new AnggotaEkstrakulikuler();
            $anggota_ekstrakulikuler->siswa_id = $randomIdSiswa;
            $anggota_ekstrakulikuler->nilai_ekskul = null;
            $anggota_ekstrakulikuler->ekskul_id = $ekskul_id;
            $anggota_ekstrakulikuler->enable_flag = 'Y';
        
            $anggota_ekstrakulikuler->save();
        }

        $kelas_id = $siswa->kelas_id;
        $kelas_siswa = DB::table('kelas')->select('kd_kelas')->where('id', $kelas_id);
        $kelas_ob = (object) $kelas_siswa;
        $mapel_siswa = DB::table('mata_pelajaran')->select('id')->where('kd_mata_pelajaran', 'like', $kelas_id, '%');
        $mapel_size = count($mapel_siswa);

        for($i=0; $i<=$mapel_size; $i++){
            $pembelajaran = new Pembelajaran();

            $pembelajaran->siswa_id = $randomIdSiswa;
            $pembelajaran->kelas_id = $siswa->kelas_id;
            $pembelajaran->mata_pelajaran_id = $mapel_siswa->get($i)->id;
            $pembelajaran->kd_nilai_pengetahuan = null;
            $pembelajaran->kd_nilai_keterampilan = null;
            $pembelajaran->kd_nilai_tugas = null;
            $pembelajaran->jumlah_nilai = null;
            $pembelajaran->tahun_ajar_id = null;

            $pembelajaran->save();
        }
        
        $absensi->save();
        $kepribadian->save();
        $nilai_keterampilan->save();
        $nilai_pengetahuan->save();
        $nilai_tugas->save();
        $rapot->save();

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