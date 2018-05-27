<?php

namespace App\Http\Middleware;

use Closure;

/**
 * コントローラーから処理が返ってくるまでの処理時間計測
 * @author Administrator
 */
class Time
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
    	// 前処理にて開始時間を取得する
//        \Log::info(__METHOD__);
        static $time = NULL;
        if ($time == NULL) {
        	$time = microtime(true);
        }
        $response = $next($request);

    	// 後処理にてトータル時間を出力する
//        \Log::info(__METHOD__);
        if ($time != NULL) {
        	\Log::debug(__METHOD__ . ' run time ===> ' . (microtime(true) - $time));
        }
        
        return $response;
    }
}
