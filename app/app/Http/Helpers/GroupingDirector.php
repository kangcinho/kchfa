<?php

namespace App\Http\Helpers;

class GroupingDirector{
    public function groupingDirectorByEmiten($financialData){
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

            $data->emitenKode = $financial->emitenKode;
            $data->emitenName = $financial->emitenName;
            $data->subSectorName = $financial->subSectorName;
            $data->sectorName = $financial->sectorName;
            $data->emitenPrice = $financial->emitenPrice;
            $data->yearName = $financial->yearName;
            $data->quartalName = $financial->quartalName;
            $data->quartalCalculate = $financial->quartalCalculate;
            $data->isAktif = $financial->isAktif;           
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
        $dataRasio->rasioName = $financial->rasioName;
        $dataRasio->isFinancial = $financial->isFinancial;
        $dataRasio->isOwner = $financial->isOwner;
        $dataRasio->isNeraca = $financial->isNeraca;
        $dataRasio->isLabaRugi = $financial->isLabaRugi;
        $dataRasio->isCashFlow = $financial->isCashFlow;
        $dataRasio->isCFO = $financial->isCFO;
        $dataRasio->isCFI = $financial->isCFI;
        $dataRasio->isCFF = $financial->isCFF;
        $dataRasio->isPBV = $financial->isPBV;
        $dataRasio->isPER = $financial->isPER;
        $dataRasio->isEPS = $financial->isEPS;
        $dataRasio->isROE = $financial->isROE;
        $dataRasio->isGPM = $financial->isGPM;
        $dataRasio->isNPM = $financial->isNPM;
        $dataRasio->isDER = $financial->isDER;
        $dataRasio->isTax = $financial->isTax;
        $dataRasio->isBVPS = $financial->isBVPS;
        $dataRasio->isCurrentRatio = $financial->isCurrentRatio;
        $dataRasio->isQuickRatio = $financial->isQuickRatio;
        $dataRasio->directorName = $financial->directorName;
        $dataRasio->ownershipEmiten = $financial->ownershipEmiten;

        return $dataRasio;
    }
}