<?php

namespace App\Http\Logic\Validate;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;

class ValidateLogic extends \App\Http\Logic\BaseLogic {
    public function __construct() {
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
                "url" => "required|max:255|",
                "trackingCode" => "required|max:255|",
                "to" => "required|max:255|email",
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
}