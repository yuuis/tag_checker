<?php

namespace App\Http\Middleware;

use Closure;

/**
 * Controllerの前処理を定義する
 * @author Administrator
 */
class Before
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
        // 前処理を定義する
        
    	// 検索または空の場合にUUIDを振る
    	$buttonNo = $request->get(\Config::get('const.ORIGN_BUTTON_NO_NAME'));
    	if ($buttonNo == '' || $buttonNo == \Config::get('const.ORIGN_BUTTON_NO_NAME_SEARCH')) {
    		$request->getSession()->put(
    				$request->getUri() . '::' . \Config::get('const.ORIGN_PAGE_SHOW_UUID_NAME'), \App\Commons\Utils\AppUtil::generateUUID()
   				);
    	}
        return $next($request);
    }
}
