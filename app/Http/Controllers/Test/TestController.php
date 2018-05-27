<?php

namespace App\Http\Controllers\Test;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TestController extends Controller
{
	/**
	 * 検索アクション
	 * @param Request $request
	 */
	public function search(Request $request)
	{
		\Log::info(__METHOD__);

		$logic = new \App\Http\Logic\Test\TestLogic;
		// エラーチェック
		$results = $logic->validateSearch($request);

		if ($results->getStatus() === \App\Http\Logic\LogicResultDTO::SUCCESS) {
			// エラー出ない場合は検索を実行する
			$results = $logic->search($request);
			// VIEW用の配列に詰めて終了
			return view("test/test/search", $results->getForView($request));
		} else {
			// エラーの場合、エラー内容をVIEW用の配列を詰めて終了
			return view("test/test/search", $results->getForView($request));
		}
	}

	/**
	 * 登録アクション
	 * @param Request $request
	 */
	public function register(Request $request)
	{
		\Log::info(__METHOD__);

		$logic = new \App\Http\Logic\Test\TestLogic;
		// エラーチェック
		$results = $logic->validateRegister($request);
		if ($results->getStatus() === \App\Http\Logic\LogicResultDTO::SUCCESS) {
			// エラー出ない場合は検索を実行する
			$results = $logic->search($request);
			// VIEW用の配列に詰めて終了
			return view("test/test/register", $results->getForView($request));
		} else {
			// エラーの場合、エラー内容をVIEW用の配列を詰めて終了
			return view("test/test/register", $results->getForView($request));
		}
	}
    
}