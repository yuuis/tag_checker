<?php

namespace App\Http\Logic\Test;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;

class TestLogic extends \App\Http\Logic\BaseLogic
{
    public function __construct()
    {
    }

    /**
     * エラーチェック
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validateSearch(Request $request)
    {
    	\Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
    	// 入力値の保存
    	$resultDTO->setInputs($this->getRequestParameter($request));
    	$resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

   		$buttonNo = $request->get(\Config::get("const.ORIGN_BUTTON_NO_NAME"));
   		// 検索モードの場合に評価する
   		if ($buttonNo === \Config::get("const.ORIGN_BUTTON_NO_NAME_SEARCH")) {
   			$inputs = $request->all();
   			$rules = [
   					"userId" => "nullable|numeric|min:1",
   					"key" => "nullable|max:255|eisuu",
   			];
   			//attributeについては /resources/lang/ja/validation.php のattributesに定義する必要がある
   			// \Validator はlaravelがもつクラス, makeにinput と rule を渡して判定
   			// エラーがあれば帰ってくる(validation->fails())
   			$validation = \Validator::make($inputs, $rules);
   			if($validation->fails())
   			{
   				$errors = json_decode($validation->errors(), true);
   				$resultDTO->setErrors($errors);
   				// 失敗時にステータスをFAILUREにする
   				$resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
   			}
   		}

    	return $resultDTO;
    }

    /**
     * 検索処理実行
     * @param Request $request
     */
    public function search(Request $request)
    {
    	\Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー

    	$resultDTO->setInputs($this->getRequestParameter($request));

    	$dao = new \App\Http\Model\TestDAO;
    	$results = $dao->selectTest($resultDTO->getInputs());
    	$resultDTO->setResults($results);

    	$resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

    	return $resultDTO;
    }

    /**
     * 登録用エラーチェック
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validateRegister(Request $request)
    {
    	\Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
    	// 入力値の保存
    	$resultDTO->setInputs($this->getRequestParameter($request));
    	$resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

    	$buttonNo = $request->get(\Config::get("const.ORIGN_BUTTON_NO_NAME"));
    	// 検索モードの場合に評価する
    	if ($buttonNo === \Config::get("const.ORIGN_BUTTON_NO_NAME_REGISTER")) {
    		$inputs = $request->all();
    		$rules = [
    				"userId" => "nullable|numeric|min:1",
    				"key" => "nullable|max:255|eisuu",
    		];
    		//attributeについては /resources/lang/ja/validation.php のattributesに定義する必要がある
    		$validation = \Validator::make($inputs, $rules);
    		if($validation->fails())
    		{
    			$errors = json_decode($validation->errors(), true);
    			$resultDTO->setErrors($errors);
    			// 失敗時にステータスをFAILUREにする
    			$resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
    		}
    	}

    	return $resultDTO;
    }

    /**
     * 登録処理実行
     * @param Request $request
     */
    public function register(Request $request)
    {
    	\Log::info(__METHOD__);
    	$resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー

    	$resultDTO->setInputs($this->getRequestParameter($request));

    	$dao = new \App\Http\Model\TestDAO;
    	$results = $dao->selectTest($resultDTO->getInputs());
    	$resultDTO->setResults($results);

    	$resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

    	return $resultDTO;
    }

}
