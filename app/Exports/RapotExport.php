<?php

namespace App\Exports;

use App\Models\Rapot; //File Model
use App\Models\ExportRapot; //File Model
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\WithHeadings;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use PhpOffice\PhpSpreadsheet\Style\NumberFormat;

class RapotExport implements FromCollection, WithHeadings
// class RapotExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    public function collection()
    {
        //
        // return Siswa::all();
        $exportRapot = DB::table('pembelajaran')
                    ->select('mata_pelajaran.nama_mata_pelajaran', 'mata_pelajaran.kd_mata_pelajaran',
                             'siswa.nama_siswa', 'siswa.nis', 'siswa.nisn', 
                             'nilai_pengetahuan.ph1 as np_ph1', 'nilai_pengetahuan.ph2 as np_ph2',
                             'nilai_keterampilan.ph1 as nk_ph1', 'nilai_keterampilan.ph2 as nk_ph2',
                             'nilai_tugas.ph1 as nt_ph1', 'nilai_tugas.ph2 as nt_ph2',
                             'nilai_pengetahuan.pts', 'nilai_keterampilan.pts', 'nilai_tugas.pts',
                             'ekskul.nama_ekskul', 'anggota_ekstrakulikuler.nilai_ekskul', 'absensi.sakit', 'absensi.izin', 
                             'absensi.tanpa_alasan', 'kepribadian.sikap_spiritual', 'kepribadian.kebersihan', 
                             'kepribadian.cttn_walikelas', 'tahun_ajaran.tahun_ajar', 'tahun_ajaran.semester')
                    ->join('siswa', 'pembelajaran.siswa_id', '=', 'siswa.id')
                    ->join('mata_pelajaran', 'pembelajaran.mapel_id', '=', 'mata_pelajaran.id')
                    ->join('kelas', 'pembelajaran.kelas_id', '=', 'kelas.id')
                    ->join('nilai_pengetahuan', 'pembelajaran.np_id', '=', 'nilai_pengetahuan.id')
                    ->join('nilai_keterampilan', 'pembelajaran.nk_id', '=', 'nilai_keterampilan.id')
                    ->join('nilai_tugas', 'pembelajaran.nt_id', '=', 'nilai_tugas.id')
                    ->join('tahun_ajaran', 'pembelajaran.tahun_ajar_id', '=', 'tahun_ajaran.id')
                    ->join('absensi', 'siswa.id', '=', 'absensi.siswa_id')
                    ->join('kepribadian', 'siswa.id', '=', 'kepribadian.siswa_id')
                    ->join('anggota_ekstrakulikuler', 'siswa.id', '=', 'anggota_ekstrakulikuler.siswa_id')
                    ->join('ekskul', 'anggota_ekstrakulikuler.ekskul_id', '=', 'ekskul.id')
                    ->orderBy('mata_pelajaran.kd_mata_pelajaran', 'ASC')
                    ->orderBy('siswa.id', 'ASC')
                    ->get();

        return $exportRapot;

        // $exportRapot = DB::table('siswa as sw', 'mata_pelajaran as mpl', 'nilai_pengetahuan as np',
        //                          'nilai_keterampilan as nk', 'nilai_tugas as nk', 'tahun_ajaran as thj',
        //                          'absensi as abs', 'kepribadian as kpb', 'ekskul as eks', 'anggota_ekstrakulikuler as ang')
        //             ->select('mpl.nama_mata_pelajaran', 'mpl.kd_mata_pelajaran',
        //                      'sw.nama_siswa', 'sw.nis', 'sw.nisn', 
        //                      'np.ph1 as np_ph1', 'np.ph2 as np_ph2',
        //                      'nk.ph1 as nk_ph1', 'nk.ph2 as nk_ph2',
        //                      'nt.ph1 as nt_ph1', 'nt.ph2 as nt_ph2',
        //                      'np.pts', 'nk.pts', 'nt.pts',
        //                      'eks.nama_ekskul', 'ang.nilai_ekskul', 'abs.sakit', 'abs.izin', 
        //                      'abs.tanpa_alasan', 'kpb.sikap_spiritual', 'kpb.kebersihan', 
        //                      'kpb.cttn_walikelas', 'thj.tahun_ajar', 'thj.semester')
        //             ->where('mpl.id', '=', 'np.mapel_id')
        //             ->where('mpl.id', '=', 'nk.mapel_id')
        //             ->where('mpl.id', '=', 'nt.mapel_id')
        //             ->where('sw.id', '=', 'np.siswa_id')
        //             ->where('sw.id', '=', 'nk.siswa_id')
        //             ->where('sw.id', '=', 'nt.siswa_id')
        //             ->where('thj.id', '=', 'np.tahun_ajar_id')
        //             ->where('thj.id', '=', 'nk.tahun_ajar_id')
        //             ->where('thj.id', '=', 'nt.tahun_ajar_id')
        //             ->where('abs.siswa_id', '=', 'sw.id')
        //             ->where('kpb.siswa_id', '=', 'sw.id')
        //             ->orderBy('mpl.kd_mata_pelajaran', 'ASC')
        //             ->orderBy('sw.id', 'ASC')
        //             ->get();

        // return $exportRapot;
    }

    public function headings(): array
    {
        return ["Mata pelajaran", "KD Mata Pelajaran", "Nama Siswa", "NIS", "NISN",
                "Nilai Pengetahaun PH1", "Nilai Pengetahaun PH2", "Nilai Keterampilan PH1", 
                "Nilai Keterampilan PH2", "Nilai Tugas PH1", "Nilai Tugas PH2", "Nilai Pengetahuan PTS",
                "Nilai Keterampilan PTS", "Nilai Tugas PTS", "Ekstrakulikuler", "Nilai",
                "Sakit", "Izin", "Tanpa Alasan", "Sikap Spiritual", "Kerapihan","Kebersihan", "Kerapihan", "Catatan Wali Kelas",
                "Tahun Ajaran", "Semester"];
    }
}
