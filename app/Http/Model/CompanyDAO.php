<?php

namespace App\Http\Model;
use Exception;


class CompanyDAO {
    public function __construct() {
    }

    public function checkExsistSid($sid) {
        \Log::info(__METHOD__);
        $result = \DB::select("SELECT * FROM m_company WHERE sid = ?", [$sid]);
        if(!empty($result)){
            return "exist";
        }else {
            return "not exist";
        }
    }

    public function selectCompanyForSid($sid) {
        \Log::info(__METHOD__);
        $results = \DB::select(
            "SELECT
            	mc.sid,
            	mc.company_name,
            	mc.company_name_kana,
            	mc.mail_address,
            	mc.mail_address_bcc,
            	mc.mail_subject,
            	mc.mail_text
            FROM
            	m_company mc
            WHERE
            	mc.delete_flag = 0
            	AND mc.sid = ? FOR UPDATE", [$sid]);
        return $results;
    }


    public function insertCompany($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText) {
        \Log::info(__METHOD__);
        $values = [$companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText];
        $result = null;
        try{
           \DB::insert(
            "INSERT INTO m_company(company_name, company_name_kana, mail_address, mail_address_bcc, mail_subject, mail_text)
                VALUES (?,?,?,?,?,?)", $values);
           $companySid = \DB::getPdo()->lastInsertId();
           \Session::put("companySid", $companySid);
           $result = "success";
        } catch (Exception $e) {
           $result = "faild". $e->getMessage();
        } finally {
            return $result;
        }
    }

    public function updateCompany($companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText, $sid) {
        $values = [$companyName, $companyNameKana, $mailAddress, $mailAddressBcc, $mailSubject, $mailText, $sid];
        \Log::info(__METHOD__);
        try{
            \DB::update(
                "UPDATE m_company SET
                    company_name = ?,
                    company_name_kana = ?,
                    mail_address = ?,
                    mail_address_bcc = ?,
                    mail_subject = ?,
                    mail_text = ?
                WHERE sid = ?", $values);
            $result = "success";
        }catch(Exception $e){
            $result = "faild". $e->getMessage();
        } finally {
            return $result;
        }
    }

    public function selectCompanyForKeywordSid($sid) {
        \Log::info(__METHOD__);
        $results = \DB::select(
            "SELECT
                mc.sid,
                mc.company_name,
                mc.mail_address,
                mc.mail_address_bcc,
                mc.mail_subject,
                mc.mail_text
            FROM
                m_company mc
                INNER JOIN m_keyword mk ON mc.sid = mk.m_company_sid
            WHERE
                mc.delete_flag = 0
                AND mk.sid = ? FOR UPDATE", [$sid]);
        return $results;
    }




    public function selectCompanyForSidForTest($sid) {
        \Log::info(__METHOD__);
        $results = \DB::select(
            "SELECT
                mc.company_name,
                mc.company_name_kana,
                mc.mail_address,
                mc.mail_address_bcc,
                mc.mail_subject,
                mc.mail_text
            FROM
                m_company mc
            WHERE
                mc.delete_flag = 0
                AND mc.sid = ? FOR UPDATE", [$sid]);
        return $results;
    }
}