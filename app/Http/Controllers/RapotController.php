<?php

namespace App\Http\Controllers;

use App\Models\Rapot; //File Model
use App\Exports\RapotExport; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;

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
        return Excel::download(new RapotExport, 'leger.xlsx');    
    }

    public function exportPdfRapot()
    {
        $data = Rapot::all();

        view()->share('data', $data);
        $pdf= PDF::loadview('exportRapot-pdf');
        // return 'OKE NIH BISA CUY';    
        return $pdf->download('Laporan-Individu.pdf');
    }

    public function exportRapotBySiswa($siswa_id)
    {
        $exportRapot = DB::table('pembelajaran')
                    ->select('siswa.nama_siswa', 'siswa.nis', 'siswa.nisn', 'mata_pelajaran.nama_mata_pelajaran',
                             'nilai_pengetahuan.ph1 as np_ph1', 'nilai_pengetahuan.ph2 as np_ph2',
                             'nilai_keterampilan.ph1 as nk_ph1', 'nilai_keterampilan.ph2 as nk_ph2',
                             'nilai_tugas.ph1 as nt_ph1', 'nilai_tugas.ph2 as nt_ph2',
                             'nilai_pengetahuan.pts', 'nilai_keterampilan.pts', 'nilai_tugas.pts',
                             'ekskul.nama_ekskul', 'absensi.sakit', 'absensi.izin', 'absensi.tanpa_alasan',
                             'kepribadian.sikap_spiritual', 'kepribadian.kerajinan', 'kepribadian.kerapihan',
                             'kepribadian.kebersihan', 'kepribadian.cttn_walikelas')
                    ->where('pembelajaran.siswa_id', $siswa_id)
                    ->join('mata_pelajaran', 'pembelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id')
                    ->join('nilai_pengetahuan', 'pembelajaran.nilai_pengetahuan_id', '=', 'nilai_pengetahuan.id')
                    ->join('nilai_keterampilan', 'pembelajaran.nilai_keterampilan_id', '=', 'nilai_keterampilan.id')
                    ->join('nilai_tugas', 'pembelajaran.nilai_tugas_id', '=', 'nilai_tugas.id')
                    ->join('siswa', 'pembelajaran.siswa_id', '=', 'siswa.id')
                    ->join('anggota_ekstrakulikuler', 'siswa.id', '=', 'anggota_ekstrakulikuler.siswa_id')
                    ->join('ekskul', 'anggota_ekstrakulikuler.ekskul_id', '=', 'ekskul.id')
                    ->join('absensi', 'siswa.id', '=', 'absensi.siswa_id')
                    ->join('kepribadian', 'siswa.id', '=', 'kepribadian.siswa_id')
                    ->orderBy('mata_pelajaran.nama_mata_pelajaran', 'ASC')
                    ->orderBy('ekskul.nama_ekskul', 'ASC')
                    ->get();

        for($i=0; $i<count($exportRapot); $i++){
            $exportRapot = new ExportRapot();

            $exportRapot->nama_siswa = $rapot->nama_siswa;
            $exportRapot->nis = $rapot->nama_siswa;
            $exportRapot->nisn = $rapot->nama_siswa;
            $exportRapot->nama_mata_pelajaran = $rapot->nama_siswa;
            $exportRapot->np_ph1 = $rapot->np_ph1;
            $exportRapot->np_ph2 = $rapot->np_ph2;
            $exportRapot->nk_ph1 = $rapot->nk_ph1;
            $exportRapot->nk_ph2 = $rapot->nk_ph2;
            $exportRapot->nt_ph1 = $rapot->nt_ph1;
            $exportRapot->nt_ph2 = $rapot->nt_ph2;
            $exportRapot->np_pts = $rapot->np_pts;
            $exportRapot->nk_pts = $rapot->nk_pts;
            $exportRapot->nt_pts = $rapot->nt_pts;
            $exportRapot->nama_ekskul = $rapot->nama_ekskul;
            $exportRapot->sakit = $rapot->namasakit_siswa;
            $exportRapot->izin = $rapot->izin;
            $exportRapot->tanpa_alasan = $rapot->tanpa_alasan;
            $exportRapot->sikap_spiritual = $rapot->sikap_spiritual;
            $exportRapot->kerajinan = $rapot->kerajinan;
            $exportRapot->kerapihan = $rapot->kerapihan;
            $exportRapot->kebersihan = $rapot->kebersihan;
            $exportRapot->cttn_walikelas = $rapot->cttn_walikelas;

            $exportRapot->save();
        }
            
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Export Rapot By Siswa',
            'data' => [
                'user' => $exportRapot,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');   
    }

    public function exportRapotByMapel($mapel_id)
    {
        $rapot = DB::table('pembelajaran')
        ->select('siswa.nama_siswa', 'siswa.nis', 'siswa.nisn', 'mata_pelajaran.nama_mata_pelajaran',
                    'nilai_pengetahuan.ph1 as np_ph1', 'nilai_pengetahuan.ph2 as np_ph2',
                    'nilai_keterampilan.ph1 as nk_ph1', 'nilai_keterampilan.ph2 as nk_ph2',
                    'nilai_tugas.ph1 as nt_ph1', 'nilai_tugas.ph2 as nt_ph2',
                    'nilai_pengetahuan.np_pts', 'nilai_keterampilan.nk_pts', 'nilai_tugas.nt_pts',
                    'ekskul.nama_ekskul', 'absensi.sakit', 'absensi.izin', 'absensi.tanpa_alasan',
                    'kepribadian.sikap_spiritual', 'kepribadian.kerajinan', 'kepribadian.kerapihan',
                    'kepribadian.kebersihan', 'kepribadian.cttn_walikelas')
        ->where('pembelajaran.mata_pelajaran_id', $mapel_id)
        ->join('mata_pelajaran', 'pembelajaran.mata_pelajaran_id', '=', 'mata_pelajaran.id')
        ->join('nilai_pengetahuan', 'pembelajaran.nilai_pengetahuan_id', '=', 'nilai_pengetahuan.id')
        ->join('nilai_keterampilan', 'pembelajaran.nilai_keterampilan_id', '=', 'nilai_keterampilan.id')
        ->join('nilai_tugas', 'pembelajaran.nilai_tugas_id', '=', 'nilai_tugas.id')
        ->join('siswa', 'pembelajaran.siswa_id', '=', 'siswa.id')
        ->join('anggota_ekstrakulikuler', 'siswa.id', '=', 'anggota_ekstrakulikuler.siswa_id')
        ->join('ekskul', 'anggota_ekstrakulikuler.ekskul_id', '=', 'ekskul.id')
        ->join('absensi', 'siswa.id', '=', 'absensi.siswa_id')
        ->join('kepribadian', 'siswa.id', '=', 'kepribadian.siswa_id')
        ->orderBy('mata_pelajaran.nama_mata_pelajaran', 'ASC')
        ->orderBy('ekskul.nama_ekskul', 'ASC')
        ->get();

        for($i=0; $i<count($exportRapot); $i++){
            $exportRapot = new ExportRapot();

            $exportRapot->nama_siswa = $rapot->nama_siswa;
            $exportRapot->nis = $rapot->nama_siswa;
            $exportRapot->nisn = $rapot->nama_siswa;
            $exportRapot->nama_mata_pelajaran = $rapot->nama_siswa;
            $exportRapot->np_ph1 = $rapot->np_ph1;
            $exportRapot->np_ph2 = $rapot->np_ph2;
            $exportRapot->nk_ph1 = $rapot->nk_ph1;
            $exportRapot->nk_ph2 = $rapot->nk_ph2;
            $exportRapot->nt_ph1 = $rapot->nt_ph1;
            $exportRapot->nt_ph2 = $rapot->nt_ph2;
            $exportRapot->np_pts = $rapot->np_pts;
            $exportRapot->nk_pts = $rapot->nk_pts;
            $exportRapot->nt_pts = $rapot->nt_pts;
            $exportRapot->nama_ekskul = $rapot->nama_ekskul;
            $exportRapot->sakit = $rapot->namasakit_siswa;
            $exportRapot->izin = $rapot->izin;
            $exportRapot->tanpa_alasan = $rapot->tanpa_alasan;
            $exportRapot->sikap_spiritual = $rapot->sikap_spiritual;
            $exportRapot->kerajinan = $rapot->kerajinan;
            $exportRapot->kerapihan = $rapot->kerapihan;
            $exportRapot->kebersihan = $rapot->kebersihan;
            $exportRapot->cttn_walikelas = $rapot->cttn_walikelas;

            $exportRapot->save();
        }

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Export Rapot By Mata Pelajaran',
            'data' => [
                'user' => $exportRapot,
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