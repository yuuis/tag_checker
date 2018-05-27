<?php

namespace App\Http\Model;

use Illuminate\Http\Request;

class KeywordDAO {
    public function __construct() {
    }

    public function checkExsistSid($sid) {
        \Log::info(__METHOD__);
        $result = \DB::select("
            SELECT sid FROM m_keyword WHERE sid = ?
        ", [$sid]);
        if(!empty($result)){
            return "exist";
        }else {
            return "not exist";
        }
    }

    public function selectKeyword() {
        \Log::info(__METHOD__);
        $results = \DB::select("
            SELECT
                mc.company_name,
                mk.target_keyword,
                GROUP_CONCAT(mr.target_url) AS target_url,
                td.detection_result_text,
                mk.active_flag,
                mc.sid AS m_company_sid,
                mk.sid AS m_keyword_sid
            FROM
                m_company mc
                LEFT JOIN m_keyword mk ON mc.sid = mk.m_company_sid AND mk.delete_flag = 0
                LEFT JOIN m_url mr ON mk.sid = mr.m_keyword_sid AND mr.delete_flag = 0
                LEFT JOIN t_detection td ON mk.sid = td.m_keyword_sid AND td.delete_flag = 0
            WHERE
                mc.delete_flag = 0
            GROUP BY
                mc.sid,
                mk.sid,
                td.detection_result_text,
                mk.active_flag,

                mc.company_name,
                mk.target_keyword
            ORDER BY
                mk.active_flag DESC,
                td.create_time DESC
            LIMIT 1000", []);
        return $results;
    }
    public function selectKeywordForCompanySid($sid) {
        \Log::info(__METHOD__);
        $results = \DB::select("
            SELECT
                mc.company_name,
                mk.target_keyword,
                GROUP_CONCAT(mr.target_url)  AS target_url,
                td.detection_result_text,
                mk.active_flag,
                mc.sid AS m_company_sid,
                mk.sid AS m_keyword_sid
            FROM
                m_company mc
                LEFT JOIN m_keyword mk ON mc.sid = mk.m_company_sid AND mk.delete_flag = 0
                LEFT JOIN m_url mr ON mk.sid = mr.m_keyword_sid AND mr.delete_flag = 0
                LEFT JOIN t_detection td ON mk.sid = td.m_keyword_sid AND td.delete_flag = 0
            WHERE
                mc.delete_flag = 0
                AND mc.sid = ?
            GROUP BY
                mc.sid,
                mk.sid,
                td.detection_result_text,
                mk.active_flag,

                mc.company_name,
                mk.target_keyword
            ORDER BY
                mk.active_flag DESC,
                td.create_time DESC
            LIMIT 1000 FOR UPDATE", [$sid]);
        return $results;
    }

    public function selectKeywordForKeywordSid($sid) {
        \Log::info(__METHOD__);
        $results = \DB::select("
            SELECT
                mk.sid,
                mk.target_keyword,
                mk.active_flag
            FROM
                m_keyword mk
            WHERE
                mk.delete_flag = 0
                AND mk.sid = ? FOR UPDATE", [$sid]);
        return $results;
    }

    public function selectURLForKeywordSid($sid) {
        \Log::info(__METHOD__);
        $results = \DB::select("
            SELECT
                mu.target_url,
                mu.search_type,
                mu.active_flag
            FROM
                m_url mu
            WHERE
                mu.delete_flag = 0
                AND mu.m_keyword_sid = ? FOR UPDATE", [$sid]);
        return $results;
    }

    public function updateKeyword($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid, $keywordSid) {
        \Log::info(__METHOD__);
        $keywordValues = [$targetKeyword, $activeFlag, $companySid, $keywordSid];
        $result = null;
        try{
            \DB::update("
                UPDATE m_keyword SET
                    target_keyword = ?,
                    active_flag = ?,
                    m_company_sid = ?
                WHERE sid = ?", $keywordValues);
            \DB::delete("
                DELETE FROM m_url WHERE m_keyword_sid = ?", [$keywordSid]);
            for($i=0; $i < count($targetUrl); $i++) {
                $urlValues = array($targetUrl[$i], $searchType[$i], $urlActiveFlag[$i], $keywordSid);
                \DB::insert("
                	INSERT INTO m_url (target_url, search_type, active_flag, m_keyword_sid)
                	VALUES (?, ?, ?, ?)", $urlValues);
            }
            $result = "succsess";
        } catch (Exception $e) {
            $result = "faild". $e->getMessage();
        } finally {
            return $result;
        }
    }

    public function insertKeyword($targetKeyword, $activeFlag, $targetUrl, $searchType, $urlActiveFlag, $companySid) {
        \Log::info(__METHOD__);
        $keywordValues = array($targetKeyword, $activeFlag, $companySid);
        $result = null;
        try {
            \DB::insert("
                INSERT INTO m_keyword (target_keyword, active_flag, m_company_sid)
                VALUES (?,?,?)" , $keywordValues);
            $keywordSid = \DB::getPdo()->lastInsertId();
            for($i = 0; $i < count($targetUrl); $i++) {
            	$urlValues = array($targetUrl[$i], $searchType[$i], $urlActiveFlag[$i], $keywordSid);
	            \DB::insert("
	            	INSERT INTO m_url (target_url, search_type, active_flag, m_keyword_sid)
	            	VALUES (?, ?, ?, ?)", $urlValues);
	            $result = "succsess";
                \Session::put("keywordSid", $keywordSid);
            }
        } catch (Exception $e) {
        	\Log::debug(__METHOD__."---faild--->");
            $result = "faild". $e->getMessage();
        } finally {
            return $result;
        }
    }


    public function selectKeywordForBatch() {
        \Log::info(__METHOD__);
        $results = \DB::select("
            SELECT
                mc.company_name,
                mk.target_keyword,
                GROUP_CONCAT(mr.target_url) AS target_url,
                GROUP_CONCAT(mr.search_type) AS search_type,
                td.detection_result_text,
                mk.active_flag,
                mc.sid AS m_company_sid,
                mk.sid AS m_keyword_sid
            FROM
                m_company mc
                LEFT JOIN m_keyword mk ON mc.sid = mk.m_company_sid AND mk.delete_flag = 0 AND mk.active_flag = 1
                LEFT JOIN m_url mr ON mk.sid = mr.m_keyword_sid AND mr.delete_flag = 0 AND mr.active_flag = 1
                LEFT JOIN t_detection td ON mk.sid = td.m_keyword_sid AND td.delete_flag = 0
            WHERE
                mc.delete_flag = 0
            GROUP BY
                mc.sid,
                mk.sid,
                td.detection_result_text,
                mk.active_flag,

                mc.company_name,
                mk.target_keyword
            ORDER BY
                mk.active_flag DESC,
                td.create_time DESC
            LIMIT 1000", []);
        return $results;
    }



    public function selectKeywordForKeywordSidForTest($sid) {
        \Log::info(__METHOD__);
        $results = \DB::select("
            SELECT
                mk.target_keyword,
                mk.active_flag,
                mu.target_url,
                mu.search_type,
                mu.active_flag,
                mk.m_company_sid
            FROM
                m_keyword mk
                INNER JOIN m_url mu ON mk.sid = mu.m_keyword_sid
            WHERE
                mk.sid = ?", [$sid]);
        return $results;
    }
}