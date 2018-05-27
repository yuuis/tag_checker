<?php

namespace App\Http\Logic\Test;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;

class MemcachedLogic extends \App\Http\Logic\BaseLogic
{
    public function __construct()
    {
    }

    /**
     * エラーチェック
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validate(Request $request) {
    	\Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
    	// 入力値の保存
    	$resultDTO->setInputs($this->getRequestParameter($request));
   		$resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
    	
    	return $resultDTO;
    }
    
    /**
     * 処理実行
     * @param Request $request
     */
    public function execute(Request $request)
    {
    	\Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
    	
    	// 入力値の保存
    	$resultDTO->setInputs($this->getRequestParameter($request));
    	
    	\App\Commons\Utils\MemcachedUtil::set("bar", "val");
    	\Log::debug(__METHOD__ . " redis data ====> [" . \App\Commons\Utils\MemcachedUtil::get("bar") . "]");
    	\App\Commons\Utils\MemcachedUtil::replace("bar", "val2");
    	\Log::debug(__METHOD__ . " redis data ====> [" . \App\Commons\Utils\MemcachedUtil::get("bar") . "]");
    	\App\Commons\Utils\MemcachedUtil::replace("bar2", "val2");
    	\Log::debug(__METHOD__ . " redis data ====> [" . \App\Commons\Utils\MemcachedUtil::get("bar2") . "]");
    	\App\Commons\Utils\MemcachedUtil::del("bar");
    	\Log::debug(__METHOD__ . " redis data ====> [" . \App\Commons\Utils\MemcachedUtil::get("bar") . "]");
    	
    	$resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
    	return $resultDTO;
    }
}
