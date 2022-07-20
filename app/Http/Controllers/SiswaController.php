<?php

namespace App\Http\Controllers;

use TahunAjaranController;
use App\Models\Siswa; //File Model
use App\Models\Absensi; //File Model
use App\Models\Kepribadian; //File Model
use App\Models\Kelas; //File Model
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
use Illuminate\Support\Arr;
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
        $siswa->ekskul_id = ($request->input('ekskul_id'));
        $siswa->tahun_ajar_id = ($request->input('tahun_ajar_id'));

        $siswa->save();
        $randomIdSiswa = $siswa->id;

        $absensi = new Absensi();
        $absensi->siswa_id = $randomIdSiswa;
        $absensi->sakit = 0;
        $absensi->izin = 0;
        $absensi->tanpa_alasan = 0;
        $absensi->tahun_ajar_id = ($request->input('tahun_ajar_id'));

        $kepribadian = new Kepribadian();
        $kepribadian->siswa_id = $randomIdSiswa;
        $kepribadian->sikap_spiritual = 0;
        $kepribadian->kerajinan = 0;
        $kepribadian->kebersihan = 0;
        $kepribadian->kerapihan = 0;
        $kepribadian->cttn_walikelas = null;

        $rapot = new Rapot();
        $rapot->siswa_id = $randomIdSiswa;
        $rapot->kriteria_kelulusan = null;
        $rapot->enable_flag = 'Y';
        $rapot->tahun_ajar_id = ($request->input('tahun_ajar_id'));
        $rapot->predikat = null;

        if ($request->input('ekskul_id') <> null){
            $ekskul_id = $request->input('ekskul_id');

            $anggota_ekstrakulikuler = new AnggotaEkstrakulikuler();
            $anggota_ekstrakulikuler->siswa_id = $randomIdSiswa;
            $anggota_ekstrakulikuler->nilai_ekskul = 0;
            $anggota_ekstrakulikuler->ekskul_id = $ekskul_id;
            $anggota_ekstrakulikuler->enable_flag = 'Y';
        
            $anggota_ekstrakulikuler->save();
        }

        $kelas_siswa = DB::table('kelas')
                        ->select('kd_kelas')
                        ->where('id', '=', $siswa->kelas_id)->first();
        $kd_kelas = $kelas_siswa->kd_kelas;
        $mapel_siswa = DB::table('mata_pelajaran')
                        ->select('id')
                        ->where('kd_mata_pelajaran', 'like', $kd_kelas.'%')->get();
        
        for($i=0; $i<count($mapel_siswa); $i++){
            $pembelajaran = new Pembelajaran();

            $mapel = $mapel_siswa[$i]->id;

            $pembelajaran->siswa_id = $randomIdSiswa;
            $pembelajaran->kelas_id = $siswa->kelas_id;
            $pembelajaran->mata_pelajaran_id = $mapel;
            $pembelajaran->nilai_pengetahuan_id = null;
            $pembelajaran->nilai_keterampilan_id = null;
            $pembelajaran->nilai_tugas_id = null;
            $pembelajaran->jumlah_nilai = 0;
            $pembelajaran->tahun_ajar_id = ($request->input('tahun_ajar_id'));

            $nilai_keterampilan = new NilaiKeterampilan();
            $nilai_keterampilan->siswa_id = $randomIdSiswa;
            $nilai_keterampilan->mapel_id = $mapel;
            $nilai_keterampilan->ph1 = 0;
            $nilai_keterampilan->ph2 = 0;
            $nilai_keterampilan->ph3 = 0;
            $nilai_keterampilan->ph4 = 0;
            $nilai_keterampilan->ph5 = 0;
            $nilai_keterampilan->ph6 = 0;
            $nilai_keterampilan->pts = 0;
            $nilai_keterampilan->pas = 0;
            $nilai_keterampilan->tahun_ajar_id = ($request->input('tahun_ajar_id'));

            $nilai_pengetahuan = new NilaiPengetahuan();
            $nilai_pengetahuan->siswa_id = $randomIdSiswa;
            $nilai_pengetahuan->mapel_id = $mapel;
            $nilai_pengetahuan->ph1 = 0;
            $nilai_pengetahuan->ph2 = 0;
            $nilai_pengetahuan->ph3 = 0;
            $nilai_pengetahuan->ph4 = 0;
            $nilai_pengetahuan->ph5 = 0;
            $nilai_pengetahuan->ph6 = 0;
            $nilai_pengetahuan->pts = 0;
            $nilai_pengetahuan->pas = 0;
            $nilai_pengetahuan->tahun_ajar_id = ($request->input('tahun_ajar_id'));

            $nilai_tugas = new NilaiTugas();
            $nilai_tugas->siswa_id = $randomIdSiswa;
            $nilai_tugas->mapel_id = $mapel;
            $nilai_tugas->ph1 = 0;
            $nilai_tugas->ph2 = 0;
            $nilai_tugas->ph3 = 0;
            $nilai_tugas->ph4 = 0;
            $nilai_tugas->ph5 = 0;
            $nilai_tugas->ph6 = 0;
            $nilai_tugas->pts = 0;
            $nilai_tugas->pas = 0;
            $nilai_tugas->tahun_ajar_id = ($request->input('tahun_ajar_id'));


            $pembelajaran->save();
            $nilai_pengetahuan->save();
            $nilai_keterampilan->save();
            $nilai_tugas->save();
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
        $tahun_ajar_baru = ($request->input('tahun_ajar_id'));
        $tahun_ajar_lama = DB::table(siswa)
                        ->select('tahun_ajar_id')
                        ->where('id', $id)
                        ->get();
        $tahun_ajar_lama = $tahun_ajar_lama->tahun_ajar_id;

        $ekskul_baru = ($request->input('ekskul_id'));
        $ekskul_lama = DB::table('siswa')
                        ->select('ekskul_id')
                        ->where('id', $id)
                        ->get();
        $ekskul_lama = $ekskul_lama->ekskul_id;
        
        if ($ekskul_baru <> $ekskul_lama){
            $ekskul_id = $request->input('ekskul_id');

            $anggota_ekstrakulikuler = new AnggotaEkstrakulikuler();
            $anggota_ekstrakulikuler->siswa_id = $id;
            $anggota_ekstrakulikuler->nilai_ekskul = 0;
            $anggota_ekstrakulikuler->ekskul_id = $ekskul_baru;
            $anggota_ekstrakulikuler->enable_flag = 'Y';
        
            $anggota_ekstrakulikuler->save();
        }

        if ($tahun_ajar_baru <> $tahun_ajar_lama){
            $absensi = new Absensi();
            $absensi->siswa_id = $randomIdSiswa;
            $absensi->sakit = 0;
            $absensi->izin = 0;
            $absensi->tanpa_alasan = 0;
            $absensi->tahun_ajar_id = $tahun_ajar_baru;

            $kepribadian = new Kepribadian();
            $kepribadian->siswa_id = $randomIdSiswa;
            $kepribadian->sikap_spiritual = 0;
            $kepribadian->kerajinan = 0;
            $kepribadian->kebersihan = 0;
            $kepribadian->kerapihan = 0;
            $kepribadian->cttn_walikelas = null;

            $nilai_keterampilan = new NilaiKeterampilan();
            $nilai_keterampilan->siswa_id = $randomIdSiswa;
            $nilai_keterampilan->kd_nilai_keterampilan = null;
            $nilai_keterampilan->ph1 = 0;
            $nilai_keterampilan->ph2 = 0;
            $nilai_keterampilan->ph3 = 0;
            $nilai_keterampilan->ph4 = 0;
            $nilai_keterampilan->ph5 = 0;
            $nilai_keterampilan->ph6 = 0;
            $nilai_keterampilan->pts = 0;
            $nilai_keterampilan->pas = 0;
            $nilai_keterampilan->tahun_ajar_id = $tahun_ajar_baru;

            $nilai_pengetahuan = new NilaiPengetahuan();
            $nilai_pengetahuan->siswa_id = $randomIdSiswa;
            $nilai_pengetahuan->kd_nilai_pengetahuan = null;
            $nilai_pengetahuan->ph1 = 0;
            $nilai_pengetahuan->ph2 = 0;
            $nilai_pengetahuan->ph3 = 0;
            $nilai_pengetahuan->ph4 = 0;
            $nilai_pengetahuan->ph5 = 0;
            $nilai_pengetahuan->ph6 = 0;
            $nilai_pengetahuan->pts = 0;
            $nilai_pengetahuan->pas = 0;
            $nilai_pengetahuan->tahun_ajar_id = $tahun_ajar_baru;

            $nilai_tugas = new NilaiTugas();
            $nilai_tugas->siswa_id = $randomIdSiswa;
            $nilai_tugas->kd_nilai_tugas = null;
            $nilai_tugas->ph1 = 0;
            $nilai_tugas->ph2 = 0;
            $nilai_tugas->ph3 = 0;
            $nilai_tugas->ph4 = 0;
            $nilai_tugas->ph5 = 0;
            $nilai_tugas->ph6 = 0;
            $nilai_tugas->pts = 0;
            $nilai_tugas->pas = 0;
            $nilai_tugas->tahun_ajar_id = $tahun_ajar_baru;

            $rapot = new Rapot();
            $rapot->siswa_id = $randomIdSiswa;
            $rapot->kriteria_kelulusan = null;
            $rapot->enable_flag = 'Y';
            $rapot->tahun_ajar_id = $tahun_ajar_baru;
            $rapot->predikat = null;

            if ($request->input('ekskul_id') <> null){
                $ekskul_id = $request->input('ekskul_id');

                $anggota_ekstrakulikuler = new AnggotaEkstrakulikuler();
                $anggota_ekstrakulikuler->siswa_id = $randomIdSiswa;
                $anggota_ekstrakulikuler->nilai_ekskul = 0;
                $anggota_ekstrakulikuler->ekskul_id = $ekskul_id;
                $anggota_ekstrakulikuler->enable_flag = 'Y';
            
                $anggota_ekstrakulikuler->save();
            }

            $kelas_siswa = DB::table('kelas')
                            ->select('kd_kelas')
                            ->where('id', '=', $siswa->kelas_id)->first();
            $kd_kelas = $kelas_siswa->kd_kelas;
            $mapel_siswa = DB::table('mata_pelajaran')
                            ->select('id')
                            ->where('kd_mata_pelajaran', 'like', $kd_kelas.'%')->get();
            
            for($i=0; $i<count($mapel_siswa); $i++){
                $pembelajaran = new Pembelajaran();

                $mapel = $mapel_siswa[$i]->id;

                $pembelajaran->siswa_id = $randomIdSiswa;
                $pembelajaran->kelas_id = $siswa->kelas_id;
                $pembelajaran->mata_pelajaran_id = $mapel;
                $pembelajaran->nilai_pengetahuan_id = null;
                $pembelajaran->nilai_keterampilan_id = null;
                $pembelajaran->nilai_tugas_id = null;
                $pembelajaran->jumlah_nilai = 0;
                $pembelajaran->tahun_ajar_id = $tahun_ajar_baru;

                $pembelajaran->save();
            }
            
            $absensi->save();
            $kepribadian->save();
            $nilai_keterampilan->save();
            $nilai_pengetahuan->save();
            $nilai_tugas->save();
            $rapot->save();
        }
        
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