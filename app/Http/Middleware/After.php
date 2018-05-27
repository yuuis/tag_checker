<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Controllerの後処理を定義する
 * @author Administrator
 */
class After
{
    /**
     * Create a new instance.
     *
     * @param  \Illuminate\Contracts\View\Factory  $view
     * @return void
     */
    public function __construct()
    {
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $response = $next($request);
    	// ここから後に記載されたものが後処理になる
//        \Log::info(__METHOD__);
       
        return $response;
    }
}
