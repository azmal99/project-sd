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
{
    /**
    * @return \Illuminate\Support\Collection
    */

    use Exportable;
    public function collection()
    {
        //
        // return Siswa::all();
        $exportRapot = DB::table('siswa')
                    ->select(DB::raw('distinct mata_pelajaran.nama_mata_pelajaran, 
                            mata_pelajaran.kd_mata_pelajaran,
                            siswa.nama_siswa, 
                            siswa.nis, 
                            siswa.nisn, 
                            nilai_pengetahuan.ph1, 
                            nilai_pengetahuan.ph2,
                            nilai_keterampilan.ph1, 
                            nilai_keterampilan.ph2,
                            nilai_tugas.ph1, 
                            nilai_tugas.ph2,
                            nilai_pengetahuan.pts, 
                            nilai_keterampilan.pts, 
                            nilai_tugas.pts,
                            ekskul.nama_ekskul, 
                            anggota_ekstrakulikuler.nilai_ekskul, 
                            absensi.sakit, 
                            absensi.izin, 
                            absensi.tanpa_alasan, 
                            kepribadian.sikap_spiritual, 
                            kepribadian.kerapihan, 
                            kepribadian.kebersihan, 
                            kepribadian.kerajinan, 
                            kepribadian.cttn_walikelas, 
                            tahun_ajaran.tahun_ajar, 
                            tahun_ajaran.semester'))
                    ->join('nilai_pengetahuan', 'siswa.id', '=', 'nilai_pengetahuan.siswa_id')
                    ->join('nilai_tugas', 'siswa.id', '=', 'nilai_tugas.siswa_id')
                    ->join('mata_pelajaran', 'nilai_pengetahuan.mapel_id', '=', 'mata_pelajaran.id')
                    ->join('nilai_keterampilan', 'mata_pelajaran.id', '=', 'nilai_keterampilan.siswa_id')
                    ->join('kelas', 'siswa.kelas_id', '=', 'kelas.id')
                    ->join('tahun_ajaran', 'siswa.tahun_ajar_id', '=', 'tahun_ajaran.id')
                    ->join('anggota_ekstrakulikuler', 'siswa.id', '=', 'anggota_ekstrakulikuler.siswa_id')
                    ->join('ekskul', 'anggota_ekstrakulikuler.ekskul_id', '=', 'ekskul.id')
                    ->join('absensi', 'siswa.id', '=', 'absensi.siswa_id')
                    ->join('kepribadian', 'siswa.id', '=', 'kepribadian.siswa_id')
                    ->orderBy('mata_pelajaran.kd_mata_pelajaran', 'ASC')
                    ->orderBy('siswa.id', 'ASC')
                    ->get();

        return $exportRapot;

        return $exportRapot;
    }

    public function headings(): array
    {
        return ["Mata pelajaran", 
                "KD Mata Pelajaran", 
                "Nama Siswa", 
                "NIS", 
                "NISN",
                "Nilai Pengetahaun PH1", 
                "Nilai Pengetahaun PH2", 
                "Nilai Keterampilan PH1", 
                "Nilai Keterampilan PH2", 
                "Nilai Tugas PH1", 
                "Nilai Tugas PH2", 
                "Nilai Pengetahuan PTS",
                "Nilai Keterampilan PTS", 
                "Nilai Tugas PTS", 
                "Ekstrakulikuler", 
                "Nilai",
                "Sakit", 
                "Izin", 
                "Tanpa Alasan", 
                "Sikap Spiritual", 
                "Kerapihan",
                "Kebersihan", 
                "kerajinan", 
                "Catatan Wali Kelas",
                "Tahun Ajaran", 
                "Semester"];
    }
}
