<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Emiten;
use App\Http\Helpers\CurrencySupport;

class EmitenController extends Controller
{
    public function showEmiten(){
        try{
            $emitens = Emiten::with('subsector', 'subsector.sector')->get();

            foreach($emitens as $emiten){
                $emiten->amountShare = CurrencySupport::tambahkanTitik($emiten->amountShare);
            }

            return response()->json([
                'status' => 'Data Emiten',
                'emitens' => $emitens
            ],200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Emiten Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function showEmitenPage(Request $request){
        try{
            // $emitens = Emiten::with('subsector', 'subsector.sector')
            //     ->skip($request->firstPage)
            //     ->take($request->lastPage)
            //     ->where('emitenName','like',"%$request->searchEmiten%")
            //     ->orWhere('emitenKode','like',"%$request->searchEmiten%")
            //     ->orderBy('emitenKode')
            //     ->get();
            $emitens = \DB::table('emitens')
                ->join('sub_sectors', 'sub_sectors.subSectorID', 'emitens.subSectorID')
                ->join('sectors','sectors.sectorID', 'sub_sectors.sectorID')
                ->skip($request->firstPage)
                ->take($request->lastPage)
                ->where(function($q) use ($request) {
                    $q->where('emitenName','like',"%$request->searchEmiten%")->orWhere('emitenKode','like',"%$request->searchEmiten%");
                })
                ->where('sub_sectors.subSectorID','like',"%$request->searchSubSector%") 
                ->where('sectors.sectorID','like',"%$request->searchSector%")
                ->orderBy('emitenKode')
                ->get();
            $emitensCount = \DB::table('emitens')
                ->join('sub_sectors', 'sub_sectors.subSectorID', 'emitens.subSectorID')
                ->join('sectors','sectors.sectorID', 'sub_sectors.sectorID')
                ->where(function($q) use ($request) {
                    $q->where('emitenName','like',"%$request->searchEmiten%")->orWhere('emitenKode','like',"%$request->searchEmiten%");
                })
                ->where('sub_sectors.subSectorID','like',"%$request->searchSubSector%") 
                ->where('sectors.sectorID','like',"%$request->searchSector%")
                ->count();

            foreach($emitens as $emiten){
                $emiten->amountShare = CurrencySupport::tambahkanTitik($emiten->amountShare);
            }

            return response()->json([
                'status' => 'Data Emiten',
                'emitens' => $emitens,
                'emitenCount' =>  $emitensCount
            ],200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Emiten Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createEmiten(Request $request){
        try{
            $emiten = new Emiten;
            $emiten->emitenID = $emiten->getEmitenID();
            $emiten->emitenKode = $request->emitenKode;
            $emiten->emitenName = $request->emitenName;
            $emiten->emitenAddress = $request->emitenAddress;
            $emiten->isBUMN = $request->isBUMN;
            $emiten->isAktif = $request->isAktif;
            $emiten->emitenInfo = $request->emitenInfo;
            $emiten->subSectorID = $request->subSectorID;
            $emiten->amountShare = CurrencySupport::hilangkanTitik($request->amountShare);
            $emiten->save();
            
            $emitenDataLengkap = $this->getEmiten($emiten->emitenID);

            return response()->json([
                'status' => "Data Emiten $emiten->emitenKode Tersimpan",
                'emitens' => $emitenDataLengkap
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Emiten Gagal Tersimpan',
                'info' => $e
            ],503);
        }      
    }

    public function updateEmiten(Request $request){
        try{
            $emiten = Emiten::where('emitenID', $request->emitenID)->firstOrFail();
            $emiten->emitenKode = $request->emitenKode;
            $emiten->emitenName = $request->emitenName;
            $emiten->emitenAddress = $request->emitenAddress;
            $emiten->isBUMN = $request->isBUMN;
            $emiten->isAktif = $request->isAktif;
            $emiten->emitenInfo = $request->emitenInfo;
            $emiten->subSectorID = $request->subSectorID;
            $emiten->amountShare = CurrencySupport::hilangkanTitik($request->amountShare);
            $emiten->save();

            $emitenDataLengkap = $this->getEmiten($emiten->emitenID);

            return response()->json([
                'status' => "Data Emiten $emiten->emitenKode Tersimpan",
                'emitens' => $emitenDataLengkap
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Emiten Gagal Tersimpan',
                'info' => $e
            ],503);
        }    
    }

    public function deleteEmiten(Request $request){
        try{
            $emiten = Emiten::where('emitenID', $request->emitenID)->firstOrFail();
            $emitenKode = $emiten->emitenKode;
            $emiten->delete();
            return response()->json([
                'status' => "Data Emiten $emitenKode Terhapus"
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Emiten Gagal Terhapus',
                'info' => $e
            ],503);
        }    
    }

    private function getEmiten($emitenID){
        try{
            // $emitens =  Emiten::with('subsector', 'subsector.sector')->where('emitenID', $emitenID)->firstOrFail();
            $emitens = \DB::table('emitens')
                ->join('sub_sectors', 'sub_sectors.subSectorID', 'emitens.subSectorID')
                ->join('sectors','sectors.sectorID', 'sub_sectors.sectorID')
                ->where('emitenID', $emitenID)
                ->first();
            $emitens->amountShare = CurrencySupport::tambahkanTitik($emitens->amountShare);

            return $emitens;
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Emiten Gagal Disediakan',
                'info' => $e
            ],503);
        }    
    }
}
