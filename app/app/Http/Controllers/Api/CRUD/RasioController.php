<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Rasio;

class RasioController extends Controller
{
    public function showRasio(){
        try{
            $rasioes = Rasio::all();
            return response()->json([
                'status' => 'Data Rasio',
                'rasioes' => $rasioes
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Rasio Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function showRasioPage(Request $request){
        try{
            $rasioes = Rasio::skip($request->firstPage)
                ->take($request->lastPage)
                ->where('rasioName','like',"%$request->searchRasio%")
                ->get();
            $rasioCount = Rasio::where('rasioName','like',"%$request->searchRasio%")->count();

            return response()->json([
                'status' => 'Data Rasio',
                'rasioes' => $rasioes,
                'rasioCount' =>  $rasioCount
            ],200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Rasio Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createRasio(Request $request){
        try{
            $rasio = new Rasio;
            $rasio->rasioID = $rasio->getRasioID();
            $rasio->rasioName = $request->rasioName;
            $rasio->note = $request->note;
            $rasio->isOwner = $request->isOwner;
            if($request->isFinancial){
                $rasio->isFinancial = $request->isFinancial;
                $rasio->isNeraca = $request->isNeraca;
                $rasio->isLabaRugi = $request->isLabaRugi;
                $rasio->isCashFlow = $request->isCashFlow;
                $rasio->isCFO = $request->isCFO;
                $rasio->isCFI = $request->isCFI;
                $rasio->isCFF = $request->isCFF;
                $rasio->isPBV = $request->isPBV;
                $rasio->isPER = $request->isPER;
                $rasio->isEPS = $request->isEPS;
                $rasio->isROE = $request->isROE;
                $rasio->isGPM = $request->isGPM;
                $rasio->isNPM = $request->isNPM;
                $rasio->isDER = $request->isDER;
                $rasio->isTax = $request->isTax;
                $rasio->isBVPS = $request->isBVPS;
                $rasio->isCurrentRatio = $request->isCurrentRatio;
                $rasio->isQuickRatio = $request->isQuickRatio;
                $rasio->isNWC = $request->isNWC;
            }
            $rasio->save();
            return response()->json([
                'status' => "Data Rasio $rasio->rasioName Tersimpan",
                'rasioes' => $rasio
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Rasio Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function updateRasio(Request $request){
        try{
            $rasio = Rasio::where('rasioID',$request->rasioID)->firstOrFail();
            $rasio->rasioName = $request->rasioName;
            $rasio->note = $request->note;
            $rasio->isOwner = $request->isOwner;
            if($request->isFinancial){
                $rasio->isFinancial = $request->isFinancial;
                $rasio->isNeraca = $request->isNeraca;
                $rasio->isLabaRugi = $request->isLabaRugi;
                $rasio->isCashFlow = $request->isCashFlow;
                $rasio->isCFO = $request->isCFO;
                $rasio->isCFI = $request->isCFI;
                $rasio->isCFF = $request->isCFF;
                $rasio->isPBV = $request->isPBV;
                $rasio->isPER = $request->isPER;
                $rasio->isEPS = $request->isEPS;
                $rasio->isROE = $request->isROE;
                $rasio->isGPM = $request->isGPM;
                $rasio->isNPM = $request->isNPM;
                $rasio->isDER = $request->isDER;
                $rasio->isTax = $request->isTax;
                $rasio->isBVPS = $request->isBVPS;
                $rasio->isCurrentRatio = $request->isCurrentRatio;
                $rasio->isQuickRatio = $request->isQuickRatio;
                $rasio->isNWC = $request->isNWC;
            }
            $rasio->save();
            return response()->json([
                'status' => "Data Rasio $rasio->rasioName Tersimpan",
                'rasioes' => $rasio
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Rasio Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function deleteRasio(Request $request){
        try{
            $rasio = Rasio::where('rasioID',$request->rasioID)->firstOrFail();
            $rasioName = $rasio->rasioName;
            $rasio->delete();

            return response()->json([
                'status' => "Data Rasio $rasioName Terhapus"
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Rasio Gagal Terhapus',
                'info' => $e
            ],503);
        }
    }
}
