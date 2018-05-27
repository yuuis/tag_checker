<?php

namespace App\Http\Logic\Keyword;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;

class KeywordLogic extends \App\Http\Logic\BaseLogic {
    public function __construct() {
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validateKeywordSid(Request $request, $keywordSid) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $result = $keywordDao->checkExsistSid($keywordSid);
        if($result === "exist") {
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        } else {
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
        }
        return $resultDTO;
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validateInputs(Request $request){
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $resultDTO->setInputs($this->getRequestParameter($request));
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        $buttonNo = $request->get(\Config::get("const.ORIGN_BUTTON_NO_NAME"));
        if ($buttonNo === \Config::get("const.ORIGN_BUTTON_NO_NAME_REGISTER")) {
            $inputs = $request->all();
            $rules = [
                "targetKeyword" => "required|max:255",
                "activeFlag" => "nullable|in:0,1",
                "targetUrl.*" => "nullable|max:255",
                "searchType.*" => "nullable|in:1,2",
                "urlActiveFlag.*" => "nullable|in:0,1",
            ];
            \Log::debug(__METHOD__."---inputs--->". print_r($inputs, true));
            $validation = \Validator::make($inputs, $rules);

            if($validation->fails()) {
                $errors = json_decode($validation->errors(), true);
                $resultDTO->setErrors($errors);
                $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
            }
        }
        return $resultDTO;
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function registerKeyword(Request $request) {
        \Log::info(__METHOD__);
        $targetKeyword = $request->input("targetKeyword");
        $activeFlag = $request->input("activeFlag");
        $targetUrl = $request->input("targetUrl");
        $searchType = $request->input("searchType");
        $urlActiveFlag = $request->input("urlActiveFlag");
        \Log::debug(__METHOD__."---targetul--->". print_r($targetUrl, true));

        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $keywordDao = new\App\Http\Model\KeywordDAO();
        $companySid = $request->session()->get("companySid");
        $keywordSid = $request->session()->get("keywordSid");
        \Log::debug(__METHOD__."---companySid--->". $companySid);
        \Log::debug(__METHOD__."---keywordSid--->". $keywordSid);

        // 引数がもっと多くなったら配列にした方がいいかも
        if($keywordSid) {
            $result = $keywordDao->updateKeyword($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid, $keywordSid);
            if($result === "success") {
                $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
                $resultDTO->setResults("登録が完了しました");
                $request->session()->forget("keywordSid");
            } else {
                $resultDTO->setResults($result);
            }
        } else {
            $result = $keywordDao->insertKeyword($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid);
            if($result === "success") {
                $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
                $resultDTO->setResults("登録が完了しました");
                $request->session()->forget("keywordSid");
            } else {
                $resultDTO->setResults($result);
            }
        }
        return $resultDTO;
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function fetchKeywordAll(Request $request) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $results = $keywordDao->selectKeyword();
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        $resultDTO->setResults($results);
        return $resultDTO;
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function fetchKeywordAndUrl(Request $request, $keywordSid = null, $companySid = null) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $results["keyword"] = $keywordDao->selectKeywordForKeywordSid($keywordSid);
        if($results) {
            $results["url"] = $keywordDao->selectURLForKeywordSid($keywordSid);
            $resultDTO->setResults($results);
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
            $request->session()->put("keywordSid", $keywordSid);
            if (isset($companySid)) {
                $request->session()->put("companySid", $companySid);
            }
            return $resultDTO;
        } else {
            return $resultDTO;
        }
    }
}