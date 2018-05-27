<?php

namespace Tests\Unit\Mail;

use Tests\TestCase;
use Illuminate\Http\Request;

// 実行コマンド
// sudo vendor/bin/phpunit ./tests/Unit/Mail/MailLogicTest.php

class MailLogicTest extends TestCase {

    /**
     * @dataProvider mailProvider
     * @param unknown $detectionLogSid
     * @param unknown $keywordSid
     * @param unknown $keyword
     * @param unknown $date
     * @param unknown $strangeUrls
     * @param unknown $screenShot
     * @param unknown $mailAddress
     * @param unknown $expect
     */
    public function testStackMail($detectionLogSid, $keywordSid, $keyword, $date, $strangeUrls, $screenShot, $mailAddress, $expect) {
        $mailDao = new \App\Http\Model\MailDAO();
        $mailDao->stackMail($detectionLogSid, $keywordSid, $keyword, $date, $strangeUrls, $screenShot);
        $results = $mailDao->selectStackMail($mailAddress);
            \Log::debug(__METHOD__."-----results----->".print_r((array)$results[0]));
            \Log::debug(__METHOD__."-----expect----->".print_r($expect));
        $this->assertTrue((array)$results[0] === $expect);
    }

    public function mailProvider() {
        $testCases = [
            [
                "detectionLogSid" => 383,
                "keywordSid" => 150,
                "keyword" => "test_keyword",
                "date" => "2018-03-19-170109",
                "strangeUrls" => [
                    "googlePc" => "hoge",
                    "googleSp" => "hoge", 
                    "yahooPc" => "", 
                    "yahooSp" => "",
                ],
                "screenShot" => [
                    "googlePc" => "hoge",
                    "googleSp" => "hoge", 
                    "yahooPc" => "", 
                    "yahooSp" => "",
                ],
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
}
