<?php

namespace App\Http\Controllers;

use App\Models\Users; //File Model
use App\Models\Guru; //File Model
use Spatie\QueryBuilder\AllowedFilter;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Contracts\Auth\Factory as Auth;


class AuthController extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;
    
    public function login(Request $request)
    {        
        $username = $request->input("username");
        $password = $request->input("password");
        if ($users = Users::where("username", $username)->first()){
            // if (Hash::check($password, $users->password)) {
            if ($password = $users->password) {
                $apiToken = base64_encode(Str::random(32));

                $users->api_token = $apiToken;
                $users->save();

                $users = DB::table('users')
                        ->select('users.id', 'gurus.kd_guru', 'gurus.nama_guru', 'users.username', 'users.lvl_akses', 'users.enable_flag', 'users.api_token')
                        ->where('users.username', '=', $username)
                        ->join('gurus', 'users.guru_id', '=', 'gurus.id')
                        ->get();

                return response()->json([
                    'success' => true,
                    'message' => 'Login Success!',
                    'data' => [
                        'user' => $users,
                        'api_token' => $apiToken
                    ],
                ],201)
                ->header('Access-Control-Allow-Origin', '*');
            }
        }
    }

    public function loginNew(Request $request)
    {        
        $username = $request->input("username");
        $password = $request->input("password");
        if ($guru = Guru::where("username", $username)->first()){
            // if (Hash::check($password, $users->password)) {
            if ($password = $guru->password) {
                $apiToken = base64_encode(Str::random(32));

                $guru->api_token = $apiToken;
                $guru->save();

                return response()->json([
                    'success' => true,
                    'message' => 'Login Success!',
                    'data' => [
                        'user' => $guru,
                        'api_token' => $apiToken
                    ],
                ],201)
                ->header('Access-Control-Allow-Origin', '*');
            }
        }
    }

    public function logout(Request $request)
    {
        $users = Guru::where('api_token')->first();
     
        if ($users) {
            $users-> api_token = null;
            $users->save();
        }

        return response()->json(['data' => 'User logged out.'], 200)
                         ->header('Access-Control-Allow-Origin',  '*');
    }
}