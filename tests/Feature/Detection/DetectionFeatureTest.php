<?php
namespace Tests\Feature\Detection;

use Tests\TestCase;
use Illuminate\Http\Request;

// 実行コマンド
// sudo vendor/bin/phpunit ./tests/Feature/Detection/DetectionFeatureTest.php

class DetectionFeatureTest extends TestCase {

	/**
    * @dataProvider historyDataProvider
    * @param unknown $keywordSid
    * @param unknown $results
    */
	public function testHistory($keywordSid, $results) {
		$response = $this->json(
            "POST",
            "/detection/history/$keywordSid"
        );
        $response->assertStatus(200)->assertViewHasAll($results);
	}

	public function historyDataProvider() {
		return [
	   		"pattern1" => [
				1,
				[
					"status" => 1,
					"errors" => null,
					"inputs" => null,
					"results" => [
						(object)[
							"sid" => 2,
							"detection_result_text" => "2018/01/29 10:11:12,正常",
						]
					]
				]
	   		],
	   		"pattern2" => [
				2,
				[
					"status" => "-1",
					"errors" => null,
					"inputs" => null,
					"results" => null
				]
	   		],
	   		"pattern3" => [
				"",
				[
					"status" => 1,
					"errors" => null,
					"inputs" => null,
					"results" => null
				]
	   		],
		];
	}


	/**
    * @dataProvider detailDataProvider
    * @param unknown $detectionLogSid
    * @param unknown $results
    */
	public function testDetail($detectionLogSid, $results) {
		$response = $this->json(
            "POST",
            "/detection/detail/$detectionLogSid"
        );
        $response->assertStatus(200)->assertViewHasAll($results);
	}

	public function detailDataProvider() {
		return [
	   		"pattern1" => [
				2,
				[
					"status" => 1,
					"errors" => null,
					"inputs" => null,
					"results" => [
						(object)[
							"sid" => 2,
							"detection_result_text" => "2018/01/29 10:11:12,正常",
							"image_url_google_pc" => null,
							"image_url_google_sp" => null,
							"image_url_yahoo_pc" => null,
							"image_url_yahoo_sp" => null,
							"mail_address" => "aa",
							"mail_address_bcc" => null,
							"mail_subject" => null,
							"mail_text" => null
						],
						(object)[
							"sid" => 2,
							"detection_result_text" => "2018/01/29 10:11:12,正常",
							"image_url_google_pc" => null,
							"image_url_google_sp" => null,
							"image_url_yahoo_pc" => null,
							"image_url_yahoo_sp" => null,
							"mail_address" => "hoge",
							"mail_address_bcc" => null,
							"mail_subject" => null,
							"mail_text" => null
						]
					]
				]
	   		],
	   		"pattern2" => [
				1000,
				[
					"status" => 1,
					"errors" => null,
					"inputs" => null,
					"results" => null
				]
	   		],
	   		"pattern3" => [
				"",
				[
					"status" => 1,
					"errors" => null,
					"inputs" => null,
					"results" => null
				]
	   		],
		];

	}
}	