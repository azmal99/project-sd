<?php

namespace App\Http\Controllers;

use App\Models\Guru; //File Model
use App\Exceptions\Handler; //Error Handle
use Ramsey\Uuid\Uuid;
use Ramsey\Uuid\Exception\UnsatisfiedDependencyException;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Carbon\Carbon;

class GuruController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    //List Guru
    public function index()
    {
        $guru = Guru::all();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Menampilkan Semua Data Guru',
            'data' => [
                'user' => $guru,
            ],
        ], 200)
        ->header('Access-Control-Allow-Origin', '*');
    }


    public function show($id)
    {
        $guru = Guru::where('id', $id)->first();
        return response()->json([
            'success' => true,
            'message' => 'Berhasil Show Guru',
            'data' => [
                'user' => $guru,
            ],
        ],200)
        ->header('Access-Control-Allow-Origin', '*');
    }

    //CREATE
    public function store(Request $request)
    {
        $guru = new Guru();
        $randomId = rand(1,9999999);
        $guru->id = $randomId;
        $guru->kd_guru = ($request->input('kd_guru'));
        $guru->nama_guru = ($request->input('nama_guru'));
        $guru->username = ($request->input('username'));
        $guru->password = ($request->input('password'));
        $guru->lvl_akses = ($request->input('lvl_akses'));
        $guru->enable_flag = ($request->input('enable_flag'));
        $guru->jns_kelamin = ($request->input('jns_kelamin'));
        $guru->tempat_lahir = ($request->input('tempat_lahir'));
        $tgl_lahir = ($request->input('tgl_lahir'));
        $guru->tgl_lahir = Carbon::createFromFormat('m/d/Y', $tgl_lahir)->format('Y-m-d');
        $guru->alamat = ($request->input('alamat'));
        
        $guru_store = $guru->save();
        if($guru_store = true){
            return response()->json([
                'success' => true,
                'message' => 'Berhasil Tambah Guru',
                'data' =>[
                    'user' => $guru,
                    ],
            ], 201)
            ->header('Access-Control-Allow-Origin', '*');
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Gagal Tambah Guru',
            ], 500)
            ->header('Access-Control-Allow-Origin', '*');
        }
        
    }

    // UPDATE
    public function update(Request $request, $id)
    {
        $guru = Guru::find($id)->update($request->all()); 

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Update Guru',
            'data' => [
                'user' => $guru,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // DELETE
    public function delete($id)
    {
        $guru = Guru::where('id', '=',  $id)->first();
        $guru->enable_flag = 'N';
        $guru->save();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Delete Guru',
            'data' => [
                'user' => $guru,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    // HARD DELETE
    public function hardDelete($id)
    {
        $guru = Guru::where('id', '=',  $id)->first();
        $guru->delete();

        return response()->json([
            'success' => true,
            'message' => 'Berhasil Hard Delete Guru',
            'data' => [
                'user' => $guru,
            ],
        ],201)
        ->header('Access-Control-Allow-Origin', '*');
    }

    public function receiveInformation(Request $request) {
        if(Response::ajax()) return "OK";
    }

}