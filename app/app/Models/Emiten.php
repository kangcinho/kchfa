<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emiten extends Model
{
    protected $table = 'emitens';
    public $incrementing = false;
    protected $primaryKey = 'emitenID';
    protected $fillable = ['emitenID','emitenKode','emitenName','emitenAddress','emitenInfo','subSectorID','amountShare'];
    protected $casts = [
        'isBUMN' => 'boolean',
        'isAktif' => 'boolean'
    ];
    public function getEmitenID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'EMITEN-'.$time;
    }

    public function subsector(){
        return $this->belongsTo('App\Models\SubSector', 'subSectorID');
    }
}
