<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $table = 'currencies';
    public $incrementing = false;
    protected $primaryKey = 'currencyID';
    protected $fillable = ['currencyID','currencyName','currencyCountry'];
    
    public function getCurrencyID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'CURRENCY-'.$time;
    }
}
