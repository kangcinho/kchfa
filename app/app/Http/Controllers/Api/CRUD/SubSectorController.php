<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\SubSector;

class SubSectorController extends Controller
{
    public function showSubSector(){
        try{
            $subSectors = SubSector::with('sector')->get();
            return response()->json([
                'status' => 'Data Sub Sectors',
                'subSectors' => $subSectors
            ],200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Sub Sector Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function showSubSectorPage(Request $request){
        try{
            $subSectors = SubSector::with('sector')
                ->skip($request->firstPage)
                ->take($request->lastPage)
                ->where('subSectorName','like',"%$request->searchSubSector%")
                ->get();
            $subSectorCount = SubSector::where('subSectorName','like',"%$request->searchSubSector%")
                ->count();

            return response()->json([
                'status' => 'Data Sub Sectors',
                'subSectors' => $subSectors,
                'subSectorCount' => $subSectorCount
            ],200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Sub Sector Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createSubSector(Request $request){
        try{
            $subSector = new SubSector;
            $subSector->subSectorID = $subSector->getSubSectorID();
            $subSector->subSectorName = $request->subSectorName;
            $subSector->sectorID = $request->sectorID;
            $subSector->save();
            $subSectorDataLengkap = $this->getSubSector($subSector->subSectorID);

            return response()->json([
                'status' => "Data Sub Sector $subSector->subSectorName Tersimpan",
                'subSectors' => $subSectorDataLengkap
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Sub Sector Gagal Tersimpan',
                'info' => $e
            ],503);
        }        
    }

    public function updateSubSector(Request $request){
        try{
            $subSector = SubSector::where('subSectorID', $request->subSectorID)->firstOrFail();
            $subSector->subSectorName = $request->subSectorName;
            $subSector->sectorID = $request->sectorID;
            $subSector->save();
            $subSectorDataLengkap = $this->getSubSector($subSector->subSectorID);
            
            return response()->json([
                'status' => "Data Sub Sector $subSector->subSectorName Tersimpan",
                'subSectors' => $subSectorDataLengkap
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Sub Sector Gagal Tersimpan',
                'info' => $e
            ],503);
        }    
    }

    public function deleteSubSector(Request $request){
        try{
            $subSector = SubSector::where('subSectorID', $request->subSectorID)->firstOrFail();
            $subSectorName = $subSector->subSectorName;
            $subSector->delete();
            return response()->json([
                'status' => "Data Sub Sector $subSectorName Terhapus"
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Sub Sector Gagal Terhapus',
                'info' => $e
            ],503);
        }    
    }

    private function getSubSector($subSectorID){
        try{
            return SubSector::with('sector')->where('subSectorID', $subSectorID)->firstOrFail();
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Sub Sector Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function getSubSectorBySector(Request $request){
        try{
            $subSectors =  SubSector::where('sectorID', $request->sectorID)->get();
            return response()->json([
                'status' => "Data Sub Sector",
                'subSectors' => $subSectors
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Sub Sector Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
}
