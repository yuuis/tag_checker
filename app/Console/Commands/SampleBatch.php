<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

/**
 * サンプルバッチプログラム
 * ファイル作成後にKernel.phpの$commandsへファイルを追加する必要がある
 * sudo php artisan command:samplebatch
 * @author Administrator
 *
 */
class SampleBatch extends BaseBatch
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "command:samplebatch";

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
        try {
        	echo "batch successed \r\n";
        	$this->success(__METHOD__);
        } catch (\Exception $e) {
        	$this->failed(__METHOD__, $e->getMessage());
        }
        
    }
    
    
}