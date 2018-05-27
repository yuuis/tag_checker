<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Http\Request;
use \App\Commons\HolidayDateTime;

/**
 * サンプルバッチプログラム
 * ファイル作成後にKernel.phpの$commandsへファイルを追加する必要がある
 * sudo -u nginx php artisan command:tagcheckbatch
 * 
 */
class TagCheckBatch extends BaseBatch {

  /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = "command:tagcheckbatch";

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = "tag check.";

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct() {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle() {
        \Log::info(__METHOD__);
        exec("/var/www/html/source.sh", $output, $return_var);
        \Log::debug(__METHOD__ . "output--->" . print_r($output, true). " return--->".$return_var);
    }
}