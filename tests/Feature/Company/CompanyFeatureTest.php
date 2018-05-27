<?php
namespace Tests\Feature\Company;

use Tests\TestCase;
use Illuminate\Http\Request;

// 実行コマンド
// sudo vendor/bin/phpunit ./tests/Feature/Company/CompanyFeatureTest.php

class CompanyFeatureTest extends TestCase {

  /**
   * 初期表示テスト
   */
  public function testInitialDisplay(){
    $response = $this->json(
        "POST",
        "/company/detail",
        []
    );
    $response->assertStatus(200)->assertViewHasAll([
        "errors" => null,
        "inputs" => null,
    ])->assertViewHas("results", null);
  }


  /**
    * @dataProvider companyItemProvider
    * @param unknown $companySid
    * @param unknown $results
    */
    public function testDetail($companySid, $results) {
        $response = $this->json(
            "POST",
            "/company/detail/$companySid"
        );
        $response->assertStatus(200)->assertViewHasAll($results);
    }

     public function companyItemProvider() {
        return [
            "pattern1" => [
                27, 
                [ 
                    "status" => 1,
                    "errors" => null,
                    "inputs" => null,
                    "results" => [
                        "company" => [
                            (object)[ "sid" => 27,
                                "company_name" => "合同会社test",
                                "company_name_kana" => null,
                                "mail_address" => null,
                                "mail_address_bcc" => null,
                                "mail_subject" => null,
                                "mail_text" => null
                            ],
                        ],
                        "keyword" => [
                            (object)[   "company_name" => "合同会社test",
                                "target_keyword" => "test",
                                "target_url" => "http://test",
                                "detection_result_text" => null,
                                "active_flag" => 1,
                                "m_company_sid" => 27,
                                "m_keyword_sid" => 9
                            ],
                            (object)[   "company_name" => "合同会社test",
                                "target_keyword" => "testtest",
                                "target_url" => "http://test",
                                "detection_result_text" => null,
                                "active_flag" => 1,
                                "m_company_sid" => 27,
                                "m_keyword_sid" => 10
                            ],
                            (object)[   "company_name" => "合同会社test",
                                "target_keyword" => "testtesttest",
                                "target_url" => "http://test",
                                "detection_result_text" => null,
                                "active_flag" => 1,
                                "m_company_sid" => 27,
                                "m_keyword_sid" => 11
                            ],
                        ]
                    ]
                ]
            ],
            "pattern2" => [
                100, 
                [ 
                    "status" => "-1",
                    "errors" => "有効な企業マスタSIDではありません",
                    "inputs" => null,
                    "results" => null, 

                ]
            ],
            "pattern3" => [
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
    * @param unknown $companyName
    * @param unknown $companyNameKana
    * @param unknown $mailAddress
    * @param unknown $mailAddressBcc
    * @param unknown $mailSubject
    * @param unknown $mailText
    * @param unknown $buttonNo
    * @param unknown $results
    */
    public function testValidation($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText, $buttonNo, $results) {
        $response = $this->json(
            "POST",
            "/company/register",
            [
                "companyName" => $companyName, 
                "companyNameKana" => $companyNameKana,
                "mailAddress" => $mailAddress,
                "mailAddressBcc" => $mailAddressBcc,
                "mailSubject" => $mailSubject,
                "mailText" => $mailText,
                "buttonNo" => $buttonNo
            ]
        );
        $response->assertStatus(200)->assertViewHasAll($results);
    }

     public function validationProvider() {
        return [
            "pattern1" => [
                "", 
                "",
                "",
                "",
                "",
                "", 
                "register", 
                [ 
                    "errors" => ["companyName" => ["company nameは必須です。"] ],
                    "inputs" => [
                            "companyName" => "",
                            "companyNameKana" => "",
                            "mailAddress" => "",
                            "mailAddressBcc" => "",
                            "mailSubject" => "",
                            "mailText" => "",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern2" => [
                "あ", 
                "あ",
                "",
                "",
                "",
                "", 
                "register", 
                [ 
                    "errors" => ["companyNameKana" => ["company name kanaにはカタカナを指定してください。"] ],
                    "inputs" => [
                            "companyName" => "あ",
                            "companyNameKana" => "あ",
                            "mailAddress" => "",
                            "mailAddressBcc" => "",
                            "mailSubject" => "",
                            "mailText" => "",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern3" => [
                "あ", 
                "ア",
                "あ",
                "",
                "",
                "", 
                "register", 
                [ 
                    "errors" => ["mailAddress" => ["mail addressには正しい形式のメールアドレスを指定してください。"] ],
                    "inputs" => [
                            "companyName" => "あ",
                            "companyNameKana" => "ア",
                            "mailAddress" => "あ",
                            "mailAddressBcc" => "",
                            "mailSubject" => "",
                            "mailText" => "",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern4" => [
                "あ", 
                "ア",
                "hoge@hoge.com",
                "あ",
                "",
                "", 
                "register", 
                [ 
                    "errors" => ["mailAddressBcc" => ["mail address bccには正しい形式のメールアドレスを指定してください。"] ],
                    "inputs" => [
                            "companyName" => "あ",
                            "companyNameKana" => "ア",
                            "mailAddress" => "hoge@hoge.com",
                            "mailAddressBcc" => "あ",
                            "mailSubject" => "",
                            "mailText" => "",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern4" => [
                "><&,", 
                "><&,",
                "><&,",
                "><&,@><&.com",
                "><&,@><&.com",
                "><&,", 
                "register", 
                [ 
                    "errors" => ["companyNameKana" => ["company name kanaにはカタカナを指定してください。"] ],
                    "inputs" => [
                            "companyName" => "><&,",
                            "companyNameKana" => "><&,",
                            "mailAddress" => "><&,@h><&,.com",
                            "mailAddressBcc" => "><&,@><&,.com",
                            "mailSubject" => "><&,",
                            "mailText" => "><&,",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern5" => [
                "sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad", 
                "ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴ",
                "kjlfasdjkldsfajklfdsjklsdfljksdfakljdfsakljfsdakljdfskjlfsdajlkfsdakjdflsajkldsfakjlfdajkldfskjldfsakjdfsajklfsdaljkkadfjlsjkldfsakjldfsakdfsakljsafdkjdfskljfdsajklfdsakjldfaskjdfsakljdsfakjdflsakljdfsakljdfsakjldfsajkldfsakjdflsajkdfsjkdfsjdfsjkladfsljkd@fsa.com",
                "kjlfasdjkldsfajklfdsjklsdfljksdfakljdfsakljfsdakljdfskjlfsdajlkfsdakjdflsajkldsfakjlfdajkldfskjldfsakjdfsajklfsdaljkkadfjlsjkldfsakjldfsakdfsakljsafdkjdfskljfdsajklfdsakjldfaskjdfsakljdsfakjdflsakljdfsakljdfsakjldfsajkldfsakjdflsajkdfsjkdfsjdfsjkladfsljkd@fsa.com",
                "sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad",
                "sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad", 
                "register",
                [ 
                    "errors" => [
                            "companyName" => ["company nameには255文字以下の文字列を指定してください。"],
                            "companyNameKana" => ["company name kanaには255文字以下の文字列を指定してください。"],
                            "mailAddress" => ["mail addressには255文字以下の文字列を指定してください。", "mail addressには正しい形式のメールアドレスを指定してください。"],
                            "mailAddressBcc" => ["mail address bccには255文字以下の文字列を指定してください。", "mail address bccには正しい形式のメールアドレスを指定してください。"],
                            "mailSubject" => ["mail subjectには255文字以下の文字列を指定してください。"]
                    ],
                    "inputs" => [
                            "companyName" => "sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad",
                            "companyNameKana" => "ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴ",
                            "mailAddress" => "kjlfasdjkldsfajklfdsjklsdfljksdfakljdfsakljfsdakljdfskjlfsdajlkfsdakjdflsajkldsfakjlfdajkldfskjldfsakjdfsajklfsdaljkkadfjlsjkldfsakjldfsakdfsakljsafdkjdfskljfdsajklfdsakjldfaskjdfsakljdsfakjdflsakljdfsakljdfsakjldfsajkldfsakjdflsajkdfsjkdfsjdfsjkladfsljkd@fsa.com",
                            "mailAddressBcc" => "kjlfasdjkldsfajklfdsjklsdfljksdfakljdfsakljfsdakljdfskjlfsdajlkfsdakjdflsajkldsfakjlfdajkldfskjldfsakjdfsajklfsdaljkkadfjlsjkldfsakjldfsakdfsakljsafdkjdfskljfdsajklfdsakjldfaskjdfsakljdsfakjdflsakljdfsakljdfsakjldfsajkldfsakjdflsajkdfsjkdfsjdfsjkladfsljkd@fsa.com",
                            "mailSubject" => "sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad",
                            "mailText" => "sdfajldsklfjadfklsajdfksajldfsjkaldfksljadfsakljdksfjaldfksjldfkjsladfskldfsjkladkfljasdfkladfkjlkfjdlsafdksajldfskajldfask;ldsfkjaladfsjkldfksljafkdsaldskfjladfkjladsfkajlfjkdsaldfksjla;dfjskdfjsaldkfjsladkfsalfdkjaldfksal;asdfkl;jadfls;jlk;asdflkjsdaflkjfsad",
                            "buttonNo" => "register"
                    ],
                    "results" => null
                ]
            ],
            "pattern6" => [
                "!#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~、。，．・：；？！゛゜´｀¨＾￣＿ヽヾゝゞ〃仝々〆〇ー―‐／＼～∥｜…‥‘’“”（）〔〕［］｛｝〈〉《》「」『』【】＋－±×÷＝≠＜＞≦≧∞∴♂♀°′″℃￥＄￠￡％＃＆＊＠§☆★○●◎◇◆□■△▲▽▼※〒→←↑↓〓∈∋⊆⊇⊂⊃∪∩∧∨￢⇒⇔∀∃∠⊥⌒∂∇≡≒≪≫√∽∝∵∫∬Å‰♯♭♪ΑΒΓΔΕΖΗΘΙΚΛΜΝ",
                "a",
                "",
                "",
                "ΞΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψωАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя─│┌┐┘└├┬┤┴┼━┃┏┓┛┗┣┳┫┻╋┠┯┨┷┿┝┰┥┸╂｡｢｣､･ｦｧｨｩｪｫｬｭｮｯｰｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜﾝﾞﾟ０１２３４５６７８９",
                "ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚゑをん①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫㍊㌻㎜㎝㎞㎎㎏㏄㎡㍻〝〟№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼≒≡∫∮∑√⊥∠∟⊿∵∩∪", 
                "register", 
                [ 
                    "errors" => ["companyNameKana" => ["company name kanaにはカタカナを指定してください。"] ],
                    "inputs" => [
                            "companyName" => "!#$%&'()*+,-./0123456789:;<=>?@ABCDEFGHIJKLMNOPQRSTUVWXYZ[\]^_`abcdefghijklmnopqrstuvwxyz{|}~、。，．・：；？！゛゜´｀¨＾￣＿ヽヾゝゞ〃仝々〆〇ー―‐／＼～∥｜…‥‘’“”（）〔〕［］｛｝〈〉《》「」『』【】＋－±×÷＝≠＜＞≦≧∞∴♂♀°′″℃￥＄￠￡％＃＆＊＠§☆★○●◎◇◆□■△▲▽▼※〒→←↑↓〓∈∋⊆⊇⊂⊃∪∩∧∨￢⇒⇔∀∃∠⊥⌒∂∇≡≒≪≫√∽∝∵∫∬Å‰♯♭♪ΑΒΓΔΕΖΗΘΙΚΛΜΝ",
                            "companyNameKana" => "a",
                            "mailAddress" => "",
                            "mailAddressBcc" => "",
                            "mailSubject" => "ΞΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψωАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя─│┌┐┘└├┬┤┴┼━┃┏┓┛┗┣┳┫┻╋┠┯┨┷┿┝┰┥┸╂｡｢｣､･ｦｧｨｩｪｫｬｭｮｯｰｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜﾝﾞﾟ０１２３４５６７８９",
                            "mailText" => "ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚゑをん①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫㍊㌻㎜㎝㎞㎎㎏㏄㎡㍻〝〟№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼≒≡∫∮∑√⊥∠∟⊿∵∩∪",
                            "buttonNo" => "register",
                    ],
                    "results" => null
                ]
            ],
            "pattern7" => [
                "company_test",
                "テスト",
                "test@test.com",
                "test@test.com",
                "test_subject",
                "test_text", 
                "register", 
                [
                    "status" => 1,
                    "errors" => null,
                    "inputs" => null,
                    "results" => [
                        "company" => [
                            (object)[ 
                                "sid" => 397, # 随時変更する必要あり
                                "company_name" => "company_test",
                                "company_name_kana" => "テスト",
                                "mail_address" => "test@test.com",
                                "mail_address_bcc" => "test@test.com",
                                "mail_subject" => "test_subject",
                                "mail_text" => "test_text"
                            ],
                        ],
                        "keyword" => [
                            (object)[   
                                "company_name" => "company_test",
                                "target_keyword" => null,
                                "target_url" => null,
                                "detection_result_text" => null,
                                "active_flag" => null,
                                "m_company_sid" => 397, # 随時変更する必要あり
                                "m_keyword_sid" => null
                            ],
                        ]
                    ],
                ]
            ],
        ];
    }
}
