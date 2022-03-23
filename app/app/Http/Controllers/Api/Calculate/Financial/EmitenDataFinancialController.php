<?php

namespace App\Http\Controllers\Api\Calculate\Financial;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Helpers\GroupingEmiten;

class EmitenDataFinancialController extends Controller
{
    public function showCalculateByEmiten($emiten){
        $groupEmiten = new GroupingEmiten;
        $financials = $this->getFinancialByEmiten($emiten);
        $financialGroups = $groupEmiten->groupingFinancialByEmiten($financials);
        return response()->json([
            // 'result' => $financials,
            'result' => $financialGroups
        ],200);
    }

    private function getFinancialByEmiten($emitenKode){
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

                    financials.pricePerUnitCurrency as pricePerUnitCurrency,
                    financials.price as price,

                    currencies.currencyName as currencyName,
                    currencies.currencyCountry as currencies,
                    emiten_datas.isAktif as isAktif
                ')
                ->join('emitens', 'emitens.emitenID', 'emiten_datas.emitenID')
                ->join('sub_sectors', 'sub_sectors.subSectorID', 'emitens.subSectorID')
                ->join('sectors', 'sectors.sectorID', 'sub_sectors.sectorID')
                ->join('quartals', 'quartals.quartalID', 'emiten_datas.quartalID')
                ->join('years', 'years.yearID', 'emiten_datas.yearID')
                ->leftjoin('financials', 'financials.emitenDataID', 'emiten_datas.emitenDataID')
                ->leftjoin('rasioes', 'rasioes.rasioID', 'financials.rasioID')
                ->leftjoin('currencies','currencies.currencyID', 'financials.currencyID')
                // ->where('isAktif',1)
                ->where('rasioes.isFinancial',1)
                ->where('emitens.emitenKode', $emitenKode)
                ->orderBy('emitenKode')
                ->get();
            return $financials;
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Financial Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
}
