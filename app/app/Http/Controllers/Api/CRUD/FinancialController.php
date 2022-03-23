<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Financial;
use App\Models\EmitenData;
use App\Http\Helpers\CurrencySupport;
use App\Models\Emiten; 

class FinancialController extends Controller
{
    public function showFinancial(){
        try{
            $financials = $this->getFinancialData();
            $financials = $this->groupingFinancialByEmiten($financials);
            return response()->json([
                'status' => 'Financial Data',
                'financials' => $financials,
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Financial Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function showFinancialPage(Request $request){
        try{
            // $financials = $this->getFinancialData($request);
            // $financials = $this->groupingFinancialByEmiten($financials);

            // $firstPage = $request->firstPage;
            // $takingPage = $request->lastPage;
            
            // $count = 0;
            // $take = 0;
            // $financialPage = array();
            // foreach($financials as $financial){
            //     if($count >= $firstPage){
            //         if($take < $takingPage){
            //             array_push($financialPage, $financial);
            //         }
            //         $take++;
            //     }
            //     $count++;
            // }
            $emitenData = array();
            $emitenDataID = $this->getEmitenDataID($request);
            $emitenDataCount = $this->getEmitenDataIDCount($request);
            foreach($emitenDataID as $emiten){
                array_push($emitenData, $emiten->emitenDataID);
            }
            $financials = $this->getFinancialByEmitenDataID($emitenData);
            $financials = $this->groupingFinancialByEmiten($financials);
            return response()->json([
                'status' => 'Financial Data',
                'financials' => $financials,
                'financialCount' => $emitenDataCount
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Financial Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createFinancial(Request $request){
        try{
            if($this->emitenIsExist($request)){
                return response()->json([
                    'error' => 'Data Emiten Sudah Ada pada DB',
                    'info' => []
                ],503);
            }

            if($request->isAktif == 1 || $request->isAktif == 'true' || $request->isAktif == true ){
                $this->setNonAktifEmiten($request->emitenID);
                $this->setShareEmiten($request->emitenID, $request->rasioes);
            }

            $financial = new Financial;
            $emitenData = new EmitenData;
            $emitenData->emitenDataID = $emitenData->getEmitenDataID();
            $emitenData->emitenID = $request->emitenID;
            $emitenData->quartalID = $request->quartalID;
            $emitenData->emitenPrice = CurrencySupport::hilangkanTitik($request->emitenPrice);
            $emitenData->yearID = $request->yearID;
            $emitenData->isAktif = $request->isAktif;
            $emitenData->save();
            
            $rasioes = array();
            foreach($request->rasioes as $rasio){
                array_push($rasioes, [
                    'financialID' => $financial->getFinancialID(),
                    'emitenDataID' => $emitenData->emitenDataID,
                    'rasioID' => $rasio['rasioID'],
                    'currencyID' => $rasio['currencyID'],
                    'price' => CurrencySupport::hilangkanTitik($rasio['price']),
                    'pricePerUnitCurrency' => CurrencySupport::hilangkanTitik($rasio['pricePerUnitCurrency'])
                ]);
            }
            Financial::insert($rasioes);

            $financials = $this->getFinancialByEmitenDataID(array($emitenData->emitenDataID));
            $financials = $this->groupingFinancialByEmiten($financials);
            $status = "Data Financial Emiten " . $financials[0]->emitenKode . " " . $financials[0]->quartalName . " " . $financials[0]->yearName . " Berhasil diSimpan";
            return response()->json([
                'status' => $status,
                'financials' => $financials[0]
            ]);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Financial Data Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function updateFinancial(Request $request){
        // try{
            if($request->isAktif == 1 || $request->isAktif == 'true' || $request->isAktif == true ){
                $this->setNonAktifEmiten($request->emitenID);
                $this->setShareEmiten($request->emitenID, $request->rasioes);
            }
            $emitenData = EmitenData::where('emitenDataID', $request->emitenDataID)->firstOrFail();
            $emitenData->emitenID = $request->emitenID;
            $emitenData->quartalID = $request->quartalID;
            $emitenData->emitenPrice = CurrencySupport::hilangkanTitik($request->emitenPrice);
            $emitenData->yearID = $request->yearID;
            $emitenData->isAktif = $request->isAktif;
            $emitenData->save();
            foreach($request->rasioes as $rasio){
                if($rasio['isEditable']){
                    $financial = Financial::where('financialID', $rasio['financialID'])->first();
                    if($financial){
                        $financial->emitenDataID = $rasio['emitenDataID'];
                        $financial->rasioID = $rasio['rasioID'];
                        $financial->currencyID = $rasio['currencyID'];
                        $financial->pricePerUnitCurrency = CurrencySupport::hilangkanTitik($rasio['pricePerUnitCurrency']);
                        $financial->price = CurrencySupport::hilangkanTitik($rasio['price']);
                        $financial->save();
                    }else{
                        $financial = new Financial;
                        $financial->financialID = $financial->getFinancialID();
                        $financial->emitenDataID = $rasio['emitenDataID'];
                        $financial->rasioID = $rasio['rasioID'];
                        $financial->currencyID = $rasio['currencyID'];
                        $financial->pricePerUnitCurrency = CurrencySupport::hilangkanTitik($rasio['pricePerUnitCurrency']);
                        $financial->price = CurrencySupport::hilangkanTitik($rasio['price']);
                        $financial->save();
                    }
                }
            }
            $financials = $this->getFinancialByEmitenDataID(array($request->emitenDataID));
            $financials = $this->groupingFinancialByEmiten($financials);
            $status = "Data Financial Emiten " . $financials[0]->emitenKode . " " . $financials[0]->quartalName . " " . $financials[0]->yearName . " Berhasil diSimpan";
            return response()->json([
                'status' => $status,
                'financials' => $financials[0]
            ], 200);
        // }catch (\Throwable $e){
        //     return response()->json([
        //         'error' => 'Financial Data Gagal Tersimpan',
        //         'info' => $e
        //     ],503);
        // }
    }

    public function deleteFinancial(Request $request){
        try{
            $emitenData = EmitenData::with('emiten','quartal','year')->where('emitenDataID', $request->emitenDataID)->firstOrFail();
            $status = "Data Financial Emiten ".$emitenData->emiten->emitenKode." ".$emitenData->quartal->quartalName." ".$emitenData->year->yearName." Berhasil Dihapus!";
            $financials = Financial::where('emitenDataID', $request->emitenDataID)->delete();
            $emitenData->delete();
            
            return response()->json([
                'status' => $status
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Financial Data Gagal Terhapus',
                'info' => $e
            ],503);
        }
    }

    private function setNonAktifEmiten($emitenID){
        \DB::statement("UPDATE emiten_datas SET isAktif = 0 WHERE emitenID ='$emitenID'");
    }

    private function setShareEmiten($emitenID, $rasioes){
        $emiten = Emiten::where('emitenID', $emitenID)->firstOrFail();
        foreach($rasioes as $rasio){
            if($rasio['rasioID'] == "191203RASIO-723316"){
                $emiten->amountShare = CurrencySupport::hilangkanTitik($rasio['price']);
                $emiten->save();
                break;
            }
        }
    }

    private function emitenIsExist($request){
        $emiten = EmitenData::where('emitenID',$request->emitenID)
                    ->where('quartalID', $request->quartalID)
                    ->where('yearID', $request->yearID)
                    ->first();
        if($emiten){
            return true;
        }
        return false;
    }

    private function getEmitenDataID($request){
        try{
            $emitenDatas = \DB::table('emiten_datas')
                ->selectRaw('
                    emiten_datas.emitenDataID as emitenDataID
                ')
                ->join('emitens', 'emitens.emitenID', 'emiten_datas.emitenID')
                ->join('quartals', 'quartals.quartalID', 'emiten_datas.quartalID')
                ->join('years', 'years.yearID', 'emiten_datas.yearID')
                ->where('emitens.emitenKode', 'like', "%$request->searchEmiten%")
                ->orderBy('emitens.emitenKode')
                ->orderBy('years.yearName', 'desc')
                ->orderBy('quartals.quartalName', 'desc')
                ->skip($request->firstPage)
                ->take($request->lastPage)
                ->get();
            return $emitenDatas;
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Financial Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
    private function getEmitenDataIDCount($request){
        try{
            $emitenDatas = \DB::table('emiten_datas')
                ->selectRaw('
                    emiten_datas.emitenDataID as emitenDataID
                ')
                ->join('emitens', 'emitens.emitenID', 'emiten_datas.emitenID')
                ->join('quartals', 'quartals.quartalID', 'emiten_datas.quartalID')
                ->join('years', 'years.yearID', 'emiten_datas.yearID')
                ->where('emitens.emitenKode', 'like', "%$request->searchEmiten%")
                ->orderBy('emitens.emitenKode')
                ->orderBy('years.yearName', 'desc')
                ->orderBy('quartals.quartalName', 'desc')
                ->count();
            return $emitenDatas;
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Financial Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    private function getFinancialByEmitenDataID($emitenDataID){
        try{
            $financials = \DB::table('emiten_datas')
                ->selectRaw('
                    emiten_datas.emitenDataID as emitenDataID,
                    emiten_datas.emitenID as emitenID,
                    emitens.emitenName as emitenName,
                    emitens.emitenKode as emitenKode,

                    years.yearID as yearID,
                    years.yearName as yearName,

                    quartals.quartalID as quartalID,
                    quartals.quartalName as quartalName,
                    
                    emiten_datas.emitenPrice as emitenPrice,
                    emiten_datas.isAktif as isAktif,

                    sub_sectors.subSectorName as subSectorName,
                    sectors.sectorName as sectorName,
                    
                    financials.financialID as financialID,
                    financials.emitenDataID as emitenDataID,
                    financials.rasioID as rasioID,
                    rasioes.rasioName as rasioName,
                    financials.currencyID as currencyID,
                    currencies.currencyName as currencyName,
                    financials.pricePerUnitCurrency as pricePerUnitCurrency,
                    financials.price as price
                ')
                ->join('emitens', 'emitens.emitenID', 'emiten_datas.emitenID')
                ->join('sub_sectors', 'sub_sectors.subSectorID', 'emitens.subSectorID')
                ->join('sectors', 'sectors.sectorID', 'sub_sectors.sectorID')
                ->join('quartals', 'quartals.quartalID', 'emiten_datas.quartalID')
                ->join('years', 'years.yearID', 'emiten_datas.yearID')
                ->leftjoin('financials', 'financials.emitenDataID', 'emiten_datas.emitenDataID')
                ->leftjoin('rasioes', 'rasioes.rasioID', 'financials.rasioID')
                ->leftjoin('currencies','currencies.currencyID', 'financials.currencyID')
                ->whereIn('emiten_datas.emitenDataID', $emitenDataID)
                ->orderBy('emitenKode')
                ->orderBy('yearName', 'desc')
                ->orderBy('quartalName', 'desc')
                ->get();
            return $financials;
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Financial Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
    private function getFinancialData($request){
        try{
            $financials = \DB::table('emiten_datas')
                ->selectRaw('
                    emiten_datas.emitenDataID as emitenDataID,
                    emiten_datas.emitenID as emitenID,
                    emitens.emitenName as emitenName,
                    emitens.emitenKode as emitenKode,

                    years.yearID as yearID,
                    years.yearName as yearName,

                    quartals.quartalID as quartalID,
                    quartals.quartalName as quartalName,
                    
                    emiten_datas.emitenPrice as emitenPrice,
                    emiten_datas.isAktif as isAktif,

                    sub_sectors.subSectorName as subSectorName,
                    sectors.sectorName as sectorName,
                    
                    financials.financialID as financialID,
                    financials.emitenDataID as emitenDataID,
                    financials.rasioID as rasioID,
                    rasioes.rasioName as rasioName,
                    financials.currencyID as currencyID,
                    currencies.currencyName as currencyName,
                    financials.pricePerUnitCurrency as pricePerUnitCurrency,
                    financials.price as price
                ')
                ->join('emitens', 'emitens.emitenID', 'emiten_datas.emitenID')
                ->join('sub_sectors', 'sub_sectors.subSectorID', 'emitens.subSectorID')
                ->join('sectors', 'sectors.sectorID', 'sub_sectors.sectorID')
                ->join('quartals', 'quartals.quartalID', 'emiten_datas.quartalID')
                ->join('years', 'years.yearID', 'emiten_datas.yearID')
                ->leftjoin('financials', 'financials.emitenDataID', 'emiten_datas.emitenDataID')
                ->leftjoin('rasioes', 'rasioes.rasioID', 'financials.rasioID')
                ->leftjoin('currencies','currencies.currencyID', 'financials.currencyID')
                ->where('emitenKode', 'like', "%$request->searchEmiten%")
                ->orderBy('emitenKode')
                ->orderBy('yearName', 'desc')
                ->orderBy('quartalName', 'desc')
                ->get();
            return $financials;
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Financial Data Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    // private function getFinancialData(){
    //     try{
    //         $financials = \DB::table('emiten_datas')
    //             ->selectRaw('
    //                 emiten_datas.emitenDataID as emitenDataID,
    //                 emiten_datas.emitenID as emitenID,
    //                 emitens.emitenName as emitenName,
    //                 emitens.emitenKode as emitenKode,

    //                 years.yearID as yearID,
    //                 years.yearName as yearName,

    //                 quartals.quartalID as quartalID,
    //                 quartals.quartalName as quartalName,
                    
    //                 emiten_datas.emitenPrice as emitenPrice,
    //                 emiten_datas.isAktif as isAktif,

    //                 sub_sectors.subSectorName as subSectorName,
    //                 sectors.sectorName as sectorName,
                    
    //                 financials.financialID as financialID,
    //                 financials.emitenDataID as emitenDataID,
    //                 financials.rasioID as rasioID,
    //                 rasioes.rasioName as rasioName,
    //                 financials.currencyID as currencyID,
    //                 currencies.currencyName as currencyName,
    //                 financials.pricePerUnitCurrency as pricePerUnitCurrency,
    //                 financials.price as price
    //             ')
    //             ->join('emitens', 'emitens.emitenID', 'emiten_datas.emitenID')
    //             ->join('sub_sectors', 'sub_sectors.subSectorID', 'emitens.subSectorID')
    //             ->join('sectors', 'sectors.sectorID', 'sub_sectors.sectorID')
    //             ->join('quartals', 'quartals.quartalID', 'emiten_datas.quartalID')
    //             ->join('years', 'years.yearID', 'emiten_datas.yearID')
    //             ->leftjoin('financials', 'financials.emitenDataID', 'emiten_datas.emitenDataID')
    //             ->leftjoin('rasioes', 'rasioes.rasioID', 'financials.rasioID')
    //             ->leftjoin('currencies','currencies.currencyID', 'financials.currencyID')
    //             ->orderBy('emitenKode')
    //             ->orderBy('yearName', 'desc')
    //             ->orderBy('quartalName', 'desc')
    //             ->get();
    //         return $financials;
    //     }catch (\Throwable $e){
    //         return response()->json([
    //             'error' => 'Financial Data Gagal Disediakan',
    //             'info' => $e
    //         ],503);
    //     }
    // }

    private function groupingFinancialByEmiten($financialData){
        $dataGroupFinancial = array();
        foreach($financialData as $financial){
            if($this->ifEmitenExist($dataGroupFinancial, $financial)){
                $dataGroupFinancial = $this->insertRasioGrouping($dataGroupFinancial, $financial);
            }else{
                $financial = $this->createRasioGrouping($financial);
                array_push($dataGroupFinancial, $financial);
            }
        }
        return $dataGroupFinancial;
    }

    private function ifEmitenExist($dataGroupFinancial, $financial){
        foreach($dataGroupFinancial as $dataGroup){
            if($dataGroup->emitenKode === $financial->emitenKode){
                if($dataGroup->emitenName === $financial->emitenName){
                    if($dataGroup->yearName === $financial->yearName){
                        if($dataGroup->quartalName === $financial->quartalName){
                            return true;
                        }
                    }
                }
            }
        }
        return false;
    }

    private function createRasioGrouping($financial){
        $data = new \stdClass;
        $rasio = array();
        $dataRasio = $this->dataRasio($financial);
        $data->emitenDataID = $financial->emitenDataID;
        $data->emitenID = $financial->emitenID;
        $data->emitenName = $financial->emitenName;
        $data->emitenKode = $financial->emitenKode;
        $data->yearID = $financial->yearID;
        $data->yearName = $financial->yearName;
        $data->quartalID = $financial->quartalID;
        $data->quartalName = $financial->quartalName;
        $data->emitenPrice = CurrencySupport::tambahkanTitik($financial->emitenPrice);
        $data->isAktif = $financial->isAktif;     
        $data->subSectorName = $financial->subSectorName;
        $data->sectorName = $financial->sectorName;
        array_push($rasio, $dataRasio);
        $data->rasio = $rasio;
        return $data;
    }

    private function insertRasioGrouping($dataGroupFinancial, $financial){
        foreach($dataGroupFinancial as $dataGroup){
            if($dataGroup->emitenKode === $financial->emitenKode){
                if($dataGroup->emitenName === $financial->emitenName){
                    if($dataGroup->yearName === $financial->yearName){
                        if($dataGroup->quartalName === $financial->quartalName){
                            $dataRasio = $this->dataRasio($financial);
                            array_push($dataGroup->rasio, $dataRasio);
                        }
                    }
                }
            }            
        }
        return $dataGroupFinancial;
    }

    private function dataRasio($financial){
        $dataRasio = new \stdClass;
        $dataRasio->financialID = $financial->financialID;
        $dataRasio->emitenDataID = $financial->emitenDataID;
        $dataRasio->rasioID = $financial->rasioID;
        $dataRasio->rasioName = $financial->rasioName;
        $dataRasio->currencyID = $financial->currencyID;
        $dataRasio->currencyName = $financial->currencyName;
        $dataRasio->pricePerUnitCurrency = CurrencySupport::tambahkanTitik($financial->pricePerUnitCurrency);
        $dataRasio->price = CurrencySupport::tambahkanTitik($financial->price);
        $dataRasio->isEditable = false;
        return $dataRasio;
    }

     // private function createEmitenData($request){
    //     try{
    //         if($request->isAktif == 1 || $request->isAktif == 'true' || $request->isAktif == true ){
    //             $this->setNonAktifEmiten($request->emitenID);
    //         }
    //         $emitenData = new EmitenData;
    //         $emitenData->emitenDataID = $emitenData->getEmitenDataID();
    //         $emitenData->emitenID = $request->emitenID;
    //         $emitenData->quartalID = $request->quartalID;
    //         $emitenData->emitenPrice = $request->emitenPrice;
    //         $emitenData->yearID = $request->yearID;
    //         $emitenData->isAktif = $request->isAktif;
    //         $emitenData->save();

    //         return response()->json([
    //             'status' => "Emiten Data ". $emitenDataLengkap[0]->emiten->emitenKode ." Tersimpan",
    //             'emitenDatas' => $emitenDataLengkap
    //         ], 200);
    //     }catch (\Throwable $e){
    //         return response()->json([
    //             'error' => 'Emiten Data Gagal Tersimpan',
    //             'info' => $e
    //         ],503);
    //     }
    // }
}
