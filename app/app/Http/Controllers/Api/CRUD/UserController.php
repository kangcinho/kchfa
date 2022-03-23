<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\User;

class UserController extends Controller
{
    public function showUser(){
        try{
            $users = User::all();
            return response()->json([
                'status' => 'Data User',
                'users' => $users
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data User Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
    public function createUser(Request $request){
        try{
            $user = new User;
            $user->userID = $user->getUserID();
            $user->username = $request->username;
            $user->name = $request->name;
            $user->password = bcrypt($request->password);
            $user->isAdmin = $request->isAdmin;
            $user->isMaster = $request->isMaster;
            $user->isFA = $request->isFA;
            $user->isCreate = $request->isCreate;
            $user->isUpdate = $request->isUpdate;
            $user->isDelete = $request->isDelete;
            $user->save();
            return response()->json([
                'status' => "Data User $user->username Berhasil Tersimpan!",
                'users' => $user
            ], 200);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data User Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
    public function updateUser(Request $request){
        try{
            $user = User::where('userID', $request->userID)->firstOrFail();
            $user->username = $request->username;
            $user->name = $request->name;
            $user->isAdmin = $request->isAdmin;
            $user->isMaster = $request->isMaster;
            $user->isFA = $request->isFA;
            $user->isCreate = $request->isCreate;
            $user->isUpdate = $request->isUpdate;
            $user->isDelete = $request->isDelete;
            $user->save();
            return response()->json([
                'status' => "Data User $user->username Berhasil Tersimpan!",
                'users' => $user
            ], 200);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data User Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
    public function deleteUser(Request $request){
        try{
            $user = User::where('userID', $request->userID)->firstOrFail();
            $status = "Data User $user->username Berhasil Dihapus";
            $user->delete();
            return response()->json([
                'status' => $status,
                'users' => $user
            ], 200);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data User Gagal Dihapus',
                'info' => $e
            ],503);
        }
    }   
}
