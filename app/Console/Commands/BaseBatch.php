<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BaseBatch extends Command
{
	/**
	 * The name and signature of the console command.
	 *
	 * @var string
	 */
	protected $signature = "command:basebatch";
	
	/**
	 * The console command description.
	 *
	 * @var string
	 */
	protected $description = "Command description.";
    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        //
    }
    protected function success($method) {
    	// 成功時共通処理
    	echo $method . " is success.";
    }
    
    protected function failed($method, $errorMessage) {
    	// 失敗時共通処理
    	echo $method . " is failed. => " . $errorMessage;
    }
    
}