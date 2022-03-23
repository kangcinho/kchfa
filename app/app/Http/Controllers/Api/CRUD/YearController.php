<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Year;

class YearController extends Controller
{
    public function showYear(){
        try{
            $years = Year::all();
            return response()->json([
                'status' => 'Data Year',
                'years' => $years
            ], 200);

        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Year Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createYear(Request $request){
        try{
            $year = new Year;
            $year->yearID = $year->getYearID();
            $year->yearName = $request->yearName;
            $year->save();

            return response()->json([
                'status' => "Data Year $year->yearName Tersimpan",
                'years' => $year
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Year Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function updateYear(Request $request){
        try{
            $year = Year::where('yearID', $request->yearID)->firstOrFail();
            $year->yearName = $request->yearName;
            $year->save();

            return response()->json([
                'status' => "Data Year $year->yearName Tersimpan",
                'years' => $year
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Year Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function deleteYear(Request $request){
        try{
            $year = Year::where('yearID', $request->yearID)->firstOrFail();
            $yearName = $year->yearName;
            $year->delete();
            
            return response()->json([
                'status' => "Data Year $yearName Terhapus",
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Year Gagal Terhapus',
                'info' => $e
            ],503);
        }
    }
}
