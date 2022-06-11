<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|å
*/

Route::get('/', function () {
    return view('welcome');
});

//router auth
Route::get('/login', [App\Http\Controllers\AuthController::class, 'login']);
Route::get('/logout/{api_token}', [App\Http\Controllers\AuthController::class, 'logout']);

//router guru
Route::get('/guru/index', [App\Http\Controllers\GuruController::class, 'index']);
Route::get('/guru/show/{id}', [App\Http\Controllers\GuruController::class, 'show']);
Route::post('/guru/store', [App\Http\Controllers\GuruController::class, 'store']);
Route::post('/guru/update/{id}', [App\Http\Controllers\GuruController::class, 'update']);
Route::post('/guru/delete/{id}', [App\Http\Controllers\GuruController::class, 'delete']);
Route::post('/guru/hard-delete/{kd_guru}', [App\Http\Controllers\GuruController::class, 'hardDelete']);
Route::post('/guru/delete-all', [App\Http\Controllers\GuruController::class, 'deleteAll']);

//router user
Route::get('/users/index', [App\Http\Controllers\UsersController::class, 'index']);
Route::get('/users/show/{id}', [App\Http\Controllers\UsersController::class, 'show']);
Route::get('/users/user/{username}', [App\Http\Controllers\UsersController::class, 'showUsers']);
Route::post('/users/store', [App\Http\Controllers\UsersController::class, 'store']);
Route::post('/users/update/{id}', [App\Http\Controllers\UsersController::class, 'update']);
Route::post('/users/delete/{id}', [App\Http\Controllers\UsersController::class, 'delete']);

//router siswa
Route::get('/siswa/index', [App\Http\Controllers\SiswaController::class, 'index']);
Route::get('/siswa/show/{id}', [App\Http\Controllers\SiswaController::class, 'show']);
Route::post('/siswa/store', [App\Http\Controllers\SiswaController::class, 'store']);
Route::post('/siswa/update/{id}', [App\Http\Controllers\SiswaController::class, 'update']);
Route::post('/siswa/delete/{id}', [App\Http\Controllers\SiswaController::class, 'delete']);

//router kelas
Route::get('/kelas/index', [App\Http\Controllers\KelasController::class, 'index']);
Route::get('/kelas/show/{id}', [App\Http\Controllers\KelasController::class, 'show']);
Route::post('/kelas/store', [App\Http\Controllers\KelasController::class, 'store']);
Route::post('/kelas/update/{id}', [App\Http\Controllers\KelasController::class, 'update']);
Route::post('/kelas/delete/{id}', [App\Http\Controllers\KelasController::class, 'delete']);

//router mata pelajaran
Route::get('/mata-pelajaran/index', [App\Http\Controllers\MapelController::class, 'index']);
Route::get('/mata-pelajaran/show/{id}', [App\Http\Controllers\MapelController::class, 'show']);
Route::post('/mata-pelajaran/store', [App\Http\Controllers\MapelController::class, 'store']);
Route::post('/mata-pelajaran/update/{id}', [App\Http\Controllers\MapelController::class, 'update']);
Route::post('/mata-pelajaran/delete/{id}', [App\Http\Controllers\MapelController::class, 'delete']);

//router tahun ajaran
Route::get('/tahun-ajaran/index', [App\Http\Controllers\TahunAjaranController::class, 'index']);
Route::get('/tahun-ajaran/show/{id}', [App\Http\Controllers\TahunAjaranController::class, 'show']);
Route::post('/tahun-ajaran/store', [App\Http\Controllers\TahunAjaranController::class, 'store']);
Route::post('/tahun-ajaran/update/{id}', [App\Http\Controllers\TahunAjaranController::class, 'update']);
Route::post('/tahun-ajaran/delete/{id}', [App\Http\Controllers\TahunAjaranController::class, 'delete']);

//router absensi
Route::get('/absensi/index', [App\Http\Controllers\AbsensiController::class, 'index']);
Route::get('/absensi/show/{id}', [App\Http\Controllers\AbsensiController::class, 'show']);
Route::post('/absensi/store', [App\Http\Controllers\AbsensiController::class, 'store']);
Route::post('/absensi/update/{id}', [App\Http\Controllers\AbsensiController::class, 'update']);
Route::post('/absensi/delete/{id}', [App\Http\Controllers\AbsensiController::class, 'delete']);

