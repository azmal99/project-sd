<?php

namespace App\Exports;

use App\Models\Rapot; //File Model
use App\Models\ExportRapot; //File Model
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;

class RapotExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    public function collection()
    {
        //
        // return Siswa::all();
        $exportRapot = DB::table('mata_pelajaran')
                    ->select('mata_pelajaran.nama_mata_pelajaran', 'mata_pelajaran.kd_mata_pelajaran',
                             'siswa.nama_siswa', 'siswa.nis', 'siswa.nisn', 
                             'nilai_pengetahuan.ph1 as np_ph1', 'nilai_pengetahuan.ph2 as np_ph2',
                             'nilai_keterampilan.ph1 as nk_ph1', 'nilai_keterampilan.ph2 as nk_ph2',
                             'nilai_tugas.ph1 as nt_ph1', 'nilai_tugas.ph2 as nt_ph2',
                             'nilai_pengetahuan.pts', 'nilai_keterampilan.pts', 'nilai_tugas.pts',
                             'ekskul.nama_ekskul', 'anggota_ekstrakulikuler.nilai_ekskul', 'absensi.sakit', 'absensi.izin', 
                             'absensi.tanpa_alasan', 'kepribadian.sikap_spiritual', 
                             'kepribadian.kerajinan', 'kepribadian.kerapihan',
                             'kepribadian.kebersihan', 'kepribadian.cttn_walikelas')
                    ->join('nilai_pengetahuan', 'mata_pelajaran.id', '=', 'nilai_pengetahuan.mapel_id')
                    ->join('nilai_keterampilan', 'mata_pelajaran.id', '=', 'nilai_keterampilan.mapel_id')
                    ->join('nilai_tugas', 'mata_pelajaran.id', '=', 'nilai_tugas.mapel_id')
                    ->join('siswa', 'nilai_pengetahuan.siswa_id', '=', 'siswa.id')
                    ->join('anggota_ekstrakulikuler', 'siswa.id', '=', 'anggota_ekstrakulikuler.siswa_id')
                    ->join('ekskul', 'anggota_ekstrakulikuler.ekskul_id', '=', 'ekskul.id')
                    ->join('absensi', 'siswa.id', '=', 'absensi.siswa_id')
                    ->join('kepribadian', 'siswa.id', '=', 'kepribadian.siswa_id')
                    ->orderBy('mata_pelajaran.kd_mata_pelajaran', 'ASC')
                    ->orderBy('siswa.id', 'ASC')
                    ->get();

        return $exportRapot;
    }
}
