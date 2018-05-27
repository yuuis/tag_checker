<?php

namespace App\Http\Model;
use Exception;


class MailDAO {
    public function __construct() {
    }

    public function insertLog($mailAddress, $mailAddressBcc, $mailSubject, $mailText, $detectionLogSid) {
    	\Log::info(__METHOD__);
    	$values = [$mailAddress, $mailAddressBcc, $mailSubject, $mailText, $detectionLogSid];
    	\DB::insert("
            INSERT INTO t_mail_log(mail_address, mail_address_bcc, mail_subject, mail_text, t_detection_log_sid)
            VALUES (?,?,?,?,?)", $values);
        return \DB::getPdo()->lastInsertId();
    }

    public function selectText($detectionLogSid) {
        \Log::info(__METHOD__);
        $results = \DB::select("
            SELECT
                tml.mail_address,
                tml.mail_address_bcc,
                tml.mail_subject,
                tml.mail_text
            FROM
                t_mail_log tml
            WHERE
                tml.delete_flag = 0
                AND tml.t_detection_log_sid = ?
            ", [$detectionLogSid]);
        return $results;
    }

    public function selectAllForSidForTest($mailLogSid) {
        \Log::info(__METHOD__);
        $results = \DB::select("
            SELECT
                tml.mail_address,
                tml.mail_address_bcc,
                tml.mail_subject,
                tml.mail_text
            FROM
                t_mail_log tml
            WHERE
                tml.delete_flag = 0
                AND tml.sid = ?
            ", [$mailLogSid]);
        return $results;
    }

    public function selectStackMail($mailAddress) {
        \Log::info(__METHOD__);
        $result = \DB::select("
            SELECT
                mail_address,
                mail_address_bcc,
                mail_subject,
                mail_text
            FROM 
                t_mail_stack
            WHERE 
                mail_address = ?", [$mailAddress]);
        return $result;
    }

    public function selectAllStackMail() {
        \Log::info(__METHOD__);
        $result = \DB::select("
            SELECT
                mail_address,
                mail_address_bcc,
                mail_subject,
                mail_text
            FROM 
                t_mail_stack");
        return $result;
    }

    public function stackMail($mailAddress, $mailAddressBcc, $mailSubject, $mailText) {
        \Log::info(__METHOD__);
        $values = [$mailAddress, $mailAddressBcc, $mailSubject, $mailText];
        \DB::insert("
            REPLACE INTO t_mail_stack (mail_address, mail_address_bcc, mail_subject, mail_text) VALUES (?, ?, ?, ?)", $values);
    }

    public function deleteStackMail($mailAddress) {
        \Log::info(__METHOD__);
        \DB::delete("
            DELETE FROM t_mail_stack WHERE mail_address = ?", [$mailAddress]);
    }
}

# 使う場面を想定して作る