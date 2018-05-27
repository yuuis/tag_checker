<?php

namespace App\Http\Logic\ValidateTest;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;

class ValidateTestLogic extends \App\Http\Logic\BaseLogic
{
    public function __construct()
    {
    }

    /**
     * 登録用エラーチェック
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validateCheck(Request $request)
    {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー
        // 入力値の保存
        $resultDTO->setInputs($this->getRequestParameter($request));
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

        $inputs = $request->all();
        $rules = [
            "mail" => "required|email|min:1",
            "pass" => "required|alpha_num|max:255|min:1",
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
        return $resultDTO;
    }

    /**
     * 検索処理実行
     * @param Request $request
     */
    public function register(Request $request)
    {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー

        $resultDTO->setInputs($this->getRequestParameter($request));

        $dao = new \App\Http\Model\ValidateTestDAO;
        $results = $dao->register($resultDTO->getInputs());
        $resultDTO->setResults($results);

        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

        return $resultDTO;
    }

    /**
     * 検索処理実行
     * @param Request $request
     */
    public function userlist(Request $request)
    {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();// ロジック結果取得アクセサー

        $resultDTO->setInputs($this->getRequestParameter($request));

        $dao = new \App\Http\Model\ValidateTestDAO;
        $results = $dao->selectUser($resultDTO->getInputs());
        $resultDTO->setResults($results);

        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

        return $resultDTO;
    }
}