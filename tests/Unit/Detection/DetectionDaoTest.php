<?php

namespace Tests\Unit\Detection;

use Tests\TestCase;
use Illuminate\Http\Request;

// 実行コマンド
// sudo vendor/bin/phpunit ./tests/Unit/Detection/DetectionDaoTest.php

class DetectionDaoTest extends TestCase {
	/**
	 * @dataProvider sidProvider01
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testcheckExsistSid($sid, $expect) {
		$detectionDao = new \App\Http\Model\DetectionDAO();
		$results = $detectionDao->checkExsistSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue($results === $expect);
	}
	public function sidProvider01() {
		$testCasesSid01 = [
			["sid" =>2 , "expect" => "exist"],
			["sid" =>3 , "expect" => "exist"],
			["sid" =>100 , "expect" => "not exist"],
			["sid" =>200 , "expect" => "not exist"],
			["sid" =>'2" OR 1 = 1' , "expect" => "exist"],
			["sid" =>";2" , "expect" => "not exist"],
			["sid" =>"2--" , "expect" => "exist"],
			["sid" =>"'2'" , "expect" => "not exist"],
		];
		return $testCasesSid01;
	}

	/**
	 * @dataProvider keywordSidProvider01
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testSelectHistoryForSid($sid, $expect) {
		$detectionDao = new \App\Http\Model\DetectionDAO();
		$results = $detectionDao->selectHistoryForSid($sid);
			// \Log::debug(__METHOD__."-----results----->".var_dump((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".var_dump($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function keywordSidProvider01() {
		$testCasesKeywordSid01 = [
			["sid" =>1, "expect" => [
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常"]
			],
			["sid" =>"1--", "expect" => [
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常"]
			],
			["sid" =>"1;", "expect" => [
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常"]
			],
			["sid" =>"1'", "expect" => [
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常"]
			],
		];
		return $testCasesKeywordSid01;
	}

	/**
	 * @dataProvider keywordSidProvider01faild
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testSelectHistoryForSidFaild($sid, $expect) {
		$detectionDao = new \App\Http\Model\DetectionDAO();
		$results = $detectionDao->selectHistoryForSid($sid);
			// \Log::debug(__METHOD__."-----results----->".var_dump((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".var_dump($expect));
		$this->assertTrue((array)$results === $expect);
	}
	public function keywordSidProvider01faild() {
		$testCasesKeywordSid01faild = [
			["sid" =>null, "expect" => []],
			["sid" =>"--1", "expect" => []],
			["sid" =>";1", "expect" => []],
			["sid" =>"'2'", "expect" => []],
		];
		return $testCasesKeywordSid01faild;
	}

	/**
	 * @dataProvider detectionLogSidProvider01
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testSelectDetailForSid($sid, $expect) {
		$detectionDao = new \App\Http\Model\DetectionDAO();
		$results = $detectionDao->selectDetailForSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function detectionLogSidProvider01() {
		$testCasesdetectionLogSid01 = [
			["sid" =>2, "expect" => [
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null,
				"mail_address" => "aa",
				"mail_address_bcc" => null,
				"mail_subject" => null,
				"mail_text"=> null,
				],
				[
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null,
				"mail_address" => "aa",
				"mail_address_bcc" => "'",
				"mail_subject" => null,
				"mail_text"=> null,
				],
			],
			["sid" =>"2--", "expect" => [
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null,
				"mail_address" => "aa",
				"mail_address_bcc" => null,
				"mail_subject" => null,
				"mail_text"=> null,
				],
				[
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null,
				"mail_address" => "aa",
				"mail_address_bcc" => "'",
				"mail_subject" => null,
				"mail_text"=> null,
				],
			],
			["sid" =>"2;", "expect" => [
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null,
				"mail_address" => "aa",
				"mail_address_bcc" => null,
				"mail_subject" => null,
				"mail_text"=> null,
				],
				[
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null,
				"mail_address" => "aa",
				"mail_address_bcc" => "'",
				"mail_subject" => null,
				"mail_text"=> null,
				],
			],
			["sid" =>"2'", "expect" => [
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null,
				"mail_address" => "aa",
				"mail_address_bcc" => null,
				"mail_subject" => null,
				"mail_text"=> null,
				],
				[
				"sid" => 2,
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null,
				"mail_address" => "aa",
				"mail_address_bcc" => "'",
				"mail_subject" => null,
				"mail_text"=> null,
				],
			],
		];
		return $testCasesdetectionLogSid01;
	}

	/**
	 * @dataProvider detectionLogSidProvider01faild
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testSelectDetailForSidFaild($sid, $expect) {
		$detectionDao = new \App\Http\Model\DetectionDAO();
		$results = $detectionDao->selectDetailForSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results === $expect);
	}
	public function detectionLogSidProvider01faild() {
		$testCasesdetectionLogSid01faild = [
			["sid" =>";2", "expect" => []],
			["sid" =>"--2", "expect" => []],
			["sid" =>"'2'", "expect" => []],
		];
		return $testCasesdetectionLogSid01faild;
	}

	/**
	 * @dataProvider LogItemProvider01
	 * @param unknown $keywordSid
	 * @param unknown $keyword
	 * @param unknown $date
	 * @param unknown $expect
	 */
	public function testInsertNomalLog($keywordSid, $keyword, $date, $expect) {
		\DB::getpdo()->beginTransaction();
		$detectionDao = new \App\Http\Model\DetectionDao();
		$detectionLogSid = $detectionDao->insertNomalLog($keywordSid, $keyword, $date);
		$results = $detectionDao->selectDetailForSidForTest($detectionLogSid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
		\DB::getpdo()->rollback();
	}
	public function LogItemProvider01() {
		$testCasesLogItems = [
			[	"keywordSid" => 1, 
				"keyword" => "いちご", 
				"date" => "2018/03/02 00:00:00", 
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00,正常",
					"image_url_google_pc"=> null,
					"image_url_google_sp"=> null,
					"image_url_yahoo_pc"=> null,
					"image_url_yahoo_sp"=> null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご--", 
				"date" => "2018/03/02 00:00:00--", 
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00--,正常",
					"image_url_google_pc"=> null,
					"image_url_google_sp"=> null,
					"image_url_yahoo_pc"=> null,
					"image_url_yahoo_sp"=> null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご;", 
				"date" => "2018/03/02 00:00:00;", 
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00;,正常",
					"image_url_google_pc"=> null,
					"image_url_google_sp"=> null,
					"image_url_yahoo_pc"=> null,
					"image_url_yahoo_sp"=> null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご'", 
				"date" => "2018/03/02 00:00:00'", 
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00',正常",
					"image_url_google_pc"=> null,
					"image_url_google_sp"=> null,
					"image_url_yahoo_pc"=> null,
					"image_url_yahoo_sp"=> null,
                ]
			],
		];
		return $testCasesLogItems;
	}

