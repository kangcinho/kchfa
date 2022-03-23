<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

class checkIsMaster
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(Auth::user()->isMaster){
            return $next($request);
        }
        return $next($request);
        return response()->json([
            'error' => 'Anda Tidak Memiliki Akses Untuk User Management'
        ], 503);
    }
}
