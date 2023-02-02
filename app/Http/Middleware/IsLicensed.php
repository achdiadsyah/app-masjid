<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class IsLicensed
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        // $licenseKey = env('APP_LICENSE');
        // $privateKey = "RyanSyah244196";

        // $data['license']    = env('APP_LICENSE'); 
        // $data['token']      = env('APP_TOKEN');

        // if($data['license'] == "" OR $data['token']){
        //     $uniqid = uniqid();
        //     putenv("APP_TOKEN=$uniqid");
        //     $data['license']    = env('APP_LICENSE'); 
        //     $data['token']      = env('APP_TOKEN');
        //     return response()->view('blocked', $data);
        // }

        return $next($request);

    }
}
