<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Year extends Model
{
    protected $table = 'years';
    public $incrementing = false;
    protected $primaryKey = 'yearID';
    protected $fillable = ['yearID','yearName'];

    public function getYearID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'YEAR-'.$time;
    }
}
