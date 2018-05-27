<?php

namespace Tests\Unit\Company;

use Tests\TestCase;
use Illuminate\Http\Request;

// 実行コマンド
// sudo vendor/bin/phpunit ./tests/Unit/Company/CompanyDaoTest.php

class CompanyDaoTest extends TestCase {

	/**
	 * @dataProvider sidProvider01
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testcheckExsistSid($sid, $expect) {
		$companyDao = new \App\Http\Model\CompanyDAO();
		$results = $companyDao->checkExsistSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue($results === $expect);
	}
	public function sidProvider01() {
		$testCasesSid01 = [
			["sid" =>1 , "expect" => "exist"],
			["sid" =>2 , "expect" => "exist"],
			["sid" =>100 , "expect" => "not exist"],
			["sid" =>200 , "expect" => "not exist"],
			["sid" =>'1" OR 1 = 1' , "expect" => "exist"],
			["sid" =>";1" , "expect" => "not exist"],
			["sid" =>"1--" , "expect" => "exist"],
			["sid" =>"'1'" , "expect" => "not exist"],
		];
		return $testCasesSid01;
	}

	/**
	 * @dataProvider sidProvider02
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testselectCompanyForSid($sid, $expect) {
		$companyDao = new \App\Http\Model\CompanyDAO();
		$results = $companyDao->selectCompanyForSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function sidProvider02() {
		$testCasesSid02 = [
			["sid" =>1 ,"expect" => [
                        "sid" => 1,
                        "company_name" => "株式会社hoge",
                        "company_name_kana" => "カブシキガイシャホゲ",
                        "mail_address" => "hoge@hoge.com",
                        "mail_address_bcc" => "fuga@fuga.com",
                        "mail_subject" => "hoge",
                        "mail_text" => "hogehogehoge",
                        ]
			],
			["sid" =>2 ,"expect" => [
                        "sid" => 2,
                        "company_name" => "株式会社fuga",
                        "company_name_kana" => "カブシキガイシャフガ",
                        "mail_address" => "fuga@fuga.com",
                        "mail_address_bcc" => "hoge@hoge.com",
                        "mail_subject" => "fuga",
                        "mail_text" => "fugafuga",
                        ]
			],
			["sid" =>9 ,"expect" => [
                        "sid" => 9,
                        "company_name" => "株式会社cat",
                        "company_name_kana" => "カブシキガイシャキャット",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
			["sid" =>"9--" ,"expect" => [
                        "sid" => 9,
                        "company_name" => "株式会社cat",
                        "company_name_kana" => "カブシキガイシャキャット",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
			["sid" =>"9;" ,"expect" => [
                        "sid" => 9,
                        "company_name" => "株式会社cat",
                        "company_name_kana" => "カブシキガイシャキャット",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
			["sid" =>"9'" ,"expect" => [
                        "sid" => 9,
                        "company_name" => "株式会社cat",
                        "company_name_kana" => "カブシキガイシャキャット",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
		];
		return $testCasesSid02;
	}

	/**
	 * @dataProvider sidProvider02faild
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testselectCompanyForSidFaild($sid, $expect) {
		$companyDao = new \App\Http\Model\CompanyDAO();
		$results = $companyDao->selectCompanyForSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results === $expect);
	}
	public function sidProvider02faild() {
		$testCasesSid02faild = [
			["sid" =>"--9" ,"expect" => []],
			["sid" =>";9" ,"expect" => []],
			["sid" =>"'9'" ,"expect" => []],
		];
		return $testCasesSid02faild;
	}

	/**
	 * @dataProvider companyItemProvider01
	 * @param unknown $companyName
	 * @param unknown $companyNameKana
	 * @param unknown $mailAddress
	 * @param unknown $mailAddressBcc
	 * @param unknown $mailSubject
	 * @param unknown $mailText
	 * @param unknown $expect
	 */
	public function testInsertCompany($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText, $expect) {
		\DB::getpdo()->beginTransaction();
		$companyDao = new \App\Http\Model\CompanyDAO();
		$companyDao->insertCompany($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText);
		$companySid = \Session::get("companySid");
		$results = $companyDao->selectCompanyForSidForTest($companySid);
		$this->assertTrue((array)$results[0] === $expect);
		\DB::getpdo()->rollback();
	}
	public function companyItemProvider01() {
		$testCasesCompanyItems = [
			[
				"companyName" => "test", 
				"companyNameKana" => "テスト", 
				"mailAddress" => "test@test.com", 
				"mailAddressBcc" => "testtest@test.com", 
				"mailSubject" => "testSubject", 
				"mailText" => "testText",
				"expect" => [
                    "company_name" => "test",
                    "company_name_kana" => "テスト",
                    "mail_address" => "test@test.com",
                    "mail_address_bcc" => "testtest@test.com",
                    "mail_subject" => "testSubject",
                    "mail_text" => "testText",
                ]
			],
			[
				"companyName" => "test", 
				"companyNameKana" => "", 
				"mailAddress" => "", 
				"mailAddressBcc" => "", 
				"mailSubject" => "", 
				"mailText" => "",
				"expect" => [
                    "company_name" => "test",
                    "company_name_kana" => "",
                    "mail_address" => "",
                    "mail_address_bcc" => "",
                    "mail_subject" => "",
                    "mail_text" => "",
                ]
			],
			[
				"companyName" => "'hoge'", 
				"companyNameKana" => "'hoge'", 
				"mailAddress" => "'hoge'", 
				"mailAddressBcc" => "'hoge'", 
				"mailSubject" => "'hoge'", 
				"mailText" => "'hoge'",
				"expect" => [
                    "company_name" => "'hoge'",
                    "company_name_kana" => "'hoge'",
                    "mail_address" => "'hoge'",
                    "mail_address_bcc" => "'hoge'",
                    "mail_subject" => "'hoge'",
                    "mail_text" => "'hoge'",
                ]
			],
			[
				"companyName" => "--hoge", 
				"companyNameKana" => "--hoge", 
				"mailAddress" => "--hoge", 
				"mailAddressBcc" => "--hoge", 
				"mailSubject" => "--hoge", 
				"mailText" => "--hoge",
				"expect" => [
                    "company_name" => "--hoge",
                    "company_name_kana" => "--hoge",
                    "mail_address" => "--hoge",
                    "mail_address_bcc" => "--hoge",
                    "mail_subject" => "--hoge",
                    "mail_text" => "--hoge",
                ]
			],
			[
				"companyName" => ";hoge", 
				"companyNameKana" => ";hoge", 
				"mailAddress" => ";hoge", 
				"mailAddressBcc" => ";hoge", 
				"mailSubject" => ";hoge", 
				"mailText" => ";hoge",
				"expect" => [
                    "company_name" => ";hoge",
                    "company_name_kana" => ";hoge",
                    "mail_address" => ";hoge",
                    "mail_address_bcc" => ";hoge",
                    "mail_subject" => ";hoge",
                    "mail_text" => ";hoge",
                ]
			],
			[
				"companyName" => "\hoge", 
				"companyNameKana" => "\hoge", 
				"mailAddress" => "\hoge", 
				"mailAddressBcc" => "\hoge", 
				"mailSubject" => "\hoge", 
				"mailText" => "\hoge",
				"expect" => [
                    "company_name" => "\hoge",
                    "company_name_kana" => "\hoge",
                    "mail_address" => "\hoge",
                    "mail_address_bcc" => "\hoge",
                    "mail_subject" => "\hoge",
                    "mail_text" => "\hoge",
                ]
			],
		];
		return $testCasesCompanyItems;
	}

