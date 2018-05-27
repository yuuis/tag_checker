<?php

namespace App\Helpers;

class ViewHelper
{
    /**
     * 日付をフォーマットする
     * @param unknown $date
     * @param unknown $format
     * @return unknown
     */
    public static function formatDate($date, $format = 'Y/m/d', $defaultMessage = '')
    {
    	$returnValue = '';
    	if ($date != '' && $date != '0000-00-00 00:00:00') {
    		$returnValue = date($format, strtotime($date));
    	} else {
    		$returnValue = $defaultMessage;
    	}
        return $returnValue;
    }
    
    /**
     * 配列とキーを渡し、表示用の文字列を返す
     * @param unknown $dataArray
     * @param unknown $target
     */
    public static function viewString($dataArray, $target) {
    	$returnString = "";
    	if (isset($dataArray) && isset($dataArray[$target]) && $dataArray[$target] != "") {
			$returnString = $dataArray[$target];
    	}
    	return $returnString;
    }
    
    /**
     * 特定の文字をカウントする
     * @param unknown $date
     * @param unknown $format
     * @return unknown
     */
    public static function countString($data, $target)
    {
    	$returnValue = 0;
    	if ($data != '' && $target != '') {
    		$returnValue = mb_substr_count($data, $target);
    	}
    	return $returnValue;
    }





     /**
     * 配列とキーを渡し、表示用の文字列を返す
     * @param unknown $dataArray
     * @param unknown $target
     */
    public static function viewStringForArray($dataArray, $target, $number) {
        $returnString = "";
        if (isset($dataArray) && isset($dataArray[$target]) && $dataArray[$target] != "") {
            $returnString = $dataArray[$target][$number];
        }
        return $returnString;
    }
    
}