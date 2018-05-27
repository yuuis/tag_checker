<?php

namespace App\Http\Logic\Company;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;

class CompanyLogic extends \App\Http\Logic\BaseLogic {
    public function __construct() {
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validateCompanySid(Request $request, $companySid) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $companyDao = new \App\Http\Model\CompanyDAO();
        $result = $companyDao->checkExsistSid($companySid);
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
    public function fetchCompany(Request $request, $companySid) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $companyDao = new \App\Http\Model\CompanyDAO();
        $results = $companyDao->selectCompanyForSid($companySid);
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        $resultDTO->setResults($results);
        return $resultDTO;
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function fetchCompanyAndKeywords(Request $request, $companySid) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $companyDao = new \App\Http\Model\CompanyDAO();
        $results["company"] = $companyDao->selectCompanyForSid($companySid);
        if ($results) {
            $keyworddao = new \App\Http\Model\KeywordDAO();
            $results["keyword"] = $keyworddao->selectKeywordForCompanySid($companySid);
            $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
            $resultDTO->setResults($results);
            $request->session()->put('companySid', $companySid);
            return $resultDTO;
        } else {
            return $resultDTO;
        }
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function validateInputs(Request $request) {
        \Log::info(__METHOD__);
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $resultDTO->setInputs($this->getRequestParameter($request));
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
        $buttonNo = $request->get(\Config::get("const.ORIGN_BUTTON_NO_NAME"));
        if ($buttonNo === \Config::get("const.ORIGN_BUTTON_NO_NAME_REGISTER")) {
            $inputs = $request->all();
            $rules = [
                "companyName" => "required|max:255",
                "companyNameKana" => "nullable|max:255|katakana",
                "mailAddress" => "nullable|max:255|email",
                "mailAddressBcc" => "nullable|max:255|email",
                "mailSubject" => "nullable|max:255",
                "mailText" => "nullable"
            ];
            $validation = \Validator::make($inputs, $rules);
            if($validation->fails()) {

                $errors = json_decode($validation->errors(), true);
                $resultDTO->setErrors($errors);
                \Log::debug(__METHOD__ . "-----errors----->" . print_r($errors, true));
                $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
            }
        }
        return $resultDTO;
    }

    /**
     * @param Request $request
     * @return \App\Http\Logic\LogicResultDTO
     */
    public function registerCompany(Request $request) {
        \Log::info(__METHOD__);

        $companyName = $request->input("companyName");
        $companyNameKana = $request->input("companyNameKana");
        $mailAddress = $request->input("mailAddress");
        $mailAddressBcc = $request->input("mailAddressBcc");
        $mailSubject = $request->input("mailSubject");
        $mailText = $request->input("mailText");

        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $dao = new\App\Http\Model\CompanyDAO();
        $companySid = $request->session()->get("companySid");
        if(isset($companySid)) {
            $result = $dao->updateCompany($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText, $companySid);
            if($result === "success") {
                $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
                $resultDTO->setResults($result);
            } else {
                $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
                $resultDTO->setResults($result);
            }
        } else {
            $result = $dao->insertCompany($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText);
            if($result === "success") {
                $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
                $resultDTO->setResults($result);
            } else {
                $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
                $resultDTO->setResults($result);
            }
        }
        return $resultDTO;
    }
}