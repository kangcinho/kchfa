<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Financial extends Model
{
    protected $table = 'financials';
    public $incrementing = false;
    protected $primaryKey = 'financialID';
    protected $fillable = ['financialID','emitenDataID','rasioID','currencyID','pricePerUnitCurrency','price'];

    public function getFinancialID(){
        $date = Date('ymd');
        // $time = str_replace('.','',substr(microtime(true),-7,7));
        $time = uniqid();
        return $date.'FINANCIAl-'.$time;
    }

    public function emitenData(){
        return $this->belongsTo('App\Models\EmitenData', 'emitenDataID');
    }
    
    public function rasio(){
        return $this->belongsTo('App\Models\Rasio', 'rasioID');
    }

    public function currency(){
        return $this->belongsTo('App\Models\Currency', 'currencyID');
    }
}
