<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Sector;
class SectorController extends Controller
{
    public function showSector(){
        try{
            $sectors = Sector::all();
            return response()->json([
                'status' => 'Data Sectors',
                'sectors' => $sectors
            ],200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Sector Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createSector(Request $request){
        try{
            $sector = new Sector;
            $sector->sectorID = $sector->getSectorID();
            $sector->sectorName = $request->sectorName;
            $sector->save();
            return response()->json([
                'status' => "Data Sector $sector->sectorName Tersimpan",
                'sectors' => $sector
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Sector Gagal Tersimpan',
                'info' => $e
            ],503);
        }        
    }

    public function updateSector(Request $request){
        try{
            $sector = Sector::where('sectorID', $request->sectorID)->firstOrFail();
            $sector->sectorName = $request->sectorName;
            $sector->save();
            return response()->json([
                'status' => "Data Sector $sector->sectorName Tersimpan",
                'sectors' => $sector
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Sector Gagal Tersimpan',
                'info' => $e
            ],503);
        }    
    }

    public function deleteSector(Request $request){
        try{
            $sector = Sector::where('sectorID', $request->sectorID)->firstOrFail();
            $sectorName = $sector->sectorName ;
            $sector->delete();
            return response()->json([
                'status' => "Data Sector $sectorName Terhapus"
            ]);
        }catch(\Throwable $e){
            return response()->json([
                'error' => 'Data Sector Gagal Terhapus',
                'info' => $e
            ],503);
        }
    }

    public function subSector(){
        try{
            $sectors = Sector::with('subSector')->get();
            return response()->json([
                'status' => 'Data Sub Sectors',
                'sectors' => $sectors
            ],200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Sub Sector Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }
}
