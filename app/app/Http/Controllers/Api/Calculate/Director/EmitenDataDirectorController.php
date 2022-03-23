<?php

namespace App\Http\Controllers\Api\Calculate\Director;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\GroupingDirector;

class EmitenDataDirectorController extends Controller
{
    public function showCalculateByEmiten($emiten){
        $groupEmiten = new GroupingDirector;
        $financials = $this->getDirectorByEmiten($emiten);
        $directorGroup = $groupEmiten->groupingDirectorByEmiten($financials);
        return response()->json([
            // 'result' => $financials,
            'result' => $directorGroup
        ],200);
    }

    private function getDirectorByEmiten($emitenKode){
        try{
            $financials = \DB::table('emiten_datas')
                ->selectRaw('
                    emitens.emitenKode as emitenKode,
                    emitens.emitenName as emitenName,
                    sub_sectors.subSectorName as subSectorName,
                    sectors.sectorName as sectorName,
                    emiten_datas.emitenPrice as emitenPrice,
                    years.yearName as yearName,
                    quartals.quartalName as quartalName,
                    quartals.quartalCalculate as quartalCalculate,
                    
                    rasioes.rasioName as rasioName,
                    rasioes.isFinancial as isFinancial,
                    rasioes.isOwner as isOwner,
                    rasioes.isNeraca as isNeraca,
                    rasioes.isLabaRugi as isLabaRugi,
                    rasioes.isCashFlow as isCashFlow,
                    rasioes.isCFO as isCFO,
                    rasioes.isCFI as isCFI,
                    rasioes.isCFF as isCFF,
                    rasioes.isPBV as isPBV,
                    rasioes.isPER as isPER,
                    rasioes.isEPS as isEPS,
                    rasioes.isROE as isROE,
                    rasioes.isGPM as isGPM,
                    rasioes.isNPM as isNPM,
                    rasioes.isDER as isDER,
                    rasioes.isTax as isTax,
                    rasioes.isBVPS as isBVPS,
                    rasioes.isCurrentRatio as isCurrentRatio,
                    rasioes.isQuickRatio as isQuickRatio,
                    rasioes.isBVPS as isBVPS,

                    directors.directorName as directorName,
                    directors.ownershipEmiten as ownershipEmiten,

                    emiten_datas.isAktif as isAktif
                ')
                ->join('emitens', 'emitens.emitenID', 'emiten_datas.emitenID')
                ->join('sub_sectors', 'sub_sectors.subSectorID', 'emitens.subSectorID')
                ->join('sectors', 'sectors.sectorID', 'sub_sectors.sectorID')
                ->join('quartals', 'quartals.quartalID', 'emiten_datas.quartalID')
                ->join('years', 'years.yearID', 'emiten_datas.yearID')
                ->leftjoin('directors', 'directors.emitenDataID', 'emiten_datas.emitenDataID')
                ->leftjoin('rasioes', 'rasioes.rasioID', 'directors.rasioID')
                ->where('rasioes.isOwner',1)
                ->where('emitens.emitenKode', $emitenKode)
                ->orderBy('emitenKode')
                ->get();
            return $financials;
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Director Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
}
