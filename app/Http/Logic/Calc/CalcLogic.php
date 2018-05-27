<?php
namespace  App\Http\Logic\Calc;
use Illuminate\Http\Request;
use Exception;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;

class CalcLogic extends \App\Http\Logic\BaseLogic {
    public function __construct() {
    }

    public function validateCalc(Request $request) {
        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $resultDTO->setInputs($this->getRequestParameter($request));

        $foumula = $request->input('foumula');
        $fieldNumber = $request->input('fieldNumber');
        $operator = substr(($foumula), -1);
        $foumula = substr($foumula, 0, strlen($foumula)-1);

        if(isset($foumula, $fieldNumber)) {
            if(is_numeric($foumula) && is_numeric($fieldNumber)) {
                if($operator === "+" || $operator === "-" || $operator === "*" || $operator === "/") {
                    $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);
                    return $resultDTO;
                }
            }
        }
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::FAILURE);
        $resultDTO->setErrors("正しい値を入力して下さい");
        return $resultDTO;
    }

    public function calculate(Request $request) {
        $foumula =$request->input('foumula');
        $fieldNumber = floatval($request->input('fieldNumber'));

        $resultDTO = new \App\Http\Logic\LogicResultDTO();
        $resultDTO->setInputs($this->getRequestParameter($request));
        $resultDTO->setStatus(\App\Http\Logic\LogicResultDTO::SUCCESS);

        $result = $this->calculateRun($foumula, $fieldNumber);
        $resultDTO->setResults($result);
        return $resultDTO;
    }

    public function calculateRun($foumula, $fieldNumber) {
        $left = floatval($foumula);
        $operator = substr(($foumula), -1);
        try {
            switch ($operator) {
                case '+':
                    $result = $left + $fieldNumber;
                    break;
                case '-':
                    $result = $left - $fieldNumber;
                    break;
                case '*':
                    $result = $left * $fieldNumber;
                    break;
                case '/':
                    if($fieldNumber !== 0.0) {
                        $result = $left / $fieldNumber;
                    }else {
                        throw new Exception("division by zero");
                    }
                    break;
            }
            $result = round($result,3);
            if(strlen($result) > 10 ) {
                $result = "表現できる桁数を超えました";
            }
            return $result;
        }catch(Exception $e) {
            $result = "0で割ることはできません";
            return $result;
        }
    }
}