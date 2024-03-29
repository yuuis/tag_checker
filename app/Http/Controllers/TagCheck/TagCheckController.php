<?php
namespace App\Http\Controllers\TagCheck;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TagCheckController extends Controller {
    
    /**
     * index
     * @param Request $request
     */
    public function tagCheck(Request $request) {
        \Log::info(__METHOD__);
        $url =  $request->input("url");
        $trackingCode =  $request->input("trackingCode");
        $to = $request->input("to");

        $domain = str_replace("https://www.", "", $url);
        $domain = str_replace("http://www.", "", $domain);
        $domain = str_replace("http://", "", $domain);
        $domain = str_replace("https:/", "", $domain);
        $domain = str_replace("/", "", $domain);

        $command = "/var/www/html/source.sh $url $trackingCode >> /var/www/html/hoge.txt";
        exec($command, $hoge, $fuga);

        $mailLogic = new \App\Http\Logic\Mail\MailLogic;
        $mailLogic->sentMail($to, $domain);
            
        $result = new \App\Http\Logic\LogicResultDTO();
        $result->setResults("メールを送信しました");
        return view("tagcheck/result", $result->getForView($request));
    }
}
