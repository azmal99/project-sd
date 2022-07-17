<?php

namespace App\Exports;

use App\Models\Rapot; //File Model
use App\Models\Siswa; //File Model
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\FromCollection;

class RapotExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        //
        // return ExportRaport::all();
        $exportRapot = DB::table('pembelajaran')
                    ->select('siswa.nama_siswa', 'siswa.nis', 'siswa.nisn', 'mata_pelajaran.nama_mata_pelajaran',
                             'nilai_pengetahuan.ph1 as np_ph1', 'nilai_pengetahuan.ph2 as np_ph2',
                             'nilai_keterampilan.ph1 as nk_ph1', 'nilai_keterampilan.ph2 as nk_ph2',
                             'nilai_tugas.ph1 as nt_ph1', 'nilai_tugas.ph2 as nt_ph2',
                             'nilai_pengetahuan.pts', 'nilai_keterampilan.pts', 'nilai_tugas.pts',
                             'ekskul.nama_ekskul', 'absensi.sakit', 'absensi.izin', 'absensi.tanpa_alasan',
                             'kepribadian.sikap_spiritual', 'kepribadian.kerajinan', 'kepribadian.kerapihan',
                             'kepribadian.kebersihan', 'kepribadian.cttn_walikelas')
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
        
        return $exportRapot;
    }
}
