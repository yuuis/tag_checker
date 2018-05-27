<?php

namespace App\Http\Controllers\Calc;

use App\Http\Controllers\Controller;
use \App\Http\Logic\Calc\CalcLogic;
use Illuminate\Http\Request;

class CalcController extends Controller {
    public function calculate(Request $request) {
        $logic = new \App\Http\Logic\Calc\CalcLogic;
        $results = $logic->validateCalc($request);
        if ($results->getStatus() === \App\Http\Logic\LogicResultDTO::SUCCESS) {
          $results = $logic->calculate($request);
          return view("calc/result", $results->getForView($request));
        }else {
          return view("calc/result", $results->getForView($request));
        }
    }
}