	/**
	 * @dataProvider LogItemProvider02
	 * @param unknown $keywordSid
	 * @param unknown $keyword
	 * @param unknown $date
	 * @param unknown $expect
	 */
	public function testUpdateNomalLog($keywordSid, $keyword, $date, $expect) {
		\DB::getpdo()->beginTransaction();
		$detectionDao = new \App\Http\Model\DetectionDao();
		$detectionDao->updateNomalLog($keywordSid, $keyword, $date);
		$results = $detectionDao->selectDetailForKeywordSidForTest($keywordSid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
		\DB::getpdo()->rollback();
	}
	public function LogItemProvider02() {
		$testCasesLogItems = [
			[	"keywordSid" => 1, 
				"keyword" => "いちご", 
				"date" => "2018/03/02 00:00:00", 
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00,正常",
					"image_url_google_pc"=> null,
					"image_url_google_sp"=> null,
					"image_url_yahoo_pc"=> null,
					"image_url_yahoo_sp"=> null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご--", 
				"date" => "2018/03/02 00:00:00--", 
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00--,正常",
					"image_url_google_pc"=> null,
					"image_url_google_sp"=> null,
					"image_url_yahoo_pc"=> null,
					"image_url_yahoo_sp"=> null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご;", 
				"date" => "2018/03/02 00:00:00;", 
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00;,正常",
					"image_url_google_pc"=> null,
					"image_url_google_sp"=> null,
					"image_url_yahoo_pc"=> null,
					"image_url_yahoo_sp"=> null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご'", 
				"date" => "2018/03/02 00:00:00'", 
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00',正常",
					"image_url_google_pc"=> null,
					"image_url_google_sp"=> null,
					"image_url_yahoo_pc"=> null,
					"image_url_yahoo_sp"=> null,
                ]
			],
		];
		return $testCasesLogItems;
	}

