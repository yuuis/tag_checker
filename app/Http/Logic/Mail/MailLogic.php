<?php

namespace App\Http\Logic\Mail;

use Illuminate\Http\Request;
use App\Http\Logic\BaseLogic;
use App\Http\Logic\LogicResultDTO;
use App\Mail\MailShipped;
use Mail;

class MailLogic extends \App\Http\Logic\BaseLogic {
    public function __construct() {
    }
    
    public function sentMail($to, $domain) {
        \Log::info(__METHOD__);

        mb_language("Japanese");
        mb_internal_encoding("UTF-8");

        $text = "csvファイルの説明\nnomal : トラッキングコードが正しく動いているページ\nabnomal : トラッキングコードが正しく動いていない可能性のあるページ\nnone_tracking_code : トラッキングコードが検出されなかったページ"; 
        $options = [
            "from" => "tag_check@send.secm.jp",
            "from_jp" => "インターネットビジネスフロンティア",
            "to" => $to,
            "subject" => "$domain の検査結果",
            "template" => "mail.mailShipped", // resources/views/emails/hoge/mail.blade.php
        ];
        $data = [
            "text" => $text,
        ];
        $file = "/tmp/$domain.csv";
        \Mail::to($to)->send(new MailShipped($options, $data, $file));
    }
}