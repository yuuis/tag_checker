<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Validator;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
    	// CustomValidatorに含まれるメソッドを全てロードする
    	$methds = get_class_methods(\App\Commons\Validations\CustomValidator::class);
    	foreach ($methds as $method) {
    		Validator::extend($method, '\App\Commons\Validations\CustomValidator@'.$method);
    	}
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {

    	
    	// ログの表示情報を追加
    	$monolog = \Log::getMonolog();
    	$monolog->pushProcessor(new \Monolog\Processor\MemoryUsageProcessor());
    	$monolog->pushProcessor(new \Monolog\Processor\WebProcessor);
    	$monolog->pushProcessor(new \Monolog\Processor\ProcessIdProcessor);
    	// オリジナルのログを追加する場合は以下を編集
    	$monolog->pushProcessor(new \App\Commons\Logs\ExtraLogProcessor());
    	 

    }
}