	/**
	 * @dataProvider LogItemProvider03
	 * @param unknown $keywordSid
	 * @param unknown $keyword
	 * @param unknown $date
	 * @param unknown $strangeUrls
	 * @param unknown $screenShots
	 * @param unknown $expect
	 */
	public function testInsertAbNomalLog($keywordSid, $keyword, $date, $strangeUrls, $screenShots, $expect) {
		\DB::getpdo()->beginTransaction();
		$detectionDao = new \App\Http\Model\DetectionDao();
		$detectionLogSid = $detectionDao->insertAbNomalLog($keywordSid, $keyword, $date, $strangeUrls, $screenShots);
		$results = $detectionDao->selectDetailForSidForTest($detectionLogSid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
		\DB::getpdo()->rollback();
	}
	public function LogItemProvider03() {
		$testCasesLogItems = [
			[	"keywordSid" => 1, 
				"keyword" => "いちご", 
				"date" => "2018/03/02 00:00:00", 
				"strangeUrls" => [
					"googlePc" => ["www.hoge.jp"],
				],
				"screenShots" => [
					"googlePc" => "/var/www/html/strage/2018-03-02/hoge.png",
				],
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00,googlePc,不正な広告www.hoge.jpを検出しました,",
					"image_url_google_pc"=> "/var/www/html/strage/2018-03-02/hoge.png",
					"image_url_google_sp"=> null,
					"image_url_yahoo_pc"=> null,
					"image_url_yahoo_sp"=> null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご", 
				"date" => "2018/03/02 00:00:00", 
				"strangeUrls" => [
					"googlePc" => ["www.hoge.jp", "www.fuga.jp"],
					"googleSp" => ["www.hoge.jp"],
					"yahooPc" => ["www.hoge.jp"],
					"yahooSp" => ["www.hoge.jp"],
				],
				"screenShots" => [
					"googlePc" => "/var/www/html/strage/2018-03-02/hoge.png",
					"googleSp" => "/var/www/html/strage/2018-03-02/hoge.png",
					"yahooPc" => "/var/www/html/strage/2018-03-02/hoge.png",
					"yahooSp" => "/var/www/html/strage/2018-03-02/hoge.png",
				],
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00,googlePc,不正な広告www.hoge.jpを検出しました,不正な広告www.fuga.jpを検出しました,googleSp,不正な広告www.hoge.jpを検出しました,yahooPc,不正な広告www.hoge.jpを検出しました,yahooSp,不正な広告www.hoge.jpを検出しました,",
					"image_url_google_pc" => "/var/www/html/strage/2018-03-02/hoge.png",
					"image_url_google_sp" => "/var/www/html/strage/2018-03-02/hoge.png",
					"image_url_yahoo_pc" => "/var/www/html/strage/2018-03-02/hoge.png",
					"image_url_yahoo_sp" => "/var/www/html/strage/2018-03-02/hoge.png",
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご;", 
				"date" => "2018/03/02 00:00:00;", 
				"strangeUrls" => [
					"googlePc" => ["www.hoge.jp;"],
				],
				"screenShots" => [
					"googlePc" => "/var/www/html/strage/2018-03-02/hoge.png;",
				],
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00;,googlePc,不正な広告www.hoge.jp;を検出しました,",
					"image_url_google_pc" => "/var/www/html/strage/2018-03-02/hoge.png;",
					"image_url_google_sp" => null,
					"image_url_yahoo_pc" => null,
					"image_url_yahoo_sp" => null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご--", 
				"date" => "2018/03/02 00:00:00--", 
				"strangeUrls" => [
					"googlePc" => ["www.hoge.jp--"],
				],
				"screenShots" => [
					"googlePc" => "/var/www/html/strage/2018-03-02/hoge.png--",
				],
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00--,googlePc,不正な広告www.hoge.jp--を検出しました,",
					"image_url_google_pc" => "/var/www/html/strage/2018-03-02/hoge.png--",
					"image_url_google_sp" => null,
					"image_url_yahoo_pc" => null,
					"image_url_yahoo_sp" => null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "'いちご'", 
				"date" => "'2018/03/02 00:00:00'", 
				"strangeUrls" => [
					"googlePc" => ["'www.hoge.jp'"],
				],
				"screenShots" => [
					"googlePc" => "'/var/www/html/strage/2018-03-02/hoge.png'",
				],
				"expect" => [
					"detection_result_text" => "'2018/03/02 00:00:00',googlePc,不正な広告'www.hoge.jp'を検出しました,",
					"image_url_google_pc" => "'/var/www/html/strage/2018-03-02/hoge.png'",
					"image_url_google_sp" => null,
					"image_url_yahoo_pc" => null,
					"image_url_yahoo_sp" => null,
                ]
			],

		];
		return $testCasesLogItems;
	}

	/**
	 * @dataProvider LogItemProvider04
	 * @param unknown $keywordSid
	 * @param unknown $keyword
	 * @param unknown $date
	 * @param unknown $strangeUrls
	 * @param unknown $screenShots
	 * @param unknown $expect
	 */
	public function testUpdateAbNomalLog($keywordSid, $keyword, $date, $strangeUrls, $screenShots, $expect) {
		\DB::getpdo()->beginTransaction();
		$detectionDao = new \App\Http\Model\DetectionDao();
		$detectionDao->updateAbNomalLog($keywordSid, $keyword, $date, $strangeUrls, $screenShots);
		$results = $detectionDao->selectDetailForKeywordSidForTest($keywordSid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
		\DB::getpdo()->rollback();
	}
	public function LogItemProvider04() {
		$testCasesLogItems = [
			[	"keywordSid" => 1, 
				"keyword" => "いちご", 
				"date" => "2018/03/02 00:00:00", 
				"strangeUrls" => [
					"googlePc" => ["www.hoge.jp"],
				],
				"screenShots" => [
					"googlePc" => "/var/www/html/strage/2018-03-02/hoge.png",
				],
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00,googlePc,不正な広告www.hoge.jpを検出しました,",
					"image_url_google_pc" => "/var/www/html/strage/2018-03-02/hoge.png",
					"image_url_google_sp" => null,
					"image_url_yahoo_pc" => null,
					"image_url_yahoo_sp" => null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご", 
				"date" => "2018/03/02 00:00:00", 
				"strangeUrls" => [
					"googlePc" => ["www.hoge.jp", "www.fuga.jp"],
					"googleSp" => ["www.hoge.jp"],
					"yahooPc" => ["www.hoge.jp"],
					"yahooSp" => ["www.hoge.jp"],
				],
				"screenShots" => [
					"googlePc" => "/var/www/html/strage/2018-03-02/hoge.png",
					"googleSp" => "/var/www/html/strage/2018-03-02/hoge.png",
					"yahooPc" => "/var/www/html/strage/2018-03-02/hoge.png",
					"yahooSp" => "/var/www/html/strage/2018-03-02/hoge.png",
				],
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00,googlePc,不正な広告www.hoge.jpを検出しました,不正な広告www.fuga.jpを検出しました,googleSp,不正な広告www.hoge.jpを検出しました,yahooPc,不正な広告www.hoge.jpを検出しました,yahooSp,不正な広告www.hoge.jpを検出しました,",
					"image_url_google_pc" => "/var/www/html/strage/2018-03-02/hoge.png",
					"image_url_google_sp" => "/var/www/html/strage/2018-03-02/hoge.png",
					"image_url_yahoo_pc" => "/var/www/html/strage/2018-03-02/hoge.png",
					"image_url_yahoo_sp" => "/var/www/html/strage/2018-03-02/hoge.png",
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご;", 
				"date" => "2018/03/02 00:00:00;", 
				"strangeUrls" => [
					"googlePc" => ["www.hoge.jp;"],
				],
				"screenShots" => [
					"googlePc" => "/var/www/html/strage/2018-03-02/hoge.png;",
				],
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00;,googlePc,不正な広告www.hoge.jp;を検出しました,",
					"image_url_google_pc" => "/var/www/html/strage/2018-03-02/hoge.png;",
					"image_url_google_sp" => null,
					"image_url_yahoo_pc" => null,
					"image_url_yahoo_sp" => null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "いちご--", 
				"date" => "2018/03/02 00:00:00--", 
				"strangeUrls" => [
					"googlePc" => ["www.hoge.jp--"],
				],
				"screenShots" => [
					"googlePc" => "/var/www/html/strage/2018-03-02/hoge.png--",
				],
				"expect" => [
					"detection_result_text" => "2018/03/02 00:00:00--,googlePc,不正な広告www.hoge.jp--を検出しました,",
					"image_url_google_pc" => "/var/www/html/strage/2018-03-02/hoge.png--",
					"image_url_google_sp" => null,
					"image_url_yahoo_pc" => null,
					"image_url_yahoo_sp" => null,
                ]
			],
			[	"keywordSid" => 1, 
				"keyword" => "'いちご'", 
				"date" => "'2018/03/02 00:00:00'", 
				"strangeUrls" => [
					"googlePc" => ["'www.hoge.jp'"],
				],
				"screenShots" => [
					"googlePc" => "'/var/www/html/strage/2018-03-02/hoge.png'",
				],
				"expect" => [
					"detection_result_text" => "'2018/03/02 00:00:00',googlePc,不正な広告'www.hoge.jp'を検出しました,",
					"image_url_google_pc" => "'/var/www/html/strage/2018-03-02/hoge.png'",
					"image_url_google_sp" => null,
					"image_url_yahoo_pc" => null,
					"image_url_yahoo_sp" => null,
                ]
			],

		];
		return $testCasesLogItems;
	}


	/**
	 * @dataProvider LogItemProvider05
	 * @param unknown $detectionLogSid
	 * @param unknown $expect
	 */
	public function testSelectImagePath($detectionLogSid, $expect) {
		\DB::getpdo()->beginTransaction();
		$detectionDao = new \App\Http\Model\DetectionDao();
		$results = $detectionDao->selectImagePath($detectionLogSid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
		\DB::getpdo()->rollback();
	}
	public function LogItemProvider05() {
		$testCasesLogItems = [
			[	"detectionLogSid" => 2, 
				"expect" => [
					"image_url_google_pc" => null,
					"image_url_google_sp" => null,
					"image_url_yahoo_pc" => null,
					"image_url_yahoo_sp" => null,
                ]
			],
			[	"detectionLogSid" => 50, 
				"expect" => [
					"image_url_google_pc" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-GooglePc-2018-02-28-17:07:50.png",
					"image_url_google_sp" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-GoogleSp-2018-02-28-17:07:57.png",
					"image_url_yahoo_pc" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-YahooPc-2018-02-28-17:08:02.png",
					"image_url_yahoo_sp" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-YahooPc-2018-02-28-17:08:09.png",
                ]
			],
			[	"detectionLogSid" => "50--", 
				"expect" => [
					"image_url_google_pc" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-GooglePc-2018-02-28-17:07:50.png",
					"image_url_google_sp" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-GoogleSp-2018-02-28-17:07:57.png",
					"image_url_yahoo_pc" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-YahooPc-2018-02-28-17:08:02.png",
					"image_url_yahoo_sp" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-YahooPc-2018-02-28-17:08:09.png",
                ]
			],
			[	"detectionLogSid" => "50;", 
				"expect" => [
					"image_url_google_pc" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-GooglePc-2018-02-28-17:07:50.png",
					"image_url_google_sp" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-GoogleSp-2018-02-28-17:07:57.png",
					"image_url_yahoo_pc" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-YahooPc-2018-02-28-17:08:02.png",
					"image_url_yahoo_sp" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-YahooPc-2018-02-28-17:08:09.png",
                ]
			],
			[	"detectionLogSid" => "50'", 
				"expect" => [
					"image_url_google_pc" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-GooglePc-2018-02-28-17:07:50.png",
					"image_url_google_sp" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-GoogleSp-2018-02-28-17:07:57.png",
					"image_url_yahoo_pc" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-YahooPc-2018-02-28-17:08:02.png",
					"image_url_yahoo_sp" => "/var/www/html/storage/tmp/2018-02-28/猫カフェ-YahooPc-2018-02-28-17:08:09.png",
                ]
			],
			
		];
		return $testCasesLogItems;
	}

	/**
	 * @dataProvider LogItemProvider05faild
	 * @param unknown $detectionLogSid
	 * @param unknown $expect
	 */
	public function testSelectImagePathFaild($detectionLogSid, $expect) {
		\DB::getpdo()->beginTransaction();
		$detectionDao = new \App\Http\Model\DetectionDao();
		$results = $detectionDao->selectImagePath($detectionLogSid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results === $expect);
		\DB::getpdo()->rollback();
	}
	public function LogItemProvider05faild() {
		$testCasesLogItemsfaild = [
			["detectionLogSid" => ";2", "expect" => []],
			["detectionLogSid" => "--2", "expect" => []],
			["detectionLogSid" => "'2'", "expect" => []],
			
		];
		return $testCasesLogItemsfaild;
	}

	/**
	 * @dataProvider detectionLogSidProvider02
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testSelectDetailForSidForTest($sid, $expect) {
		$detectionDao = new \App\Http\Model\DetectionDAO();
		$results = $detectionDao->selectDetailForSidForTest($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function detectionLogSidProvider02() {
		$testCasesdetectionLogSid01 = [
			["sid" =>2, "expect" => [
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				],
				[
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				]
			],
			["sid" =>"2--", "expect" => [
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				],
				[
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				]
			],
			["sid" =>"2;", "expect" => [
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				],
				[
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				]
			],
			["sid" =>"2'", "expect" => [
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				],
				[
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				]
			]
		];
		return $testCasesdetectionLogSid01;
	}

	/**
	 * @dataProvider detectionLogSidProvider02faild
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testSelectDetailForSidForTestFaild($sid, $expect) {
		$detectionDao = new \App\Http\Model\DetectionDAO();
		$results = $detectionDao->selectDetailForSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results === $expect);
	}
	public function detectionLogSidProvider02faild() {
		$testCasesdetectionLogSid01faild = [
			["sid" =>";2", "expect" => []],
			["sid" =>"--2", "expect" => []],
			["sid" =>"'2'", "expect" => []],
		];
		return $testCasesdetectionLogSid01faild;
	}

	/**
	 * @dataProvider keywordSidProvider02
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testSelectDetailForKeywordSidForTest($sid, $expect) {
		$detectionDao = new \App\Http\Model\DetectionDAO();
		$results = $detectionDao->selectDetailForKeywordSidForTest($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function keywordSidProvider02() {
		$testCasesdetectionLogSid01 = [
			["sid" => 1, "expect" => [
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				],
				[
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				]
			],
			["sid" => "1--", "expect" => [
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				],
				[
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				]
			],
			["sid" => "1;", "expect" => [
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				],
				[
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				]
			],
			["sid" => "1'", "expect" => [
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				],
				[
				"detection_result_text" => "2018/01/29 10:11:12,正常",
				"image_url_google_pc"=> null,
				"image_url_google_sp"=> null,
				"image_url_yahoo_pc"=> null,
				"image_url_yahoo_sp"=> null
				]
			]
		];
		return $testCasesdetectionLogSid01;
	}

	/**
	 * @dataProvider keywordSidProvider02faild
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testSelectDetailForKeywordSidForTestFaild($sid, $expect) {
		$detectionDao = new \App\Http\Model\DetectionDAO();
		$results = $detectionDao->selectDetailForKeywordSidForTest($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results === $expect);
	}
	public function keywordSidProvider02faild() {
		$testCasesdetectionLogSid01faild = [
			["sid" => ";1", "expect" => []],
			["sid" => "--1", "expect" => []],
			["sid" => "'1'", "expect" => []],
		];
		return $testCasesdetectionLogSid01faild;
	}

}