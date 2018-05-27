<?php

namespace Tests\Unit\Keyword;

use Tests\TestCase;
use Illuminate\Http\Request;

// 実行コマンド
// sudo vendor/bin/phpunit ./tests/Unit/Keyword/KeywordDaoTest.php

class KeywordDaoTest extends TestCase {

	/**
	 * @dataProvider sidProvider01
	 * @param unknown $sid
	 * @param unknown $expect
	 */
	public function testcheckExsistSid($sid, $expect) {
		$keywordDao = new \App\Http\Model\KeywordDAO();
		$results = $keywordDao->checkExsistSid($sid);
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
	public function testselectKeywordForCompanySid($sid, $expect) {
		$keywordDao = new \App\Http\Model\KeywordDAO();
		$results = $keywordDao->selectKeywordForCompanySid($sid);
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function sidProvider02() {
		$testCasesSid02 = [
			["sid" =>1 ,"expect" => [
                        "company_name" => "株式会社hoge",
                        "target_keyword" => "ほげ",
                        "target_url" => "http://hoge.com",
                        "detection_result_text" => null,
                        "active_flag" => 1,
                        "m_company_sid" => 1,
                        "m_keyword_sid" => 5,
                        ]
			],
			["sid" =>2 ,"expect" => [
                        "company_name" => "株式会社fuga",
                        "target_keyword" => "ふが",
                        "target_url" => "http://fuga.com",
                        "detection_result_text" => null,
                        "active_flag" => 1,
                        "m_company_sid" => 2,
                        "m_keyword_sid" => 6,
                        ]
			],
			["sid" =>18 ,"expect" => [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "いちご",
                            "target_url" => "http://hoge.com,http://fuga.com",
                            "detection_result_text" => "2018/01/29 10:11:12,正常",
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 1,
                        ],
                        [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "りんご",
                            "target_url" => "http://apple.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 2,
                        ],
                        [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "ぶどう",
                            "target_url" => "http://grape.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 3,
                        ],
			],
            ["sid" =>"18--" ,"expect" => [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "いちご",
                            "target_url" => "http://hoge.com,http://fuga.com",
                            "detection_result_text" => "2018/01/29 10:11:12,正常",
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 1,
                        ],
                        [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "りんご",
                            "target_url" => "http://apple.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 2,
                        ],
                        [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "ぶどう",
                            "target_url" => "http://grape.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 3,
                        ],
            ],
            ["sid" =>"18;" ,"expect" => [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "いちご",
                            "target_url" => "http://hoge.com,http://fuga.com",
                            "detection_result_text" => "2018/01/29 10:11:12,正常",
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 1,
                        ],
                        [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "りんご",
                            "target_url" => "http://apple.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 2,
                        ],
                        [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "ぶどう",
                            "target_url" => "http://grape.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 3,
                        ],
            ],
            ["sid" =>"18'" ,"expect" => [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "いちご",
                            "target_url" => "http://hoge.com,http://fuga.com",
                            "detection_result_text" => "2018/01/29 10:11:12,正常",
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 1,
                        ],
                        [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "りんご",
                            "target_url" => "http://apple.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 2,
                        ],
                        [
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "ぶどう",
                            "target_url" => "http://grape.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 3,
                        ],
            ]
		];
		return $testCasesSid02;
	}

    /**
     * @dataProvider sidProvider02faild
     * @param unknown $sid
     * @param unknown $expect
     */
    public function testselectKeywordForCompanySidFaild($sid, $expect) {
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $results = $keywordDao->selectKeywordForCompanySid($sid);
        $this->assertTrue((array)$results === $expect);
    }
    public function sidProvider02faild() {
        $testCasesSid02faild = [
            ["sid" =>"--1" ,"expect" => []],
            ["sid" =>";1" ,"expect" => []],
            ["sid" =>"'1'" ,"expect" => []],
        ];
        return $testCasesSid02faild;
    }

    /**
     * @dataProvider sidProvider04
     * @param unknown $sid
     * @param unknown $expect
     */
    public function testselectUrlForKeywordSid($sid, $expect) {
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $results = $keywordDao->selectUrlForKeywordSid($sid);
        // \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
        // \Log::debug(__METHOD__."-----expect----->".print_r($expect));
        $this->assertTrue((array)$results[0] === $expect);
    }
    public function sidProvider04() {
        $testCasesSid04 = [
            ["sid" =>1 ,"expect" => [
                            "target_url" => "http://hoge.com",
                            "search_type" => 2,
                            "active_flag" => 1,
                        ],
                        [
                            "target_url" => "http://fuga.com",
                            "search_type" => 1,
                            "active_flag" => 1,
                        ]
            ],
            ["sid" =>2 ,"expect" => [
                        "target_url" => "http://apple.com",
                        "search_type" => 1,
                        "active_flag" => 0,
                        ]
            ],
            ["sid" =>3 ,"expect" => [
                        "target_url" => "http://grape.com",
                        "search_type" => 1,
                        "active_flag" => 0,
                        ]
            ],
            ["sid" =>"3--" ,"expect" => [
                        "target_url" => "http://grape.com",
                        "search_type" => 1,
                        "active_flag" => 0,
                        ]
            ],
            ["sid" =>"3;" ,"expect" => [
                        "target_url" => "http://grape.com",
                        "search_type" => 1,
                        "active_flag" => 0,
                        ]
            ],
            ["sid" =>"3'" ,"expect" => [
                        "target_url" => "http://grape.com",
                        "search_type" => 1,
                        "active_flag" => 0,
                        ]
            ],
        ];
        return $testCasesSid04;
    }

    /**
     * @dataProvider sidProvider04faild
     * @param unknown $sid
     * @param unknown $expect
     */
    public function testselectUrlForKeywordSidFaild($sid, $expect) {
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $results = $keywordDao->selectUrlForKeywordSid($sid);
        // \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
        // \Log::debug(__METHOD__."-----expect----->".print_r($expect));
        $this->assertTrue((array)$results === $expect);
    }
    public function sidProvider04faild() {
        $testCasesSid04faild = [
            ["sid" =>";3" ,"expect" => []],
            ["sid" =>"--3" ,"expect" => []],
            ["sid" =>"'3'" ,"expect" => []],
        ];
        return $testCasesSid04faild;
    }

    /**
     * @dataProvider sidProvider03
     * @param unknown $sid
     * @param unknown $expect
     */
    public function testselectKeywordForKeywordSid($sid, $expect) {
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $results = $keywordDao->selectKeywordForKeywordSid($sid);
        $this->assertTrue((array)$results[0] === $expect);
    }
    public function sidProvider03() {
        $testCasesSid03 = [
            ["sid" =>1 ,"expect" => [
                        "sid" => 1,
                        "target_keyword" => "いちご",
                        "active_flag" => 1,
                        ]
            ],
            ["sid" =>2 ,"expect" => [
                        "sid" => 2,
                        "target_keyword" => "りんご",
                        "active_flag" => 1,
                        ]
            ],
            ["sid" =>3 ,"expect" => [
                        "sid" => 3,
                        "target_keyword" => "ぶどう",
                        "active_flag" => 1,
                        ]
            ],
            ["sid" =>4 ,"expect" => [
                        "sid" => 4,
                        "target_keyword" => "ねこ",
                        "active_flag" => 1,
                        ]
            ],
            ["sid" =>"4--" ,"expect" => [
                        "sid" => 4,
                        "target_keyword" => "ねこ",
                        "active_flag" => 1,
                        ]
            ],
            ["sid" =>"4;" ,"expect" => [
                        "sid" => 4,
                        "target_keyword" => "ねこ",
                        "active_flag" => 1,
                        ]
            ],
            ["sid" =>"4'" ,"expect" => [
                        "sid" => 4,
                        "target_keyword" => "ねこ",
                        "active_flag" => 1,
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
    public function testselectKeywordForKeywordSidFaild($sid, $expect) {
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $results = $keywordDao->selectKeywordForKeywordSid($sid);
        $this->assertTrue((array)$results === $expect);
    }
    public function sidProvider03faild() {
        $testCasesSid03faild = [
            ["sid" =>"--1" ,"expect" => []],
            ["sid" =>";1" ,"expect" => []],
            ["sid" =>"'1'" ,"expect" => []],
        ];
        return $testCasesSid03faild;
    }

	/**
	 * @dataProvider dataProvider
	 * @param unknown $expect
	 */
	public function testselectKeyword($expect) {
		$keywordDao = new \App\Http\Model\KeywordDAO();
		$results = $keywordDao->selectKeyword();
		$this->assertTrue((array)$results[0] === $expect);
	}
	public function dataProvider() {
		$testCases = [
			["expect" => 
  				[
                    "company_name" => "株式会社cat",
                    "target_keyword" => "猫カフェ",
                    "target_url" => "http://cat.com",
                    "detection_result_text" => "2018-03-01-16:05:08,googlePc,不正な広告www.catmocha.jpを検出しました,googleSp,不正な広告www.catmocha.jpを検出しました,不正な広告www.coorikuya.comを検出しました,yahooPc,不正な広告www.catmocha.jpを検出しました,不正な広告www.coorikuya.comを検出しました,不正な広告www.catmocha.jpを検出しました,yahooSp,不正な広告www.catmocha.jpを検出しました,不正な広告www.coorikuya.comを検出しました,不正な広告www.catmocha.jpを検出しました,",
                    "active_flag" => 1,
                    "m_company_sid" => 9,
                    "m_keyword_sid" => 7,
  				],
                [
                    "company_name" => "株式会社piyo",
                    "target_keyword" => "いちご",
                    "target_url" => "http://hoge.com,http://fuga.com",
                    "detection_result_text" => "2018/01/29 10:11:12 正常",
                    "active_flag" => 1,
                    "m_company_sid" => 18,
                    "m_keyword_sid" => 1,
                ],
                [
                    "company_name" => "株式会社hoge",
                    "target_keyword" => "ほげ",
                    "target_url" => "http://hoge.com",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                    "m_keyword_sid" => 5,
                ],
                [
                    "company_name" => "株式会社fuga",
                    "target_keyword" => "ふが",
                    "target_url" => "http://fuga.com",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 2,
                    "m_keyword_sid" => 6,
                ],
                [
                    "company_name" => "株式会社cat",
                    "target_keyword" => "ねこ",
                    "target_url" => "http://cat.com,http://catneco.com",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 9,
                    "m_keyword_sid" => 4,
                ],
  				[
                    "company_name" => "株式会社cat",
                    "target_keyword" => "ねこ",
                    "target_url" => "http://cat.com,http://catneco.com",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 9,
                    "m_keyword_sid" => 8,
  				],
                [
                    "company_name" => "株式会社cat",
                    "target_keyword" => "猫カフェ",
                    "target_url" => "http://catmocha.jp/",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 9,
                    "m_keyword_sid" => 66,
                ],
  				[
                    "company_name" => "株式会社piyo",
                    "target_keyword" => "りんご",
                    "target_url" => "http://apple.com",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 18,
                    "m_keyword_sid" => 2,
  				],
  				[
                    "company_name" => "株式会社piyo",
                    "target_keyword" => "ぶどう",
                    "target_url" => "http://grape.com",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 18,
                    "m_keyword_sid" => 3,
  				],
  				[
                    "company_name" => "合同会社test",
                    "target_keyword" => "test",
                    "target_url" => "http://test",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 27,
                    "m_keyword_sid" => 9,
  				],
  				[
                    "company_name" => "合同会社test",
                    "target_keyword" => "testtest",
                    "target_url" => "http://test",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 27,
                    "m_keyword_sid" => 10,
  				],
  				[
                    "company_name" => "合同会社test",
                    "target_keyword" => "testtesttest",
                    "target_url" => "http://test",
                    "detection_result_text" => "",
                    "active_flag" => 1,
                    "m_company_sid" => 27,
                    "m_keyword_sid" => 11,
  				],
			],
		];
		return $testCases;
	}

    /**
     * @dataProvider keywordItemProvider01
     * @param unknown $targetKeyword
     * @param unknown $activeFlag
     * @param unknown $targetUrl
     * @param unknown $searchType
     * @param unknown $urlActiveFlag
     * @param unknown $companySid
     * @param unknown $expect
     */
    public function testInsertKeyword($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid, $expect) {
        \DB::getpdo()->beginTransaction();
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $keywordDao->insertkeyword($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid);
        $keywordSid = \Session::get("keywordSid");
        $results = $keywordDao->selectKeywordForKeywordSidForTest($keywordSid);
        // \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
        // \Log::debug(__METHOD__."-----expect----->".print_r($expect));
        $this->assertTrue((array)$results[0] === $expect);
        \DB::getpdo()->rollback();
    }
    public function keywordItemProvider01() {
        $testCasesKeywordItems = [
            [
                "targetKeyword" => "test", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "expect" => [
                    "target_keyword" => "test",
                    "active_flag" => 1,
                    "target_url" => "http://test",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => "test", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test", "http://testtest"], 
                "searchType" => [1, 2], 
                "urlActiveFlag" => [1, 0], 
                "companySid" => 1,
                "expect" => [
                    "target_keyword" => "test",
                    "active_flag" => 1,
                    "target_url" => "http://test",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ], 
                [
                    "target_keyword" => "test",
                    "active_flag" => 1,
                    "target_url" => "http://testtest",
                    "search_type" => 2,
                    "active_flag" => 0,
                    "m_company_sid" => 1,
                ], 
            ],
            [
                "targetKeyword" => "test--", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test--"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "expect" => [
                    "target_keyword" => "test--",
                    "active_flag" => 1,
                    "target_url" => "http://test--",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => "test;", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test;"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "expect" => [
                    "target_keyword" => "test;",
                    "active_flag" => 1,
                    "target_url" => "http://test;",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => "test'", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test'"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "expect" => [
                    "target_keyword" => "test'",
                    "active_flag" => 1,
                    "target_url" => "http://test'",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => ";test", 
                "activeFlag" => 1, 
                "targetUrl" => [";http://test"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "expect" => [
                    "target_keyword" => ";test",
                    "active_flag" => 1,
                    "target_url" => ";http://test",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => "--test", 
                "activeFlag" => 1, 
                "targetUrl" => ["--http://test"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "expect" => [
                    "target_keyword" => "--test",
                    "active_flag" => 1,
                    "target_url" => "--http://test",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
        ];
        return $testCasesKeywordItems;
    }
     /**
     * @dataProvider keywordItemProvider01faild
     * @param unknown $targetKeyword
     * @param unknown $activeFlag
     * @param unknown $targetUrl
     * @param unknown $searchType
     * @param unknown $urlActiveFlag
     * @param unknown $companySid
     * @param unknown $expect
     */
    public function testInsertKeywordFaild($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid, $expect) {
        \DB::getpdo()->beginTransaction();
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $keywordDao->insertkeyword($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid);
        $keywordSid = \Session::get("keywordSid");
        $results = $keywordDao->selectKeywordForKeywordSidForTest($keywordSid);
        // \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
        // \Log::debug(__METHOD__."-----expect----->".print_r($expect));
        $this->assertTrue((array)$results === $expect);
        \DB::getpdo()->rollback();
    }
    public function keywordItemProvider01faild() {
        $testCasesKeywordItemsfaild = [
            [
                "targetKeyword" => "test", 
                "activeFlag" => "test", 
                "targetUrl" => ["http://test"], 
                "searchType" => ["test"], 
                "urlActiveFlag" => ["test"], 
                "companySid" => "test",
                "expect" => []
            ],
            [
                "targetKeyword" => "--test", 
                "activeFlag" => "--test", 
                "targetUrl" => ["--http://test"], 
                "searchType" => ["--test"], 
                "urlActiveFlag" => ["--test"], 
                "companySid" => "--test",
                "expect" => []
            ],
            [
                "targetKeyword" => ";test", 
                "activeFlag" => ";test", 
                "targetUrl" => [";http://test"], 
                "searchType" => [";test"], 
                "urlActiveFlag" => [";test"], 
                "companySid" => 111111,
                "expect" => []
            ],
        ];
        return $testCasesKeywordItemsfaild;
    }


    /**
     * @dataProvider keywordItemProvider02
     * @param unknown $targetKeyword
     * @param unknown $activeFlag
     * @param unknown $targetUrl
     * @param unknown $searchType
     * @param unknown $urlActiveFlag
     * @param unknown $companySid
     * @param unknown $keywordSid
     * @param unknown $expect
     */
    public function testUpdateKeyword($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid, $keywordSid, $expect) {
        \DB::getpdo()->beginTransaction();
        $keywordDao = new \App\Http\Model\KeywordDAO();
        $keywordDao->updatekeyword($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid, $keywordSid);
        $results = $keywordDao->selectKeywordForKeywordSidForTest($keywordSid);
        // \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
        // \Log::debug(__METHOD__."-----expect----->".print_r($expect));
        $this->assertTrue((array)$results[0] === $expect);
        \DB::getpdo()->rollback();
    }
    public function keywordItemProvider02() {
        $testCasesKeywordItems = [
            [
                "targetKeyword" => "test", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "keywordSid" => 5,
                "expect" => [
                    "target_keyword" => "test",
                    "active_flag" => 1,
                    "target_url" => "http://test",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => "test", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test", "http://testtest"], 
                "searchType" => [1, 2], 
                "urlActiveFlag" => [1, 0], 
                "companySid" => 1,
                "keywordSid" => 5,
                "expect" => [
                    "target_keyword" => "test",
                    "active_flag" => 1,
                    "target_url" => "http://test",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ], 
                [
                    "target_keyword" => "test",
                    "active_flag" => 1,
                    "target_url" => "http://testtest",
                    "search_type" => 2,
                    "active_flag" => 0,
                    "m_company_sid" => 1,
                ], 
            ],
            [
                "targetKeyword" => "test--", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test--"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "keywordSid" => 5,
                "expect" => [
                    "target_keyword" => "test--",
                    "active_flag" => 1,
                    "target_url" => "http://test--",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => "test;", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test;"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "keywordSid" => 5,
                "expect" => [
                    "target_keyword" => "test;",
                    "active_flag" => 1,
                    "target_url" => "http://test;",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => "test'", 
                "activeFlag" => 1, 
                "targetUrl" => ["http://test'"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "keywordSid" => 5,
                "expect" => [
                    "target_keyword" => "test'",
                    "active_flag" => 1,
                    "target_url" => "http://test'",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => ";test", 
                "activeFlag" => 1, 
                "targetUrl" => [";http://test"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "keywordSid" => 5,
                "expect" => [
                    "target_keyword" => ";test",
                    "active_flag" => 1,
                    "target_url" => ";http://test",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => "--test", 
                "activeFlag" => 1, 
                "targetUrl" => ["--http://test"], 
                "searchType" => [1], 
                "urlActiveFlag" => [1], 
                "companySid" => 1,
                "keywordSid" => 5,
                "expect" => [
                    "target_keyword" => "--test",
                    "active_flag" => 1,
                    "target_url" => "--http://test",
                    "search_type" => 1,
                    "active_flag" => 1,
                    "m_company_sid" => 1,
                ]
            ],
            [
                "targetKeyword" => "", 
                "activeFlag" => "", 
                "targetUrl" => [""], 
                "searchType" => [""], 
                "urlActiveFlag" => [""], 
                "companySid" => "",
                "keywordSid" => "",
                "expect" => [
                    "target_keyword" => "",
                    "active_flag" => "",
                    "target_url" => "",
                    "search_type" => "",
                    "active_flag" => "",
                    "m_company_sid" => "",
                ]
            ],
        ];
        return $testCasesKeywordItems;
    }

}