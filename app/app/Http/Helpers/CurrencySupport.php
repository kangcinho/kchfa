<?php

namespace App\Http\Helpers;

class CurrencySupport{
 	public static function tambahkanTitik($nilai){
		return number_format($nilai,0,',','.');
    }

    public static function hilangkanTitik($nilai){
    	return str_replace('.', '', $nilai);
    }
}