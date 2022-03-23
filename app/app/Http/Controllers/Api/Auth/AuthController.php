<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;
use JWTAuth;

class AuthController extends Controller
{
    public function login(Request $request){
        $credentials = $request->only('username', 'password');

        if($token = JWTAuth::attempt($credentials)){
            $user = User::find(Auth::user()->userID);
            return response()->json([
                'status'=>'Login Berhasil',
                'user'=> $user,
                'token' => $token
            ], 200);
        }
        return response()->json([
            'error' => 'Login Gagal! Username / Password Salah'
        ],401);
    }

    public function logout(){
        auth()->logout();
        return response()->json([
            'status' => 'Logout Berhasil'
        ]);
    }

    public function getUserLogin(){
        if($user = JWTAuth::parseToken()->authenticate()){
            return response()->json([
                'status' => "Anda Telah Login",
                'user' => $user
            ],200);
        }
    }
    public function refresh(){
        $refreshed = JWTAuth::refresh(JWTAuth::getToken());
        return response()->json([
            'status' => "Anda Telah Login",
            'token' => $refreshed
        ],200);
    }

    private function guard(){
        return Auth::guard();
    }
}
