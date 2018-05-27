<?php
namespace Tests\Feature\Keyword;

use Tests\TestCase;
use Illuminate\Http\Request;

// 実行コマンド
// sudo vendor/bin/phpunit ./tests/Feature/Keyword/KeywordFeatureTest.php

class KeywordFeatureTest extends TestCase {

  /**
   * 初期表示テスト
   */
    public function testInitialDisplay(){
        $response = $this->json(
            "POST",
            "/keyword/register",
            []
        );
        $response->assertStatus(200)->assertViewHasAll([
            "errors" => null,
            "inputs" => null,
        ])->assertViewHas("results", null);
    }

    /**
    * @dataProvider dataProvider
    * @param unknown $results
    */
    public function testIndex($results) {
        $response = $this->json(
            "GET",
            "/"
        );
        $response->assertStatus(200)->assertViewHasAll($results);
    }
    public function dataProvider() {
        return [
            "pattern1" => [
                [
                    "status" => 1,
                    "errors" => null,
                    "inputs" => null,
                    "results" => [
                        (object)[
                            "company_name" => "株式会社cat",
                            "target_keyword" => "猫カフェ",
                            "target_url" => "http://cat.com",
                            "detection_result_text" => "2018-03-01-16:05:08,googlePc,不正な広告www.catmocha.jpを検出しました,googleSp,不正な広告www.catmocha.jpを検出しました,不正な広告www.coorikuya.comを検出しました,yahooPc,不正な広告www.catmocha.jpを検出しました,不正な広告www.coorikuya.comを検出しました,不正な広告www.catmocha.jpを検出しました,yahooSp,不正な広告www.catmocha.jpを検出しました,不正な広告www.coorikuya.comを検出しました,不正な広告www.catmocha.jpを検出しました,",
                            "active_flag" => 1,
                            "m_company_sid" => 9,
                            "m_keyword_sid" => 7
                        ],
                        (object)[
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "いちご",
                            "target_url" => "http://hoge.com,http://fuga.com",
                            "detection_result_text" => "2018/01/29 10:11:12,正常",
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 1
                        ],
                        (object)[
                            "company_name" => "株式会社hoge",
                            "target_keyword" => "ほげ",
                            "target_url" => "http://hoge.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 1,
                            "m_keyword_sid" => 5
                        ],
                        (object)[
                            "company_name" => "株式会社fuga",
                            "target_keyword" => "ふが",
                            "target_url" => "http://fuga.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 2,
                            "m_keyword_sid" => 6
                        ],
                        (object)[
                            "company_name" => "株式会社cat",
                            "target_keyword" => "ねこ",
                            "target_url" => "http://cat.com,http://catneco.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 9,
                            "m_keyword_sid" => 4
                        ],
                        (object)[
                            "company_name" => "株式会社cat",
                            "target_keyword" => "ねこ",
                            "target_url" => "http://cat.com,http://catneco.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 9,
                            "m_keyword_sid" => 8
                        ],
                        (object)[
                            "company_name" => "株式会社cat",
                            "target_keyword" => "猫カフェ",
                            "target_url" => "http://www.catmocha.jp/",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 9,
                            "m_keyword_sid" => 66
                        ],
                        (object)[
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "りんご",
                            "target_url" => "http://apple.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 2
                        ],
                        (object)[
                            "company_name" => "株式会社piyo",
                            "target_keyword" => "ぶどう",
                            "target_url" => "http://grape.com",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 18,
                            "m_keyword_sid" => 3
                        ],
                        (object)[
                            "company_name" => "合同会社test",
                            "target_keyword" => "test",
                            "target_url" => "http://test",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 27,
                            "m_keyword_sid" => 9
                        ],
                        (object)[
                            "company_name" => "合同会社test",
                            "target_keyword" => "testtest",
                            "target_url" => "http://test",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 27,
                            "m_keyword_sid" => 10
                        ],
                        (object)[
                            "company_name" => "合同会社test",
                            "target_keyword" => "testtesttest",
                            "target_url" => "http://test",
                            "detection_result_text" => null,
                            "active_flag" => 1,
                            "m_company_sid" => 27,
                            "m_keyword_sid" => 11
                        ],
                    ],
                ]
            ]
        ];
    }

