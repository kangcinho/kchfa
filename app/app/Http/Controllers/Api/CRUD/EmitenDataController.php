<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\EmitenData;

class EmitenDataController extends Controller
{
    public function showEmitenData(){
        try{
            $emitenDatas = EmitenData::with('emiten', 'emiten.subsector', 'emiten.subsector.sector', 'quartal', 'year')->get();
            return response()->json([
                'status' => 'Emiten Data',
                'emitenDatas' => $emitenDatas
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Emiten Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createEmitenData(Request $request){
        try{
            if($request->isAktif == 1 || $request->isAktif == 'true' || $request->isAktif == true ){
                $this->setNonAktifEmiten($request->emitenID);
            }
            $emitenData = new EmitenData;
            $emitenData->emitenDataID = $emitenData->getEmitenDataID();
            $emitenData->emitenID = $request->emitenID;
            $emitenData->quartalID = $request->quartalID;
            $emitenData->emitenPrice = $request->emitenPrice;
            $emitenData->yearID = $request->yearID;
            $emitenData->isAktif = $request->isAktif;
            $emitenData->save();

            $emitenDataLengkap = $this->getEmitenData($emitenData->emitenDataID);
            return response()->json([
                'status' => "Emiten Data ". $emitenDataLengkap[0]->emiten->emitenKode ." Tersimpan",
                'emitenDatas' => $emitenDataLengkap
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Emiten Data Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function updateEmitenData(Request $request){
        try{
            if($request->isAktif == 1 || $request->isAktif == 'true' || $request->isAktif == true ){
                $this->setNonAktifEmiten($request->emitenID);
            }
            $emitenData = EmitenData::where('emitenDataID', $request->emitenDataID)->firstOrFail();
            $emitenData->emitenID = $request->emitenID;
            $emitenData->quartalID = $request->quartalID;
            $emitenData->emitenPrice = $request->emitenPrice;
            $emitenData->yearID = $request->yearID;
            $emitenData->isAktif = $request->isAktif;
            $emitenData->save();

            $emitenDataLengkap = $this->getEmitenData($emitenData->emitenDataID);
            return response()->json([
                'status' => "Emiten Data ". $emitenDataLengkap[0]->emiten->emitenKode ." Tersimpan",
                'emitenDatas' => $emitenDataLengkap
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Emiten Data Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function deleteEmitenData(Request $request){
        try{
            $emitenData = EmitenData::where('emitenDataID', $request->emitenDataID)->firstOrFail();
            $emitenDataLengkap = $this->getEmitenData($emitenData->emitenDataID);
            $emitenData->delete();
            
            return response()->json([
                'status' => "Emiten Data ". $emitenDataLengkap[0]->emiten->emitenKode ." Terhapus",
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Emiten Data Gagal Terhapus',
                'info' => $e
            ],503);
        }
    }

    public function changePriceEmitenData(Request $request){
        try{
            $emitenData = EmitenData::where('emitenDataID', $request->emitenDataID)->firstOrFail();
            $emitenData->emitenPrice = $request->emitenPrice;
            $emitenData->save();

            $emitenDataLengkap = $this->getEmitenData($emitenData->emitenDataID);
            return response()->json([
                'status' => "Emiten Data ". $emitenDataLengkap[0]->emiten->emitenKode ." Tersimpan",
                'emitenDatas' => $emitenDataLengkap
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Emiten Data Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    private function setNonAktifEmiten($emitenID){
        \DB::statement("UPDATE emiten_datas SET isAktif = 0 WHERE emitenID ='$emitenID'");
    }
    private function getEmitenData($emitenDataID){
        try{
            return EmitenData::with('emiten', 'emiten.subsector', 'emiten.subsector.sector', 'quartal', 'year')->where('emitenDataID', $emitenDataID)->firstOrFail();
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Emiten Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
}
