<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});
Route::group(['namespace' => 'Api\CRUD', 'middleware' => 'auth:api'],
    function(){
        //Tabel Users
        Route::get('user', 'UserController@showUser')->middleware('isAdmin');
        Route::post('user', 'UserController@createUser')->middleware('isAdmin');
        Route::put('user', 'UserController@updateUser')->middleware('isAdmin');
        Route::delete('user', 'UserController@deleteUser')->middleware('isAdmin');

        //Tabel Rasioes
        Route::get('rasio', 'RasioController@showRasio');
        Route::post('rasio', 'RasioController@createRasio')->middleware(['isMaster', 'isCreate']);
        Route::put('rasio', 'RasioController@updateRasio')->middleware(['isMaster', 'isUpdate']);
        Route::delete('rasio', 'RasioController@deleteRasio')->middleware(['isMaster', 'isDelete']);
        Route::put('rasio/page', 'RasioController@showRasioPage');

        //Tabel Sectors
        Route::get('sector', 'SectorController@showSector');
        Route::post('sector', 'SectorController@createSector')->middleware(['isMaster', 'isCreate']);
        Route::put('sector', 'SectorController@updateSector')->middleware(['isMaster', 'isUpdate']);
        Route::delete('sector', 'SectorController@deleteSector')->middleware(['isMaster', 'isDelete']);
        Route::get('sector/subsector', 'SectorController@subSector');

        //Tabel Quartals
        Route::get('quartal', 'QuartalController@showQuartal');
        Route::post('quartal', 'QuartalController@createQuartal')->middleware(['isMaster', 'isCreate']);
        Route::put('quartal', 'QuartalController@updateQuartal')->middleware(['isMaster', 'isUpdate']);
        Route::delete('quartal', 'QuartalController@deleteQuartal')->middleware(['isMaster', 'isDelete']);

        //Tabel Currency
        Route::get('currency', 'CurrencyController@showCurrency');
        Route::post('currency', 'CurrencyController@createCurrency')->middleware(['isMaster', 'isCreate']);
        Route::put('currency', 'CurrencyController@updateCurrency')->middleware(['isMaster', 'isUpdate']);
        Route::delete('currency', 'CurrencyController@deleteCurrency')->middleware(['isMaster', 'isDelete']);

        //Tabel Year
        Route::get('year', 'YearController@showYear');
        Route::post('year', 'YearController@createYear')->middleware(['isMaster', 'isCreate']);
        Route::put('year', 'YearController@updateYear')->middleware(['isMaster', 'isUpdate']);
        Route::delete('year', 'YearController@deleteYear')->middleware(['isMaster', 'isDelete']);

        //Tabel Sub Sector
        Route::get('subsector', 'SubSectorController@showSubSector');
        Route::post('subsector', 'SubSectorController@createSubSector')->middleware(['isMaster', 'isCreate']);
        Route::put('subsector', 'SubSectorController@updateSubSector')->middleware(['isMaster', 'isUpdate']);
        Route::delete('subsector', 'SubSectorController@deleteSubSector')->middleware(['isMaster', 'isDelete']);
        Route::put('subsector/sector', 'SubSectorController@getSubSectorBySector');
        Route::put('subsector/page', 'SubSectorController@showSubSectorPage');
        
        //Tabel Emiten
        Route::get('emiten', 'EmitenController@showEmiten');
        Route::post('emiten', 'EmitenController@createEmiten')->middleware(['isMaster', 'isCreate']);
        Route::put('emiten', 'EmitenController@updateEmiten')->middleware(['isMaster', 'isUpdate']);
        Route::delete('emiten', 'EmitenController@deleteEmiten')->middleware(['isMaster', 'isDelete']);
        Route::put('emiten/page', 'EmitenController@showEmitenPage');
        
        //Tabel Emiten Data
        Route::get('emiten-data', 'EmitenDataController@showEmitenData');
        Route::post('emiten-data', 'EmitenDataController@createEmitenData')->middleware(['isFA', 'isCreate']);
        Route::put('emiten-data', 'EmitenDataController@updateEmitenData')->middleware(['isFA', 'isUpdate']);
        Route::delete('emiten-data', 'EmitenDataController@deleteEmitenData')->middleware(['isFA', 'isDelete']);
        Route::put('emiten-data/price', 'EmitenDataController@changePriceEmitenData');

        //Tabel Financial
        Route::get('financial', 'FinancialController@showFinancial');
        Route::post('financial', 'FinancialController@createFinancial')->middleware(['isFA', 'isCreate']);
        Route::put('financial', 'FinancialController@updateFinancial')->middleware(['isFA', 'isUpdate']);
        Route::delete('financial', 'FinancialController@deleteFinancial')->middleware(['isFA', 'isDelete']);
        Route::put('financial/page', 'FinancialController@showFinancialPage');

        //Tabel Directors
        Route::get('director', 'DirectorController@showDirector');
        Route::post('director', 'DirectorController@createDirector')->middleware(['isFA', 'isCreate']);
        Route::put('director', 'DirectorController@updateDirector')->middleware(['isFA', 'isUpdate']);
        Route::delete('director', 'DirectorController@deleteDirector')->middleware(['isFA', 'isDelete']);
    }
);
Route::group(['namespace' => 'Api\Calculate\Financial', 'middleware' => 'auth:api'],
    function(){
        //GET Emiten by: Sector, Subsector, Name Emiten,
        Route::post('calculate/sector/comparasi/', 'SectorCalculateController@showCalculateComparasionBySector');
        Route::post('calculate/subsectors/comparasi/', 'SubSectorCalculateController@showCalculateComparasionBySubSector');
        Route::post('calculate/emitens/comparasi/', 'EmitenCalculateController@showCalculateComparasionByEmiten');
        Route::get('calculate/emiten/{emitenKode}','EmitenDataFinancialController@showCalculateByEmiten');    
    }
);

Route::group(['namespace' => 'Api\Calculate\Director', 'middleware' => 'auth:api'],
    function(){
        //GET Director by: Name Emiten,
        Route::get('calculate/director/{emitenKode}','EmitenDataDirectorController@showCalculateByEmiten');
    }
);

Route::group(['namespace' => 'Api\Auth'],
    function(){
        Route::post('login', 'AuthController@login');
        Route::get('user-login', 'AuthController@getUserLogin');
        Route::get('logout', 'AuthController@logout');
        Route::get('refresh-token','AuthController@refresh')->middleware('auth:api');
    }
);