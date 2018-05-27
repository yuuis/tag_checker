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
        // $command = "sudo /home/ec2-user/.pyenv/shims/python /var/www/html/executable/tag_checker.py". " ". $url. " ". $trackingCode . " > /tmp/boke.txt";
        exec($command, $hoge, $fuga);
        // \Log::info(__METHOD__. "---output--->" .print_r($hoge)."---status--->".$fuga);

        $mailLogic = new \App\Http\Logic\Mail\MailLogic;
        $mailLogic->sentMail($to, $domain);
        
        \Log::debug(__METHOD__. "メールを送信しました");
        $result = new \App\Http\Logic\LogicResultDTO();
        $result->setResults("メールを送信しました");
        return view("tagcheck/result", $result->getForView($request));
    }
}
