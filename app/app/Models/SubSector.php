<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubSector extends Model
{
    protected $table = 'sub_sectors';
    public $incrementing = false;
    protected $primaryKey = 'subSectorID';
    protected $fillable = ['subSectorID','subSectorName', 'sectorID'];
    public function getSubSectorID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'SUBSECTOR-'.$time;
    }

    public function sector(){
        return $this->belongsTo('App\Models\Sector', 'sectorID');
    }
}
