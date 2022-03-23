<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Director;

class DirectorController extends Controller
{
    public function showDirector(){
        try{
            $directors = Director::with('emitenData', 'emitenData.emiten', 'emitenData.emiten.subsector', 'emitenData.emiten.subsector.sector', 'emitenData.quartal', 'emitenData.year', 'rasio')->get();
            return response()->json([
                'status' => 'Director Data',
                'directors' => $directors
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Director Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createDirector(Request $request){
        try{
            $directors = new Director;
            $directors->directorID = $directors->getDirectorID();
            $directors->emitenDataID = $request->emitenDataID;
            $directors->rasioID = $request->rasioID;
            $directors->directorName = $request->directorName;
            $directors->ownershipEmiten = $request->ownershipEmiten;
            $directors->save();

            $directorsDataLengkap = $this->getDirectorData($directors->directorID);
            return response()->json([
                'status' => "Direktur Data ". $directorsDataLengkap[0]->emitenData->emiten->emitenKode ." Tersimpan",
                'financials' => $directorsDataLengkap
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Direktur Data Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function updateDirector(Request $request){
        try{
            $directors = Director::where('directorID', $request->directorID)->firstOrFail();
            $directors->emitenDataID = $request->emitenDataID;
            $directors->rasioID = $request->rasioID;
            $directors->directorName = $request->directorName;
            $directors->ownershipEmiten = $request->ownershipEmiten;
            $directors->save();

            $directorsDataLengkap = $this->getDirectorData($directors->directorID);
            return response()->json([
                'status' => "Direktur Data ". $directorsDataLengkap[0]->emitenData->emiten->emitenKode ." Tersimpan",
                'financials' => $directorsDataLengkap
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Direktur Data Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function deleteDirector(Request $request){
        try{
            $directors = Director::where('directorID', $request->directorID)->firstOrFail();
            $directorsDataLengkap = $this->getDirectorData($directors->directorID);
            $directors->delete();
            
            return response()->json([
                'status' => "Direktur Data ". $directorsDataLengkap[0]->emitenData->emiten->emitenKode ." Terhapus",
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Direktur Data Gagal Terhapus',
                'info' => $e
            ],503);
        }
    }

    private function getDirectorData($directorID){
        try{
            return Director::with('emitenData', 'emitenData.emiten', 'emitenData.emiten.subsector', 'emitenData.emiten.subsector.sector', 'emitenData.quartal', 'emitenData.year', 'rasio')->where('directorID', $directorID)->firstOrFail();
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Direktur Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
}
