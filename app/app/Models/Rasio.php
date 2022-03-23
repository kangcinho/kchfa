<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Rasio extends Model
{
    protected $table = 'rasioes';
    public $incrementing = false;
    protected $primaryKey = 'rasioID';
    protected $fillable = ['rasioID','rasioName','isFinancial','isOwner','isNeraca','isLabaRugi','isCashFlow','isCFO','isCFI','isCFF','isPBV','isPER','isEPS','isROE','isGPM','isNPM','isDER','isTax','isBVPS','isCurrentRatio','isQuickRatio'];
    protected $casts = [
        'isFinancial' => 'boolean',
        'isOwner' => 'boolean',
        'isNeraca' => 'boolean',
        'isLabaRugi' => 'boolean',
        'isCashFlow' => 'boolean',
        'isCFO' => 'boolean',
        'isCFI' => 'boolean',
        'isCFF' => 'boolean',
        'isPBV' => 'boolean',
        'isPER' => 'boolean',
        'isEPS' => 'boolean',
        'isROE' => 'boolean',
        'isGPM' => 'boolean',
        'isNPM' => 'boolean',
        'isDER' => 'boolean',
        'isTax' => 'boolean',
        'isBVPS' => 'boolean',
        'isCurrentRatio' => 'boolean',
        'isQuickRatio' => 'boolean',
        'isNWC' => 'boolean',
    ];
    public function getRasioID(){
        $date = Date('ymd');
        $time = str_replace('.','',substr(microtime(true),-7,7));
        return $date.'RASIO-'.$time;
    }
}
