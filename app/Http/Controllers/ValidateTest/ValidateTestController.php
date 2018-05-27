<?php

namespace App\Http\Controllers\ValidateTest;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ValidateTestController extends Controller
{
    /**
     * 登録アクション
     * @param Request $request
     */
    public function register(Request $request)
    {
        \Log::info(__METHOD__);

        $logic = new \App\Http\Logic\ValidateTest\ValidateTestLogic;
        // エラーチェック
        $results = $logic->validateCheck($request);
        if ($results->getStatus() === \App\Http\Logic\LogicResultDTO::SUCCESS) {
            // エラー出ない場合は検索を実行する
            $results = $logic->register($request);
            // VIEW用の配列に詰めて終了
            return view("validatetest/validatetest", $results->getForView($request));
        } else {
            // エラーの場合、エラー内容をVIEW用の配列を詰めて終了
            return view("validatetest/validatetest", $results->getForView($request));
        }
    }
    /**
     * 登録アクション
     * @param Request $request
     */
    public function userlist(Request $request) {
        $logic = new \App\Http\Logic\ValidateTest\ValidateTestLogic;
        $results = $logic->userlist($request);
        return view("validatetest/userlist", $results->getForView($request));
    }
 }