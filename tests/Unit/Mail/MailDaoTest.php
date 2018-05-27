<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use Illuminate\Http\Request;

// 実行コマンド
// sudo vendor/bin/phpunit ./tests/Unit/Mail/MailDaoTest.php

class MailDaoTest extends TestCase {
	/**
	 * @dataProvider itemProvider01
	 * @param unknown $mailAddress
	 * @param unknown $mailAddressBcc
	 * @param unknown $mailSubject
	 * @param unknown $mailText
	 * @param unknown $detectionLogSid
	 * @param unknown $expect
	 */
	public function testInsertLog($mailAddress, $mailAddressBcc, $mailSubject, $mailText, $detectionLogSid, $expect) {
		\DB::getpdo()->beginTransaction();
		$mailDao = new \App\Http\Model\MailDAO();
		$mailLogSid = $mailDao->insertLog($mailAddress, $mailAddressBcc, $mailSubject, $mailText, $detectionLogSid);
		$results = $mailDao->selectAllForSidForTest($mailLogSid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
		\DB::getpdo()->rollback();
	}
	public function itemProvider01() {
		$testCases = [
			[
				"mailAddress" => "test_mail_address",
				"mailAddressBcc" => "test_mail_address_bcc",
				"mailSubject" => "test_mail_subject",
				"mailText" => "test_mail_text",
				"detectionLogSid" => 40,
				"expect" => [
					"mail_address" => "test_mail_address",
					"mail_address_bcc" => "test_mail_address_bcc",
					"mail_subject" => "test_mail_subject",
					"mail_text" => "test_mail_text",
				]
			],
			[
				"mailAddress" => "test_mail_address--",
				"mailAddressBcc" => "test_mail_address_bcc--",
				"mailSubject" => "test_mail_subject--",
				"mailText" => "test_mail_text--",
				"detectionLogSid" => 40,
				"expect" => [
					"mail_address" => "test_mail_address--",
					"mail_address_bcc" => "test_mail_address_bcc--",
					"mail_subject" => "test_mail_subject--",
					"mail_text" => "test_mail_text--",
				]
			],
			[
				"mailAddress" => "test_mail_address;",
				"mailAddressBcc" => "test_mail_address_bcc;",
				"mailSubject" => "test_mail_subject;",
				"mailText" => "test_mail_text;",
				"detectionLogSid" => 40,
				"expect" => [
					"mail_address" => "test_mail_address;",
					"mail_address_bcc" => "test_mail_address_bcc;",
					"mail_subject" => "test_mail_subject;",
					"mail_text" => "test_mail_text;",
				]
			],
			[
				"mailAddress" => "'test_mail_address'",
				"mailAddressBcc" => "'test_mail_address_bcc'",
				"mailSubject" => "'test_mail_subject'",
				"mailText" => "'test_mail_text'",
				"detectionLogSid" => 40,
				"expect" => [
					"mail_address" => "'test_mail_address'",
					"mail_address_bcc" => "'test_mail_address_bcc'",
					"mail_subject" => "'test_mail_subject'",
					"mail_text" => "'test_mail_text'",
				]
			],
		];
		return $testCases;
	}

	/**
	 * @dataProvider itemProvider02
	 * @param unknown $detectionLogSid
	 * @param unknown $expect
	 */
	public function testSelectText($detectionLogSid, $expect) {
		$mailDao = new \App\Http\Model\MailDAO();
		$results = $mailDao->selectText($detectionLogSid);
			// \Log::debug(__METHOD__."-----results----->".var_dump((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".var_dump($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function itemProvider02() {
		$testCases = [
			[
				"detectionLogSid" => 47,
				"expect" => [
					"mail_address" => "ishiguro@secm.jp",
					"mail_address_bcc" => "",
					"mail_subject" => "キーワード「猫カフェ」で不正な出稿が検出されました。",
					"mail_text" => "testtest"
				]
			],
			[
				"detectionLogSid" => "47;",
				"expect" => [
					"mail_address" => "ishiguro@secm.jp",
					"mail_address_bcc" => "",
					"mail_subject" => "キーワード「猫カフェ」で不正な出稿が検出されました。",
					"mail_text" => "testtest"
				]
			],
			[
				"detectionLogSid" => "47--",
				"expect" => [
					"mail_address" => "ishiguro@secm.jp",
					"mail_address_bcc" => "",
					"mail_subject" => "キーワード「猫カフェ」で不正な出稿が検出されました。",
					"mail_text" => "testtest"
				]
			],
			[
				"detectionLogSid" => "47'",
				"expect" => [
					"mail_address" => "ishiguro@secm.jp",
					"mail_address_bcc" => "",
					"mail_subject" => "キーワード「猫カフェ」で不正な出稿が検出されました。",
					"mail_text" => "testtest"
				]
			],
		];
		return $testCases;
	}

	/**
	 * @dataProvider itemProvider02faild
	 * @param unknown $detectionLogSid
	 * @param unknown $expect
	 */
	public function testSelectTextFaild($detectionLogSid, $expect) {
		$mailDao = new \App\Http\Model\MailDAO();
		$results = $mailDao->selectText($detectionLogSid);
			// \Log::debug(__METHOD__."-----results----->".var_dump((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".var_dump($expect));
		$this->assertTrue((array)$results === $expect);
	}
	public function itemProvider02faild() {
		$testCases = [
			[
				"mailLogSid" => "--47",
				"expect" => []
			],
			[
				"mailLogSid" => ";47",
				"expect" => []
			],
			[
				"mailLogSid" => "'47'",
				"expect" => []
			],
		];
		return $testCases;
	}

	/**
	 * @dataProvider itemProvider03
	 * @param unknown $mailLogSid
	 * @param unknown $expect
	 */
	public function testSelectAllForSidForTest($mailLogSid, $expect) {
		$mailDao = new \App\Http\Model\MailDAO();
		$results = $mailDao->selectAllForSidForTest($mailLogSid);
			// \Log::debug(__METHOD__."-----results----->".var_dump((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".var_dump($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function itemProvider03() {
		$testCases = [
			[
				"mailLogSid" => 4,
				"expect" => [
					"mail_address" => "ishiguro@secm.jp",
					"mail_address_bcc" => "",
					"mail_subject" => "キーワード「猫カフェ」で不正な出稿が検出されました。",
					"mail_text" => "testtest"
				]
			],
			[
				"mailLogSid" => "4--",
				"expect" => [
					"mail_address" => "ishiguro@secm.jp",
					"mail_address_bcc" => "",
					"mail_subject" => "キーワード「猫カフェ」で不正な出稿が検出されました。",
					"mail_text" => "testtest"
				]
			],
			[
				"mailLogSid" => "4;",
				"expect" => [
					"mail_address" => "ishiguro@secm.jp",
					"mail_address_bcc" => "",
					"mail_subject" => "キーワード「猫カフェ」で不正な出稿が検出されました。",
					"mail_text" => "testtest"
				]
			],
			[
				"mailLogSid" => "4'",
				"expect" => [
					"mail_address" => "ishiguro@secm.jp",
					"mail_address_bcc" => "",
					"mail_subject" => "キーワード「猫カフェ」で不正な出稿が検出されました。",
					"mail_text" => "testtest"
				]
			],
		];
		return $testCases;
	}

	/**
	 * @dataProvider itemProvider03faild
	 * @param unknown $mailLogSid
	 * @param unknown $expect
	 */
	public function testSelectAllForSidForTestFaild($mailLogSid, $expect) {
		$mailDao = new \App\Http\Model\MailDAO();
		$results = $mailDao->selectAllForSidForTest($mailLogSid);
			// \Log::debug(__METHOD__."-----results----->".var_dump((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".var_dump($expect));
		$this->assertTrue((array)$results === $expect);
	}
	public function itemProvider03faild() {
		$testCases = [
			[
				"mailLogSid" => "--4",
				"expect" => []
			],
			[
				"mailLogSid" => ";4",
				"expect" => []
			],
			[
				"mailLogSid" => "'4'",
				"expect" => []
			],
		];
		return $testCases;
	}

	/**
	 * @dataProvider mailitemProvider
	 * @param unknown $mailAddress
	 * @param unknown $expect
	 */
	public function testSelectStackMail($mailAddress, $expect) {
		$mailDao = new \App\Http\Model\MailDAO();
		$results = $mailDao->selectStackMail($mailAddress);
			// \Log::debug(__METHOD__."-----results----->".var_dump((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".var_dump($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function mailitemProvider() {
		$testCases = [
			[
				"mailAddress" => "test_mail_address",
				"expect" => [
					"mail_address" => "test_mail_address",
					"mail_address_bcc" => "test_mail_address_bcc",
					"mail_subject" => "test_mail_subject",
					"mail_text" => "test_mail_text",
				]
			]
		];
		return $testCases;
	}

	/**
	 * @dataProvider mailitemProvider02
	 * @param unknown $mailAddress
	 * @param unknown $expect
	 */
	public function testSelectAllStackMail($mailAddress, $expect) {
		$mailDao = new \App\Http\Model\MailDAO();
		$results = $mailDao->selectAllStackMail($mailAddress);
			// \Log::debug(__METHOD__."-----results----->".var_dump((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".var_dump($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function mailitemProvider02() {
		$testCases = [
			[
				"mailAddress" => "test_mail_address",
				"expect" => [
					"mail_address" => "test_mail_address",
					"mail_address_bcc" => "test_mail_address_bcc",
					"mail_subject" => "test_mail_subject",
					"mail_text" => "test_mail_text",
				]
			]
		];
		return $testCases;
	}

	/**
	 * @dataProvider mailitemProvider03
	 * @param unknown $mailAddress
	 * @param unknown $mailAddressBcc
	 * @param unknown $mailSubject
	 * @param unknown $mailText
	 * @param unknown $expect
	 */
	public function testStackMail($mailAddress, $mailAddressBcc, $mailSubject, $mailText, $expect) {
		\DB::getpdo()->beginTransaction();
		$mailDao = new \App\Http\Model\MailDAO();
		$mailDao->stackMail($mailAddress, $mailAddressBcc, $mailSubject, $mailText);
		$results = $mailDao->selectStackMail($mailAddress); 
		$this->assertTrue((array)$results[0] === $expect);
		\DB::getpdo()->rollback();
	}
	public function mailitemProvider03() {
		$testCases = [
			[
				"mailAddress" => "test_mail_address",
				"mailAddressBcc" => "test_mail_address_bcc",
				"mailSubject" => "test_mail_subject",
				"mailText" => "test_mail_text_updated",
				"expect" => [
					"mail_address" => "test_mail_address",
					"mail_address_bcc" => "test_mail_address_bcc",
					"mail_subject" => "test_mail_subject",
					"mail_text" => "test_mail_text_updated",
				]
			],
			[
				"mailAddress" => "test_mail_address",
				"mailAddressBcc" => "test_mail_address_bcc",
				"mailSubject" => "test_mail_subject",
				"mailText" => "test_mail_text_updated--",
				"expect" => [
					"mail_address" => "test_mail_address",
					"mail_address_bcc" => "test_mail_address_bcc",
					"mail_subject" => "test_mail_subject",
					"mail_text" => "test_mail_text_updated--",
				]
			],
			[
				"mailAddress" => "test_mail_address",
				"mailAddressBcc" => "test_mail_address_bcc",
				"mailSubject" => "test_mail_subject",
				"mailText" => "test_mail_text_updated\\",
				"expect" => [
					"mail_address" => "test_mail_address",
					"mail_address_bcc" => "test_mail_address_bcc",
					"mail_subject" => "test_mail_subject",
					"mail_text" => "test_mail_text_updated\\",
				]
			],
			[
				"mailAddress" => "test_mail_address",
				"mailAddressBcc" => "test_mail_address_bcc",
				"mailSubject" => "test_mail_subject",
				"mailText" => "test_mail_text_updated;",
				"expect" => [
					"mail_address" => "test_mail_address",
					"mail_address_bcc" => "test_mail_address_bcc",
					"mail_subject" => "test_mail_subject",
					"mail_text" => "test_mail_text_updated;",
				]
			],
			[
				"mailAddress" => "test_mail_address",
				"mailAddressBcc" => "test_mail_address_bcc",
				"mailSubject" => "test_mail_subject",
				"mailText" => "'test_mail_text_updated'",
				"expect" => [
					"mail_address" => "test_mail_address",
					"mail_address_bcc" => "test_mail_address_bcc",
					"mail_subject" => "test_mail_subject",
					"mail_text" => "'test_mail_text_updated'",
				]
			]
		];
		return $testCases;
	}

	/**
	 * @dataProvider mailitemProvider04
	 * @param unknown $mailAddress
	 * @param unknown $expect
	 */
	public function testDeleteStackMail($mailAddress, $expect) {
		\DB::getpdo()->beginTransaction();
		$mailDao = new \App\Http\Model\MailDAO();
		$mailDao->deleteStackMail($mailAddress);
		$results = $mailDao->selectStackMail($mailAddress);
			// \Log::debug(__METHOD__."-----results----->".var_dump((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".var_dump($expect));
		$this->assertTrue((array)$results === $expect);
		\DB::getpdo()->rollback();
	}
	public function mailitemProvider04() {
		$testCases = [
			[
				"mailAddress" => "test_mail_address",
				"expect" => []
			],
			[
				"mailAddress" => "test_mail_address--",
				"expect" => []
			],
			[
				"mailAddress" => "test_mail_address;",
				"expect" => []
			],
			[
				"mailAddress" => "'test_mail_address'",
				"expect" => []
			]
		];
		return $testCases;
	}
}