<?php

namespace App\Http\Controllers;

use App\Models\Rapot; //File Model
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;

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

    //CREATE
    public function store(Request $request)
    {
        $rapot = new Rapot();
        $randomId = rand(1,99);
        $rapot->id = $randomId;
        $rapot->siswa_id = ($request->input('siswa_id'));
        $rapot->kelas_id = ($request->input('kelas_id'));
        $rapot->mata_pelajaran_id = ($request->input('mata_pelajaran_id'));
        $rapot->ekskul_id = ($request->input('ekskul_id'));
        $rapot->kriteria_kelulusan = ($request->input('keriteria_kelulusan'));
        $rapot->enable_flag = ($request->input('enable_flag'));
        $rapot->tahuan_ajar_id = ($request->input('tahuan_ajar_id'));
        
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