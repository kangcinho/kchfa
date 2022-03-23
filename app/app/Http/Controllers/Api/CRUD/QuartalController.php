<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Quartal;

class QuartalController extends Controller
{
    public function showQuartal(){
        try{
            $quartals = Quartal::all();
            return response()->json([
                'status' => 'Data Quartal',
                'quartals' => $quartals
            ], 200);

        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Quartal Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createQuartal(Request $request){
        try{
            $quartal = new Quartal;
            $quartal->quartalID = $quartal->getQuartalID();
            $quartal->quartalName = $request->quartalName;
            $quartal->quartalCalculate = $request->quartalCalculate;
            $quartal->save();

            return response()->json([
                'status' => "Data Quartal $quartal->quartalName Tersimpan",
                'quartals' => $quartal
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Quartal Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function updateQuartal(Request $request){
        try{
            $quartal = Quartal::where('quartalID', $request->quartalID)->firstOrFail();
            $quartal->quartalName = $request->quartalName;
            $quartal->quartalCalculate = $request->quartalCalculate;
            $quartal->save();

            return response()->json([
                'status' => "Data Quartal $quartal->quartalName Tersimpan",
                'quartals' => $quartal
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Quartal Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function deleteQuartal(Request $request){
        try{
            $quartal = Quartal::where('quartalID', $request->quartalID)->firstOrFail();
            $quartalName = $quartal->quartalName;
            $quartal->delete();
            
            return response()->json([
                'status' => "Data Quartal $quartalName Terhapus",
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Quartal Gagal Terhapus',
                'info' => $e
            ],503);
        }
    }
}
