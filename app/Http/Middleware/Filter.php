<?php

namespace App\Http\Middleware;

use Closure;

class Filter
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
    	// アクセス情報をログへ出力する
    	\Log::debug("[ACCESS]" . implode(" ", array(
    			$request->ip(),
    			$request->path(),
    			$request->method(),
    			$request->server("HTTP_USER_AGENT"),
    	)));
        
        return $next($request);
    }
}
