<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    protected $table = 'sectors';
    public $incrementing = false;
    protected $primaryKey = 'sectorID';
    protected $fillable = ['sectorID','sectorName'];
    
    public function getSectorID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'SECTOR-'.$time;
    }

    public function subSector(){
        return $this->hasMany('App\Models\SubSector', 'sectorID');
    }
}