//router ekskul
Route::get('/ekstra-kulikuler/index', [App\Http\Controllers\EkskulController::class, 'index']);
Route::get('/ekstra-kulikuler/show/{id}', [App\Http\Controllers\EkskulController::class, 'show']);
Route::post('/ekstra-kulikuler/store', [App\Http\Controllers\EkskulController::class, 'store']);
Route::post('/ekstra-kulikuler/update/{id}', [App\Http\Controllers\EkskulController::class, 'update']);
Route::post('/ekstra-kulikuler/delete/{id}', [App\Http\Controllers\EkskulController::class, 'delete']);

//router pembelajaran
Route::get('/pembelajaran/index', [App\Http\Controllers\PembelajaranController::class, 'index']);
Route::get('/pembelajaran/show/{id}', [App\Http\Controllers\PembelajaranController::class, 'show']);
Route::post('/pembelajaran/store', [App\Http\Controllers\PembelajaranController::class, 'store']);
Route::post('/pembelajaran/update/{id}', [App\Http\Controllers\PembelajaranController::class, 'update']);
Route::post('/pembelajaran/delete/{id}', [App\Http\Controllers\PembelajaranController::class, 'delete']);

//router rapot
Route::get('/rapot/index', [App\Http\Controllers\RapotController::class, 'index']);
Route::get('/rapot/show/{id}', [App\Http\Controllers\RapotController::class, 'show']);
Route::post('/rapot/store', [App\Http\Controllers\RapotController::class, 'store']);
Route::post('/rapot/update/{id}', [App\Http\Controllers\RapotController::class, 'update']);
Route::post('/rapot/delete/{id}', [App\Http\Controllers\RapotController::class, 'delete']);

//router kepribadian
Route::get('/kepribadian/index', [App\Http\Controllers\KepribadianController::class, 'index']);
Route::get('/kepribadian/show/{id}', [App\Http\Controllers\KepribadianController::class, 'show']);
Route::post('/kepribadian/store', [App\Http\Controllers\KepribadianController::class, 'store']);
Route::post('/kepribadian/update/{id}', [App\Http\Controllers\KepribadianController::class, 'update']);
Route::post('/kepribadian/delete/{id}', [App\Http\Controllers\KepribadianController::class, 'delete']);

//router anggota ekskul
Route::get('/anggota-ekskul/index', [App\Http\Controllers\AnggotaEkskulController::class, 'index']);
Route::get('/anggota-ekskul/show/{id}', [App\Http\Controllers\AnggotaEkskulController::class, 'show']);
Route::post('/anggota-ekskul/store', [App\Http\Controllers\AnggotaEkskulController::class, 'store']);
Route::post('/anggota-ekskul/update/{id}', [App\Http\Controllers\AnggotaEkskulController::class, 'update']);
Route::post('/anggota-ekskul/delete/{id}', [App\Http\Controllers\AnggotaEkskulController::class, 'delete']);

//router nilai pengtahuan
Route::get('/nilai-pengetahuan/index', [App\Http\Controllers\NilaiPengetahuanController::class, 'index']);
Route::get('/nilai-pengetahuan/show/{id}', [App\Http\Controllers\NilaiPengetahuanController::class, 'show']);
Route::post('/nilai-pengetahuan/store', [App\Http\Controllers\NilaiPengetahuanController::class, 'store']);
Route::post('/nilai-pengetahuan/update/{id}', [App\Http\Controllers\NilaiPengetahuanController::class, 'update']);
Route::post('/nilai-pengetahuan/delete/{id}', [App\Http\Controllers\NilaiPengetahuanController::class, 'delete']);

//router nilai keterampilan
Route::get('/nilai-keterampilan/index', [App\Http\Controllers\NilaiKeterampilanController::class, 'index']);
Route::get('/nilai-keterampilan/show/{id}', [App\Http\Controllers\NilaiKeterampilanController::class, 'show']);
Route::post('/nilai-keterampilan/store', [App\Http\Controllers\NilaiKeterampilanController::class, 'store']);
Route::post('/nilai-keterampilan/update/{id}', [App\Http\Controllers\NilaiKeterampilanController::class, 'update']);
Route::post('/nilai-keterampilan/delete/{id}', [App\Http\Controllers\NilaiKeterampilanController::class, 'delete']);

//router nilai tugas
Route::get('/nilai-tugas/index', [App\Http\Controllers\NilaiTugasController::class, 'index']);
Route::get('/nilai-tugas/show/{id}', [App\Http\Controllers\NilaiTugasController::class, 'show']);
Route::post('/nilai-tugas/store', [App\Http\Controllers\NilaiTugasController::class, 'store']);
Route::post('/nilai-tugas/update/{id}', [App\Http\Controllers\NilaiTugasController::class, 'update']);
Route::post('/nilai-tugas/delete/{id}', [App\Http\Controllers\NilaiTugasController::class, 'delete']);
