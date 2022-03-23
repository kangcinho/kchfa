<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Director extends Model
{
    protected $table = 'directors';
    public $incrementing = false;
    protected $primaryKey = 'directorID';
    protected $fillable = ['directorID','emitenDataID','rasioID','directorName','ownershipEmiten'];

    public function getDirectorID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'DIRECTOR-'.$time;
    }

    public function emitenData(){
        return $this->belongsTo('App\Models\EmitenData', 'emitenDataID');
    }

    public function rasio(){
        return $this->belongsTo('App\Models\Rasio', 'rasioID');
    }
}