	/**
	 * @dataProvider companyItemProvider02
	 * @param unknown $companyName
	 * @param unknown $companyNameKana
	 * @param unknown $mailAddress
	 * @param unknown $mailAddressBcc
	 * @param unknown $mailSubject
	 * @param unknown $mailText
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testUpdateCompany($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText, $sid, $expect) {
		\DB::getpdo()->beginTransaction();
		$companyDao = new \App\Http\Model\CompanyDAO();
		$companyDao->updateCompany($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText, $sid);
		$results = $companyDao->selectCompanyForSid($sid);
		// \Log::debug(__METHOD__."-----results----->".print_r($results[0]));
		// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
		\DB::getpdo()->rollback();
	}
	public function companyItemProvider02() {
		$testCasesCompanyItems = [
			[
				"companyName" => "testupdated", 
				"companyNameKana" => "テストアップデイテド", 
				"mailAddress" => "test@test.com/updated", 
				"mailAddressBcc" => "testtest@test.com\updated", 
				"mailSubject" => "testSubjectupdated", 
				"mailText" => "testTextudpated",
				"sid" => 27,
				"expect" => [
                    "sid" => 27,
                    "company_name" => "testupdated",
                    "company_name_kana" => "テストアップデイテド",
                    "mail_address" => "test@test.com/updated",
                    "mail_address_bcc" => "testtest@test.com\updated",
                    "mail_subject" => "testSubjectupdated",
                    "mail_text" => "testTextudpated",
                ]
			],
			[
				"companyName" => "", 
				"companyNameKana" => "", 
				"mailAddress" => "", 
				"mailAddressBcc" => "", 
				"mailSubject" => "", 
				"mailText" => "",
				"sid" => 27,
				"expect" => [
					"sid" => 27,
                    "company_name" => "",
                    "company_name_kana" => "",
                    "mail_address" => "",
                    "mail_address_bcc" => "",
                    "mail_subject" => "",
                    "mail_text" => "",
                ]
			],
			[
				"companyName" => "'hoge'", 
				"companyNameKana" => "'hoge'", 
				"mailAddress" => "'hoge'", 
				"mailAddressBcc" => "'hoge'", 
				"mailSubject" => "'hoge'", 
				"mailText" => "'hoge'",
				"sid" => 27,
				"expect" => [
					"sid" => 27,
                    "company_name" => "'hoge'",
                    "company_name_kana" => "'hoge'",
                    "mail_address" => "'hoge'",
                    "mail_address_bcc" => "'hoge'",
                    "mail_subject" => "'hoge'",
                    "mail_text" => "'hoge'",
                ]
			],
			[
				"companyName" => "--hoge", 
				"companyNameKana" => "--hoge", 
				"mailAddress" => "--hoge", 
				"mailAddressBcc" => "--hoge", 
				"mailSubject" => "--hoge", 
				"mailText" => "--hoge",
				"sid" => 27,
				"expect" => [
					"sid" => 27,
                    "company_name" => "--hoge",
                    "company_name_kana" => "--hoge",
                    "mail_address" => "--hoge",
                    "mail_address_bcc" => "--hoge",
                    "mail_subject" => "--hoge",
                    "mail_text" => "--hoge",
                ]
			],
			[
				"companyName" => ";hoge", 
				"companyNameKana" => ";hoge", 
				"mailAddress" => ";hoge", 
				"mailAddressBcc" => ";hoge", 
				"mailSubject" => ";hoge", 
				"mailText" => ";hoge",
				"sid" => 27,
				"expect" => [
					"sid" => 27,
                    "company_name" => ";hoge",
                    "company_name_kana" => ";hoge",
                    "mail_address" => ";hoge",
                    "mail_address_bcc" => ";hoge",
                    "mail_subject" => ";hoge",
                    "mail_text" => ";hoge",
                ]
			],
			[
				"companyName" => "\hoge", 
				"companyNameKana" => "\hoge", 
				"mailAddress" => "\hoge", 
				"mailAddressBcc" => "\hoge", 
				"mailSubject" => "\hoge", 
				"mailText" => "\hoge",
				"sid" => 27,
				"expect" => [
					"sid" => 27,
                    "company_name" => "\hoge",
                    "company_name_kana" => "\hoge",
                    "mail_address" => "\hoge",
                    "mail_address_bcc" => "\hoge",
                    "mail_subject" => "\hoge",
                    "mail_text" => "\hoge",
                ]
			],
		];
		return $testCasesCompanyItems;
	}

	/**
	 * @dataProvider companyItemProvider02faild
	 * @param unknown $companyName
	 * @param unknown $companyNameKana
	 * @param unknown $mailAddress
	 * @param unknown $mailAddressBcc
	 * @param unknown $mailSubject
	 * @param unknown $mailText
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testUpdateCompanyFaild($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText, $sid, $expect) {
		\DB::getpdo()->beginTransaction();
		$companyDao = new \App\Http\Model\CompanyDAO();
		$companyDao->updateCompany($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText, $sid);
		$results = $companyDao->selectCompanyForSid($sid);
		// \Log::debug(__METHOD__."-----results----->".print_r($results[0]));
		// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results === $expect);
		\DB::getpdo()->rollback();
	}
	public function companyItemProvider02faild() {
		$testCasesCompanyItemsfaild = [
			[
				"companyName" => "testupdated", 
				"companyNameKana" => "テストアップデイテド", 
				"mailAddress" => "test@test.com/updated", 
				"mailAddressBcc" => "testtest@test.com\updated", 
				"mailSubject" => "testSubjectupdated", 
				"mailText" => "testTextudpated",
				"sid" => 7777,
				"expect" => []
			],
			[
				"companyName" => "testupdated", 
				"companyNameKana" => "テストアップデイテド", 
				"mailAddress" => "test@test.com/updated", 
				"mailAddressBcc" => "testtest@test.com\updated", 
				"mailSubject" => "testSubjectupdated", 
				"mailText" => "testTextudpated",
				"sid" => "--27",
				"expect" => []
			],
			[
				"companyName" => "testupdated", 
				"companyNameKana" => "テストアップデイテド", 
				"mailAddress" => "test@test.com/updated", 
				"mailAddressBcc" => "testtest@test.com\updated", 
				"mailSubject" => "testSubjectupdated", 
				"mailText" => "testTextudpated",
				"sid" => "'27'",
				"expect" => []
			],
			[
				"companyName" => "testupdated", 
				"companyNameKana" => "テストアップデイテド", 
				"mailAddress" => "test@test.com/updated", 
				"mailAddressBcc" => "testtest@test.com\updated", 
				"mailSubject" => "testSubjectupdated", 
				"mailText" => "testTextudpated",
				"sid" => ";27",
				"expect" => []
			],
		];
		return $testCasesCompanyItemsfaild;
	}

	/**
	 * @dataProvider keywordSidProvider01
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testselectCompanyForKeywordSid($sid, $expect) {
		$companyDao = new \App\Http\Model\CompanyDAO();
		$results = $companyDao->selectCompanyForKeywordSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function keywordSidProvider01() {
		$testCasesKeywordSid01 = [
			["sid" =>1 ,"expect" => [
                        "sid" => 18,
                        "company_name" => "株式会社piyo",
                        "mail_address" => "hoge@hoge.com",
                        "mail_address_bcc" => null,
                        "mail_subject" => "件名",
                        "mail_text" => "本文",
                        ]
			],
			["sid" =>2 ,"expect" => [
                        "sid" => 18,
                        "company_name" => "株式会社piyo",
                        "mail_address" => "hoge@hoge.com",
                        "mail_address_bcc" => null,
                        "mail_subject" => "件名",
                        "mail_text" => "本文",
                        ]
			],
			["sid" =>7 ,"expect" => [
                        "sid" => 9,
                        "company_name" => "株式会社cat",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
			["sid" =>"7--" ,"expect" => [
                        "sid" => 9,
                        "company_name" => "株式会社cat",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
			["sid" =>"7;" ,"expect" => [
                        "sid" => 9,
                        "company_name" => "株式会社cat",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
			["sid" =>"7'" ,"expect" => [
                        "sid" => 9,
                        "company_name" => "株式会社cat",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
		];
		return $testCasesKeywordSid01;
	}
	/**
	 * @dataProvider keywordSidProvider01faild
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testselectCompanyForKeywordSidFaild($sid, $expect) {
		$companyDao = new \App\Http\Model\CompanyDAO();
		$results = $companyDao->selectCompanyForKeywordSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results === $expect);
	}
	public function keywordSidProvider01faild() {
		$testCasesKeywordSid01faild = [
			["sid" =>"--7" ,"expect" => []],
			["sid" =>";7" ,"expect" => []],
			["sid" =>"'7'" ,"expect" => []],
			["sid" =>"\7" ,"expect" => []],
		];
		return $testCasesKeywordSid01faild;
	}

	/**
	 * @dataProvider sidProvider03
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testselectCompanyForSidForTest($sid, $expect) {
		$companyDao = new \App\Http\Model\CompanyDAO();
		$results = $companyDao->selectCompanyForSidForTest($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function sidProvider03() {
		$testCasesSid03 = [
			["sid" =>1 ,"expect" => [
                        "company_name" => "株式会社hoge",
                        "company_name_kana" => "カブシキガイシャホゲ",
                        "mail_address" => "hoge@hoge.com",
                        "mail_address_bcc" => "fuga@fuga.com",
                        "mail_subject" => "hoge",
                        "mail_text" => "hogehogehoge",
                        ]
			],
			["sid" =>2 ,"expect" => [
                        "company_name" => "株式会社fuga",
                        "company_name_kana" => "カブシキガイシャフガ",
                        "mail_address" => "fuga@fuga.com",
                        "mail_address_bcc" => "hoge@hoge.com",
                        "mail_subject" => "fuga",
                        "mail_text" => "fugafuga",
                        ]
			],
			["sid" =>9 ,"expect" => [
                        "company_name" => "株式会社cat",
                        "company_name_kana" => "カブシキガイシャキャット",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
			["sid" =>"9--" ,"expect" => [
                        "company_name" => "株式会社cat",
                        "company_name_kana" => "カブシキガイシャキャット",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
			["sid" =>"9;" ,"expect" => [
                        "company_name" => "株式会社cat",
                        "company_name_kana" => "カブシキガイシャキャット",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
			["sid" =>"9'" ,"expect" => [
                        "company_name" => "株式会社cat",
                        "company_name_kana" => "カブシキガイシャキャット",
                        "mail_address" => "cat@neco.com",
                        "mail_address_bcc" => "catcat@neco.com",
                        "mail_subject" => "cat",
                        "mail_text" => "catcatcatcatcat",
                        ]
			],
		];
		return $testCasesSid03;
	}

	/**
	 * @dataProvider sidProvider03faild
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testselectCompanyForSidForTestFaild($sid, $expect) {
		$companyDao = new \App\Http\Model\CompanyDAO();
		$results = $companyDao->selectCompanyForSid($sid);
			// \Log::debug(__METHOD__."-----results----->".print_r((array)$results));
			// \Log::debug(__METHOD__."-----expect----->".print_r($expect));
		$this->assertTrue((array)$results === $expect);
	}
	public function sidProvider03faild() {
		$testCasesSid03faild = [
			["sid" =>"--9" ,"expect" => []
			],
			["sid" =>";9" ,"expect" => []
			],
			["sid" =>"'9'" ,"expect" => []
			],
		];
		return $testCasesSid03faild;
	}
}