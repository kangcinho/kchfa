<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmitenData extends Model
{
    protected $table = 'emiten_datas';
    public $incrementing = false;
    protected $primaryKey = 'emitenDataID';
    protected $fillable = ['emitenDataID','emitenID','quartalID','emitenPrice','yearID','isAktif'];
    protected $casts = [
        'isAktif' => 'boolean'
    ];
    public function getEmitenDataID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'EMITENDATA-'.$time;
    }

    public function emiten(){
        return $this->belongsTo('App\Models\Emiten', 'emitenID');
    }

    public function quartal(){
        return $this->belongsTo('App\Models\Quartal', 'quartalID');
    }

    public function year(){
        return $this->belongsTo('App\Models\Year', 'yearID');
    }

    public function financial(){
        return $this->hasMany('App\Models\Financial','emitenDataID');
    }
}