    /**
    * @dataProvider keywordProvider
    * @param unknown $companySid
    * @param unknown $results
    */
    public function testDetail($keywordSid, $companySid, $results) {
        $response = $this->json(
            "POST",
            "/keyword/detail/$keywordSid/$companySid"
        );
        $response->assertStatus(200)->assertViewHasAll($results);
    }

    public function keywordProvider() {
        return [
            "pattern1" => [
                4,
                9,
                [
                    "status" => 1,
                    "errors" => null,
                    "inputs" => null,
                    "results" => [
                        "keyword" => [
                            (object)[
                                "sid" => 4,
                                "target_keyword" => "ねこ",
                                "active_flag" => 1
                            ]
                        ],
                        "url" => [
                            (object)[
                                "target_url" => "http://cat.com",
                                "search_type" => 2,
                                "active_flag" => 1
                            ],
                            (object)[  
                                "target_url" => "http://catneco.com",
                                "search_type" => 2,
                                "active_flag" => 1
                            ]
                        ]
                    ],
                ]
            ],
            "pattern2" => [
                1000,
                4,
                [   
                    "status" => "-1",
                    "errors" => "有効なキーワードマスタSIDではありません",
                    "inputs" => null,
                    "results" => null,
                ]
            ],
            "pattern3" => [
                "",
                "",
                [   
                    "status" => 1,
                    "errors" => null,
                    "inputs" => null,
                    "results" => null,
                ]
            ],
        ];
    }


    /**
    * @dataProvider validationProvider
    * @param unknown $targetKeyword
    * @param unknown $activeFlag
    * @param unknown $targetUrl
    * @param unknown $searchType
    * @param unknown $urlActiveFlag
    * @param unknown $buttonNO
    * @param unknown $results
    */
    public function testValidation($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $buttonNo, $results) {
        \Session::put("companySid", 27);
        $response = $this->json(
            "POST",
            "/keyword/register",
            [
                "targetKeyword" => $targetKeyword, 
                "activeFlag" => $activeFlag,
                "targetUrl" => $targetUrl,
                "searchType" => $searchType,
                "urlActiveFlag" => $urlActiveFlag,
                "buttonNo" => $buttonNo
            ]
        );
        $response->assertStatus(200)->assertViewHasAll([$results]);
    }

