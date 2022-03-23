<?php

namespace App\Http\Controllers\Api\CRUD;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Currency;

class CurrencyController extends Controller
{
    public function showCurrency(){
        try{
            $currencies = Currency::all();
            return response()->json([
                'status' => 'Data Currency',
                'currencies' => $currencies
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Currency Gagal Disediakan',
                'info' => $e
            ],503);
        }
    }

    public function createCurrency(Request $request){
        try{
            $currency = new Currency;
            $currency->currencyID = $currency->getCurrencyID();
            $currency->currencyName = $request->currencyName;
            $currency->currencyCountry = $request->currencyCountry;
            $currency->save();

            return response()->json([
                'status' => "Data Currency $currency->currencyName Tersimpan",
                'currencies' => $currency
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Currency Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function updateCurrency(Request $request){
        try{
            $currency = Currency::where('currencyID', $request->currencyID)->firstOrFail();
            $currency->currencyName = $request->currencyName;
            $currency->currencyCountry = $request->currencyCountry;
            $currency->save();

            return response()->json([
                'status' => "Data Currency $currency->currencyName Tersimpan",
                'currencies' => $currency
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Currency Gagal Tersimpan',
                'info' => $e
            ],503);
        }
    }

    public function deleteCurrency(Request $request){
        try{
            $currency = Currency::where('currencyID', $request->currencyID)->firstOrFail();
            $currencyName = $currency->currencyName;
            $currency->delete();
            
            return response()->json([
                'status' => "Data Currency $currencyName Terhapus",
            ], 200);
        }catch (\Throwable $e){
            return response()->json([
                'error' => 'Data Currency Gagal Terhapus',
                'info' => $e
            ],503);
        }
    }
}
