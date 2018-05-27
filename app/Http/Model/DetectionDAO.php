<?php

namespace App\Http\Model;
use Exception;


class DetectionDAO {
    public function __construct() {
    }

    public function checkExsistSid($detectionLogSid) {
      \Log::info(__METHOD__);
        $result = \DB::select(
            "SELECT * FROM t_detection_log WHERE sid = ?", [$detectionLogSid]);
        if(!empty($result)){
            return "exist";
        }else {
            return "not exist";
        }
    }

    public function selectHistoryForSid($keywordSid) {
        \Log::info(__METHOD__);
        $results = \DB::select(
            "SELECT
                tdl.sid,
                tdl.detection_result_text
            FROM
                t_detection_log tdl
            WHERE
                tdl.delete_flag = 0
                AND tdl.m_keyword_sid = ?
            ORDER BY create_time DESC
            LIMIT 1000", [$keywordSid]);
        return $results;
    }

    public function selectDetailForSid($detectionLogSid) {
        \Log::info(__METHOD__);
        $results = \DB::select(
            "SELECT
                tdl.sid,
                tdl.detection_result_text,
                tdl.image_url_google_pc,
                tdl.image_url_google_sp,
                tdl.image_url_yahoo_pc,
                tdl.image_url_yahoo_sp,
                tml.mail_address,
                tml.mail_address_bcc,
                tml.mail_subject,
                tml.mail_text
            FROM
                t_detection_log tdl
                left join t_mail_log tml on tdl.sid = tml.t_detection_log_sid
            WHERE
                tdl.delete_flag = 0
                and tdl.sid = ?", [$detectionLogSid]);                
        return $results;
    }

    public function insertNomalLog($keywordSid, $keyword, $date) {
        \Log::info(__METHOD__);
        $resultText = $date.",正常";
        $values = [$keywordSid, $keyword, 1, $resultText];
        \DB::insert(
            "INSERT INTO t_detection_log(m_keyword_sid, target_keyword, detection_type, detection_result_text)
                VALUES (?,?,?,?)", $values);
        return \DB::getPdo()->lastInsertId();
    }

    public function updateNomalLog($keywordSid, $keyword, $date) {
        \Log::info(__METHOD__);
        $resultText = $date.",正常";
        $values = [$keywordSid, $keyword, 1, $resultText];
        \DB::delete(
            "DELETE FROM t_detection WHERE m_keyword_sid = ?", [$keywordSid]);
        \DB::insert(
            "INSERT INTO t_detection(m_keyword_sid, target_keyword, detection_type, detection_result_text)
                VALUES (?,?,?,?)", $values);
    }

    public function insertAbnomalLog($keywordSid, $keyword, $date, $strangeUrls, $screenShots) {
        \Log::info(__METHOD__);
        $resultText = $date.",";
        foreach ($strangeUrls as $key => $strangeUrl) {
            $resultText = $resultText . "[". $key. "],";
            foreach ($strangeUrl as $url) {
                $resultText = $resultText . "不正な広告".$url.",を検出しました,";
            }
        }
        $values = [$keywordSid, $keyword, 2, $resultText, 
            isset($screenShots["googlePc"]) ? $screenShots["googlePc"] : null,
            isset($screenShots["googleSp"]) ? $screenShots["googleSp"] : null,
            isset($screenShots["yahooPc"]) ? $screenShots["yahooPc"] : null,
            isset($screenShots["yahooSp"]) ? $screenShots["yahooSp"] : null,
        ];
        \DB::insert(
            "INSERT INTO t_detection_log(m_keyword_sid, target_keyword, detection_type, detection_result_text, image_url_google_pc, image_url_google_sp, image_url_yahoo_pc, image_url_yahoo_sp)
                VALUES (?,?,?,?,?,?,?,?)", $values);
        return \DB::getPdo()->lastInsertId();
    }

    public function updateAbnomalLog($keywordSid, $keyword, $date, $strangeUrls, $screenShots) {
        \Log::info(__METHOD__);
        $resultText = $date.",";
        foreach ($strangeUrls as $key => $strangeUrl) {
            $resultText = $resultText .     "[". $key. "],";
            foreach ($strangeUrl as $url) {
                $resultText = $resultText . "不正な広告".$url.",を検出しました,";
            }
        }
        $values = [$keywordSid, $keyword, 2, $resultText, 
            isset($screenShots["googlePc"]) ? $screenShots["googlePc"] : null,
            isset($screenShots["googleSp"]) ? $screenShots["googleSp"] : null,
            isset($screenShots["yahooPc"]) ? $screenShots["yahooPc"] : null,
            isset($screenShots["yahooSp"]) ? $screenShots["yahooSp"] : null,
        ];
        \DB::delete(
            "DELETE FROM t_detection WHERE m_keyword_sid = ?", [$keywordSid]);
        \DB::insert(
            "INSERT INTO t_detection(m_keyword_sid, target_keyword, detection_type, detection_result_text, image_url_google_pc, image_url_google_sp, image_url_yahoo_pc, image_url_yahoo_sp) 
                VALUES (?,?,?,?,?,?,?,?)", $values);
    }

    public function selectImagePath($detectionLogSid) {
        \Log::info(__METHOD__);
        $results = \DB::select(
            "SELECT
                tdl.image_url_google_pc,
                tdl.image_url_google_sp,
                tdl.image_url_yahoo_pc,
                tdl.image_url_yahoo_sp
            FROM
                t_detection_log tdl
            WHERE
                tdl.delete_flag = 0
                AND tdl.sid = ?", [$detectionLogSid]);
        return $results;
    }

    public function selectDetailForSidForTest($detectionLogSid) {
        \Log::info(__METHOD__);
        $results = \DB::select(
            "SELECT
                tdl.detection_result_text,
                tdl.image_url_google_pc,
                tdl.image_url_google_sp,
                tdl.image_url_yahoo_pc,
                tdl.image_url_yahoo_sp
            FROM
                t_detection_log tdl
            WHERE
                tdl.delete_flag = 0
                and tdl.sid = ?", [$detectionLogSid]);
        return $results;
    }

    public function selectDetailForKeywordSidForTest($keywordSid) {
        \Log::info(__METHOD__);
        $results = \DB::select(
            "SELECT
                td.detection_result_text,
                td.image_url_google_pc,
                td.image_url_google_sp,
                td.image_url_yahoo_pc,
                td.image_url_yahoo_sp
            FROM
                t_detection td
            WHERE
                td.delete_flag = 0
                and td.m_keyword_sid = ?", [$keywordSid]);
        return $results;
    }
}