    public function validationProvider() {
        return [
            "pattern1" => [
                "", 
                "",
                "",
                "",
                "", 
                "register", 
                [ 
                    "errors" => ["targetKeyword" => ["target keywordは必須です。"] ],
                    "inputs" => [
                            "targetKeyword" => "",
                            "activeFlag" => "",
                            "targetUrl" => "",
                            "searchType" => "",
                            "urlActiveFlag" => "",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern2" => [
                "あ", 
                "2",
                "",
                "",
                "", 
                "register", 
                [ 
                    "errors" => ["activeFlag" => ["active flagには0, 1のうちいずれかの値を指定してください。"] ],
                    "inputs" => [
                            "targetKeyword" => "あ",
                            "activeFlag" => "2",
                            "targetUrl" => "",
                            "searchType" => "",
                            "urlActiveFlag" => "",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern3" => [
                "あ", 
                "1",
                ["http://cat.com"],
                ["3"],
                "", 
                "register", 
                [ 
                    "errors" => ["searchType.0" => ["searchType.0には1, 2のうちいずれかの値を指定してください。"] ],
                    "inputs" => [
                            "targetKeyword" => "あ",
                            "activeFlag" => "1",
                            "targetUrl" => ["http://cat.com"],
                            "searchType" => ["3"],
                            "urlActiveFlag" => "",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern4" => [
                "あ", 
                "1",
                ["http://cat.com"],
                ["1"],
                ["2"], 
                "register", 
                [ 
                    "errors" => ["urlActiveFlag.0" => ["urlActiveFlag.0には0, 1のうちいずれかの値を指定してください。"] ],
                    "inputs" => [
                            "targetKeyword" => "あ",
                            "activeFlag" => "1",
                            "targetUrl" => ["http://cat.com"],
                            "searchType" => ["1"],
                            "urlActiveFlag" => ["2"],
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern5" => [
                "あ", 
                "1",
                ["http://cat.com", "cat", "neco"],
                ["1", "3", "4"],
                ["0", "2", "1"], 
                "register", 
                [ 
                    "errors" => [
                    	"searchType.1" => ["searchType.1には1, 2のうちいずれかの値を指定してください。"],
                    	"searchType.2" => ["searchType.2には1, 2のうちいずれかの値を指定してください。"],
                    	"urlActiveFlag.1" => ["urlActiveFlag.1には0, 1のうちいずれかの値を指定してください。"]
                    ],
                    "inputs" => [
                            "targetKeyword" => "あ",
                            "activeFlag" => "1",
                            "targetUrl" => ["http://cat.com", "cat", "neco"],
                            "searchType" => ["1", "3", "4"],
                            "urlActiveFlag" => ["0", "2", "1"],
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern6" => [
                "!#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~、。，．・：；？！゛゜´｀¨＾￣＿ヽヾゝゞ〃仝々〆〇ー―‐／＼～∥｜…‥‘’“”（）〔〕［］｛｝〈〉《》「」『』【】＋－±×÷＝≠＜＞≦≧∞∴♂♀°′″℃￥＄￠￡％＃＆＊＠§☆★○●◎◇◆□■△▲▽▼※〒→←↑↓〓∈∋⊆⊇⊂⊃∪∩∧∨￢⇒⇔∀∃∠⊥⌒∂∇≡≒≪≫√∽∝∵∫∬Å‰♯♭♪ΑΒΓΔΕΖΗΘΙΚΛΜΝ",
                "a",
                "ΞΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψωАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя─│┌┐┘└├┬┤┴┼━┃┏┓┛┗┣┳┫┻╋┠┯┨┷┿┝┰┥┸╂｡｢｣､･ｦｧｨｩｪｫｬｭｮｯｰｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜﾝﾞﾟ０１２３４５６７８９",
                "1",
                "1", 
                "register", 
                [ 
                    "errors" => ["activeFlag" => ["active flagには0, 1のうちいずれかの値を指定してください。"] ],
                    "inputs" => [
                            "targetKeyword" =>"!#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~、。，．・：；？！゛゜´｀¨＾￣＿ヽヾゝゞ〃仝々〆〇ー―‐／＼～∥｜…‥‘’“”（）〔〕［］｛｝〈〉《》「」『』【】＋－±×÷＝≠＜＞≦≧∞∴♂♀°′″℃￥＄￠￡％＃＆＊＠§☆★○●◎◇◆□■△▲▽▼※〒→←↑↓〓∈∋⊆⊇⊂⊃∪∩∧∨￢⇒⇔∀∃∠⊥⌒∂∇≡≒≪≫√∽∝∵∫∬Å‰♯♭♪ΑΒΓΔΕΖΗΘΙΚΛΜΝ",
                            "activeFlag" => "a",
                            "targetUrl" => "ΞΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψωАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя─│┌┐┘└├┬┤┴┼━┃┏┓┛┗┣┳┫┻╋┠┯┨┷┿┝┰┥┸╂｡｢｣､･ｦｧｨｩｪｫｬｭｮｯｰｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜﾝﾞﾟ０１２３４５６７８９",
                            "searchType" => "1",
                            "urlActiveFlag" => "1",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern7" => [
                "sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad", 
                "1",
                ["sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad"],
                ["1"],
                ["1"], 
                "register", 
                [ 
                    "errors" => [
                        "targetKeyword" => ["target keywordには255文字以下の文字列を指定してください。"],
                        "targetUrl.0" => ["targetUrl.0には255文字以下の文字列を指定してください。"]
                    ],
                    "inputs" => [
                            "targetKeyword" => "sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad",
                            "activeFlag" => "1",
                            "targetUrl" => ["sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad"],
                            "searchType" => ["1"],
                            "urlActiveFlag" => ["1"],
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            // "pattern8" => [
            //     "test_keyword", 
            //     "0",
            //     ["www.test.com"],
            //     ["1"],
            //     ["0"], 
            //     "register", 
            //     [ 
            //         "status" => 1,
            //         "errors" => null,
            //         "inputs" => null,
            //         "results" => [ 
            //             "keyword" => [
            //                 (object)[
            //                     "sid" => 150, # 随時変更する必要あり
            //                     "target_keyword" => "test_keyword",
            //                     "active_flag" => 0
            //                 ]
            //             ],
            //             "url" => [
            //                 (object)[
            //                     "target_url" => "www.test.com",
            //                     "search_type" => 1,
            //                     "active_flag" => 0
            //                 ]
            //             ]
            //         ]
            //     ]
            // ]
        ];  
    }

}
