<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Quartal extends Model
{
    protected $table = 'quartals';
    public $incrementing = false;
    protected $primaryKey = 'quartalID';
    protected $fillable = ['quartalID','quartalName','quartalCalculate'];

    public function getQuartalID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'QUARTAL-'.$time;
    }
}
