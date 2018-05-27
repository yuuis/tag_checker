<?php

namespace App\Commons\Utils;

/**
 * アプリケーション全体で使用できる共通関数
 * @author y.mori
 */
class AppUtil {

    // コンストラクタのアクセス権限をprivate → publicに変更しました 
    public function __construct() {
    }
    public final function __clone() {
    }



    /**
     * <pre>
     * [概要]
     * generate valid version 4 UUIDs
     *
     * [用途]
     * トークン（CSRF）として使用することを目的としています。
     * 多重コミット防止等に使用します。
     *
     * [備考]
     * セッション識別IDにも使用できるように区切り文字はアンダースコアにしてあります。
     * cf.)
     * http://php.net/manual/ja/function.com-create-guid.php
     * </pre>
     * @return type
     * @author h.geka
     */
    public static function generateUUID() {
        return sprintf("%04X%04X_%04X_%04X_%04X_%04X%04X%04X", mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(16384, 20479), mt_rand(32768, 49151), mt_rand(0, 65535), mt_rand(0, 65535), mt_rand(0, 65535));
    }

    /**
     * <pre>
     * [概要]
     * 実行日時を返却します。
     * MySQL の DATETIME フォーマット
     *
     * [用途]
     * INSERT/UPDATE時に使用することを目的としています。
     * </pre>
     * @return type
     * @author h.geka
     *
     */
    public static function getTimestamp4SQL() {
        return date("Y-m-d H:i:s");
    }

    /**
     * <pre>
     * [概要]
     * 前方一致（文字列）
     *
     * [使用方法]
     * $prefix = "http";
     * $source = "http://google.com";
     * startsWith($source, $prefix); // TRUE
     *
     * NULL,NULL // TRUE
     * NULL,"abc" // FALSE
     * "abc",NULL // FALSE
     * "abcdef","abc" // TRUE
     * "ABC","abc" // FALSE
     * "abc","abcedf" // FALSE
     *
     * ※NULLと空文字は同じ扱いです。
     * ※数値は文字列にしてから渡してください。
     *
     * </pre>
     * @param type $source
     * @param type $prefix
     * @return type
     * @author h.geka
     */
    public static function startsWith($source, $prefix) {

        if (strlen($source) === 0 && strlen($prefix) === 0) {
            return TRUE;
        }else if (strlen($source) === 0 || strlen($prefix) === 0) {
            return FALSE;
        }

        return strpos($source, $prefix) === 0;
    }



    /**
     * <pre>
     * [概要]
     * 前方一致（文字列）
     * 大文字／小文字を区別しない
     * [使用方法]
     * $prefix = "http";
     * $source = "http://google.com";
     * startsWith($source, $prefix); // TRUE
     *
     * NULL,NULL // TRUE
     * NULL,"abc" // FALSE
     * "abc",NULL // FALSE
     * "abcdef","abc" // TRUE
     * "ABC","abc" // TRUE
     * "abc","abcedf" // FALSE
     *
     * ※NULLと空文字は同じ扱いです。
     * ※数値は文字列にしてから渡してください。
     *
     * </pre>
     * @param type $source
     * @param type $prefix
     * @return type
     * @author h.geka
     *
     */
    public static function startsWithIgnoreCase($source, $prefix) {

        if (strlen($source) === 0 && strlen($prefix) === 0) {
            return TRUE;
        }else if (strlen($source) === 0 || strlen($prefix) === 0) {
            return FALSE;
        }

        return stripos($source, $prefix) === 0;
    }



    /**
     * <pre>
     * [概要]
     * 後方一致（文字列）
     *
     * [使用方法]
     * $suffix = "com";
     * $source = "http://google.com";
     * endsWith($source, $suffix); // TRUE
     *
     * NULL,NULL // TRUE
     * NULL,"def" // FALSE
     * "abcdef",NULL // FALSE
     * "abcdef","def" // TRUE
     * "ABCDEF","def" // FALSE
     * "ABCDEF","cde" // FALSE
     *
     * ※NULLと空文字は同じ扱いです。
     * ※数値は文字列にしてから渡してください。
     *
     * </pre>
     * @param type $source
     * @param type $suffix
     * @return type
     * @author h.geka
     *
     */
    public static function endsWith($source, $suffix) {

        if (strlen($source) === 0 && strlen($suffix) === 0) {
            return TRUE;
        }else if (strlen($source) === 0 || strlen($suffix) === 0) {
            return FALSE;
        }

        return strpos($source, $suffix) + strlen($suffix) === strlen($source);
    }



    /**
     * <pre>
     * [概要]
     * 後方一致（文字列）
     * 大文字／小文字を区別しない
     *
     * [使用方法]
     * $suffix = "com";
     * $source = "http://google.com";
     * endsWith($source, $suffix); // TRUE
     *
     * NULL,NULL // TRUE
     * NULL,"def" // FALSE
     * "abcdef",NULL // FALSE
     * "abcdef","def" // TRUE
     * "ABCDEF","def" // FALSE
     * "ABCDEF","cde" // FALSE
     *
     * ※NULLと空文字は同じ扱いです。
     * ※数値は文字列にしてから渡してください。
     *
     * </pre>
     * @param type $source
     * @param type $suffix
     * @return type
     * @author h.geka
     *
     */
    public static function endsWithIgnoreCase($source, $suffix) {

        if (strlen($source) === 0 && strlen($suffix) === 0) {
            return TRUE;
        }else if (strlen($source) === 0 || strlen($suffix) === 0) {
            return FALSE;
        }

        return stripos($source, $suffix) + strlen($suffix) === strlen($source);
    }



    /**
     * <pre>
     * [概要]
     * 部分一致（文字列）
     *
     * [使用方法]
     * $keyWord = "com";
     * $source = "http://google.com";
     * contains($source, $keyWord); // TRUE
     *
     * NULL,NULL // TRUE
     * NULL,"def" // FALSE
     * "abcdef",NULL // FALSE
     * "abcdef","def" // TRUE
     * "ABCDEF","def" // FALSE
     * "ABCDEF","cde" // FALSE
     *
     * ※NULLと空文字は同じ扱いです。
     * ※数値は文字列にしてから渡してください。
     *
     * </pre>
     * @param type $source
     * @param type $keyWord
     * @return type
     * @author h.geka
     *
     */
    public static function contains($source, $keyWord) {

        if (strlen($source) === 0 && strlen($keyWord) === 0) {
            return TRUE;
        }else if (strlen($source) === 0 || strlen($keyWord) === 0) {
            return FALSE;
        }

        if(strstr($source, $keyWord)){
            return TRUE;
        }else{
            return FALSE;
        }

    }



    /**
     * <pre>
     * [概要]
     * 部分一致（文字列）
     * 大文字／小文字を区別しない
     *
     * [使用方法]
     * $keyWord = "com";
     * $source = "http://google.com";
     * contains($source, $keyWord); // TRUE
     *
     * NULL,NULL // TRUE
     * NULL,"def" // FALSE
     * "abcdef",NULL // FALSE
     * "abcdef","def" // TRUE
     * "ABCDEF","def" // TRUE
     * "ABCDEF","cde" // TRUE
     *
     * ※NULLと空文字は同じ扱いです。
     * ※数値は文字列にしてから渡してください。
     *
     * </pre>
     * @param type $source
     * @param type $keyWord
     * @return type
     * @author h.geka
     *
     */
    public static function containsIgnoreCase($source, $keyWord) {

        if (strlen($source) === 0 && strlen($keyWord) === 0) {
            return TRUE;
        }else if (strlen($source) === 0 || strlen($keyWord) === 0) {
            return FALSE;
        }

        if(stristr($source, $keyWord)){
            return TRUE;
        }else{
            return FALSE;
        }

    }



    /**
     * <pre>
     * [概要]
     * 文字の両端を指定文字列で囲みます。
     * 指定文字列のデフォルトは"""です。
     *
     * [備考]
     * エスケープはしませんのでSQLには使用しないこと。
     *
     * </pre>
     * @param type $source
     * @param type $appendBefore
     * @param type $appendAfter
     * @return string
     * @author h.geka
     *
     */
    public static function surroundWith($source,$appendBefore="\"",$appendAfter="\"") {

        if (strlen($source) === 0) {
            return $source;
        }

        if (strlen($appendBefore) === 0 || strlen($appendAfter) === 0) {
            return $source;
        }

        $result = $appendBefore . $source . $appendAfter;

        return $result;
    }



    /**
     * <pre>
     * [概要]
     * NULL／空文字か判定します。
     * </pre>
     * @param type $source
     * @return type
     * @author h.geka
     */
    public static function isEmpty($source) {
        $sourceLength = strlen($source);
        return $sourceLength === 0;
    }



    /**
     * <pre>
     * [概要]
     * NULL／空文字でないか判定します。
     * </pre>
     * @param type $source
     * @return type
     * @author h.geka
     *
     */
    public static function isNotEmpty($source) {
        return !self::isEmpty($source);
    }



    /**
     * <pre>
     * [概要]
     * 配列に要素が存在するか判定します。]
     *
     * [返却値]
     * 配列が空：TRUE
     * 配列が空でない：FALSE
     * 配列でない：FALSE
     * </pre>
     *
     * @param type $source
     * @return boolean
     * @author h.geka
     */
    public static function isEmptyArray($source) {

        if(is_array($source)){
            // 配列の場合
            if(count($source)>0){
                return FALSE;
            }else{
                return TRUE;
            }
        }else{
            // 配列でない場合（NULLの場合も同義）
            return FALSE;
        }

    }



    /**
     * <pre>
     * [概要]
     * 配列に要素が存在しないか判定します。
     *
     * [返却値]
     * 配列が空でない：TRUE
     * 配列が空：FALSE
     * 配列でない：FALSE
     * </pre>
     *
     * @param type $source
     * @return boolean
     * @author h.geka
     */
    public static function isNotEmptyArray($source) {

        if(is_array($source)){
            // 配列の場合
            if(count($source)>0){
                return TRUE;
            }else{
                return FALSE;
            }
        }else{
            // 配列でない場合（NULLの場合も同義）
            return FALSE;
        }

    }



    /**
     * <pre>
     * [概要]
     * 配列に要素が存在するか判定します。
     * keyが存在しても値が存在しない場合も判定します。
     *
     * [返却値]
     * 配列が空：TRUE
     * 配列が空でない：FALSE
     * 配列でない：FALSE
     * </pre>
     * @param type $source
     * @return type
     * @author h.geka
     */
    public static function isEmptyArrayStrict($source) {

        if(is_array($source)){
            foreach($source as $value){
                if(!empty($value) || $value != NULL || $value != ""){
                    return FALSE;
                }
            }
            return TRUE;
        }else{
            return FALSE;
        }

    }



    /**
     * <pre>
     * [概要]
     * 配列に要素が存在しないか判定します。
     * keyが存在しても値が存在しない場合も判定します。
     *
     * [返却値]
     * 配列が空でない：TRUE
     * 配列が空：FALSE
     * 配列でない：FALSE
     * </pre>
     * @param type $source
     * @return type
     * @author h.geka
     */
    public static function isNotEmptyArrayStrict($source) {

        if(is_array($source)){
            foreach($source as $value){
                if(!empty($value) || $value != NULL || $value != ""){
                    return TRUE;
                }
            }
            return FALSE;
        }else{
            return FALSE;
        }

    }



    public static function isLengthEqual($source, $length) {
        $sourceLength = strlen($source);
        return $sourceLength === $length;
    }



    public static function isLengthLessThan($source, $length) {
        $sourceLength = strlen($source);
        return $sourceLength < $length;
    }



    public static function isLengthLesserEqual($source, $length) {
        $sourceLength = strlen($source);
        return $sourceLength <= $length;
    }



    public static function isLengthGreaterThan($source, $length) {
        $sourceLength = strlen($source);
        return $sourceLength > $length;
    }



    public static function isLengthGreaterEqual($source, $length) {
        $sourceLength = strlen($source);
        return $sourceLength >= $length;
    }



    /**
     * <pre>
     * [概要]
     * 第一引数がNULL／空文字の場合、第二引数の文字列を返却します。
     * </pre>
     *
     * @param string $source
     * @param string $replace
     * @return string
     * @author h.geka
     */
    public static function nvl($source, $replace = "") {
        if (self::isEmpty($source)) {
            return $replace;
        } else {
            return $source;
        }
    }



    /**
     * <pre>
     * [概要]
     * 文字列をDateオブジェクトに変換します。（実際は文字列）
     * </pre>
     * @param type $source
     * @param type $format
     * @return string
     * @author h.geka
     */
    public static function convertString2Date($source, $format="Y-m-d H:i:s") {

        if(self::isEmpty($source)){
            return $source;
        }
        return date($format,strtotime($source));

    }



    /**
     * <pre>
     * [概要]
     * 文字列をDate形式の文字列に変換します。
     *
     * [備考]
     * DBから取得した項目を対象とすることを前提としています。
     * 配列で取得するとオブジェクトでない状態となるため、
     * そのような場合に有効なメソッドです。
     * また、テンプレート側（画面側）で入力値に|date_format:"%Y%m%d"を使用し、
     * POSTすると実装面で非常にコストがかかるため、このメソッドを使用してください。
     * 本仕様上、日付の入力は全てyyyy/MM/dd形式となっているため、
     * 個別にconvertString2Dateメソッドにパラメータを渡すのは極力控えてください。
     *
     * [例]
     * ・ロジック
     * 　$inputDTO->setXxxDate(AppUtil::convertString2DateFormatedString($value["xxx_date"]));
     * ・テンプレート
     * 　そのまま出力
     *
     * </pre>
     * @param type $source
     * @param type $format
     * @return type
     * @author h.geka
     */
    public static function convertString2DateFormatedString($source, $format="Ymd")
    {
            if(self::isEmpty($source)){
                return NULL;
            }
            if(self::startsWith($source, "0000")){
                return NULL;
            }
            return self::convertString2Date($source, $format);
    }



    /**
     * <pre>
     * [概要]
     * yyyymmddをyyyy/mm/ddにします。
     * </pre>
     * @param type $source
     * @param type $length
     * @param type $insertString
     * @return type
     * @author h.geka
     */
    public static function convertYMDWithSlash($source, $separator="/") {

        if (!self::isLengthEqual($source, 8)) {
            return $source;
        }else if(!ctype_digit($source)){
            return $source;
        }

        list($year, $month, $day) = sscanf($source, "%4d%2d%2d");

        if(self::validateDate($month, $day, $year)){
            $format = "Y" . $separator . "m" . $separator . "d";
            return date($format, strtotime($source));
//            return $year. $separator . $month . $separator . $day;
        }else{
            return $source;
        }

    }

    /**
     * 指定した日付からlength日後を返します。
     * マイナスを指定した場合はlength日前を返します。
     * @param unknown $source 対象の日付
     * @param unknown $length N日後
     * @param string $returnFormat 返却のフォーマットに指定がある場合
     * @param string $modify　day, month, year, hour, minits, sec デフォルトはday
     */
    public static function getAfterDate($source, $length, $modify = "day", $returnFormat = "Y-m-d H:i:s") {
    	$targetTime = date("Y-m-d H:i:s", strtotime($source));
    	return date($returnFormat, strtotime($length . " ". $modify, $targetTime));
    }

    /**
     * <pre>
     * [概要]
     * 正しい日付か判定し、結果を真偽値で返却します。
     * Integerでなく、Stringを渡してください。
     *
     * [備考]
     * 本仕様上、日付の入力値は必ずyyyyMMdd形式です。
     *
     * [妥当性検証項目]
     * ・NULL／空文字：FALSE
     * ・データ長が8以外：FALSE
     * ・yyyyMMddの順序以外：FALSE
     * ・存在しない日付：FALSE
     * </pre>
     *
     * @param string $source
     * @return boolean
     * @author h.geka
     */
    public static function isValidDateYMD($source) {

        if(self::isEmpty($source)){
            return FALSE;
        }

        if (!self::isLengthEqual($source, 8)) {
            return FALSE;
        }else if(!ctype_digit($source)){
            return FALSE;
        }

        list($year, $month, $day) = sscanf($source, "%4d%2d%2d");

        if(self::validateDate($month, $day, $year)){
        	if (date("Ymd", strtotime($source)) == $source) {
	            return TRUE;
        	} else {
        		return FALSE;
        	}
        }else{
            return FALSE;
        }

    }

    public static function isValidDateYMDHI($source) {

    	if(self::isEmpty($source)){
    		return FALSE;
    	}

    	if (!self::isLengthEqual($source, 12)) {
    		return FALSE;
    	}else if(!ctype_digit($source)){
    		return FALSE;
    	}

    	list($year, $month, $day, $hour, $min) = sscanf($source, "%4d%2d%2d%2d%2d");

    	if(self::validateDate($month, $day, $year)){
    		$strHour = "";
    		if ($hour < 10) {
    			$strHour = "0" . $hour;
    		} else {
    			$strHour = "" . $hour;
    		}
    		$strMin = "";
    		if ($min < 10) {
    			$strMin = "0" . $min;
    		} else {
    			$strMin = "" . $min;
    		}

    		if(self::isValidDateTimeHi($strHour . $strMin)){
    			return TRUE;
    		}
    		return FALSE;
    	}else{
    		return FALSE;
    	}

    }

    /**
     * <pre>
     * [概要]
     * 正しい日付か（期の基準）判定し、結果を真偽値で返却します。
     * Integerでなく、Stringを渡してください。
     *
     * [備考]
     * 本仕様上、日付の入力値は必ずMMdd形式（期の基準）です。
     *
     * [妥当性検証項目]
     * ・NULL／空文字：FALSE
     * ・データ長が4以外：FALSE
     * ・MMddの順序以外：FALSE
     * ・存在しない日付：FALSE
     * </pre>
     *
     * @param string $source
     * @return boolean
     * @author h.geka
     */
    public static function isValidDateMD($source) {

        if(self::isEmpty($source)){
            return FALSE;
        }

        if (!self::isLengthEqual($source, 4)) {
            return FALSE;
        }else if(!ctype_digit($source)){
            return FALSE;
        }

        $today = getdate();
        $year = $today["year"];
        list($month, $day) = sscanf($source, "%2d%2d");

        if(self::validateDate($month, $day, $year)){
            return TRUE;
        }else{
            return FALSE;
        }

    }



    /**
     * <pre>
     * [概要]
     * 正しい日付か（yyMM）判定し、結果を真偽値で返却します。
     * Integerでなく、Stringを渡してください。
     *
     * [備考]
     *
     * [妥当性検証項目]
     * ・NULL／空文字：FALSE
     * ・データ長が4以外：FALSE
     * ・MMddの順序以外：FALSE
     * ・存在しない日付：FALSE
     * </pre>
     *
     * @param string $source
     * @return boolean
     * @author h.geka
     */
    public static function isValidDateYM($source) {

        if(self::isEmpty($source)){
            return FALSE;
        }

        if (!self::isLengthEqual($source, 6)) {
            return FALSE;
        }else if(!ctype_digit($source)){
            return FALSE;
        }

        $today = getdate();
        $day = "01";
        list($year,$month) = sscanf($source, "%4d%2d");

        if(self::validateDate($month, $day, $year)){
            return TRUE;
        }else{
            return FALSE;
        }

    }



    /**
     * <pre>
     * [概要]
     * 正しい日付か判定し、結果を真偽値で返却します。
     * Integerでなく、Stringを渡してください。
     *
     * [備考]
     * 本仕様上、時分の入力値は必ずHi（HHmm）形式です。
     * （1時1分：0101、23時59分：2359）
     * [妥当性検証項目]
     * ・NULL／空文字：FALSE
     * ・データ長が4以外：FALSE
     * ・Hiの順序以外：FALSE
     * ・存在しない時分：FALSE
     * </pre>
     *
     * @param string $source
     * @return boolean
     * @author h.geka
     */
    public static function isValidDateTimeHi($source) {

        if(self::isEmpty($source)){
            return FALSE;
        }

        if (!self::isLengthEqual($source, 4)) {
            return FALSE;
        }else if(!ctype_digit($source)){
            return FALSE;
        }

        list($hour, $minute) = sscanf($source, "%2d%2d");

        if (self::validateTime((int) $hour, (int) $minute)) {
            return TRUE;
        } else {
            return FALSE;
        }

    }



    /**
     * <pre>
     * [概要]
     * グレゴリオ暦の日付/時刻の妥当性を確認します。
     * http://php.net/manual/ja/function.checkdate.php
     * </pre>
     * @param type $month
     * @param type $day
     * @param type $year
     * @return type
     * @author h.geka
     */
    public static function validateDate($month, $day, $year)
    {
        return checkdate($month, $day, $year);
    }



    /**
     * <pre>
     * [概要]
     * ○時○分○秒の妥当性を確認します。
     * 秒は必須ではありませんが、渡した秒がNULL／空文字の場合FALSEを返却します。
     * </pre>
     * @param int $hour
     * @param int $minute
     * @param int $second
     * @return boolean
     * @author h.geka
     */
    public static function validateTime($hour, $minute, $second=0) {

        if(self::isEmpty($hour) || self::isEmpty($minute) || self::isEmpty($second)){
             return FALSE;
        }

         if ($hour < 0 || $hour > 23 || !is_numeric($hour)) {
             return FALSE;
         }

         if ($minute < 0 || $minute > 59 || !is_numeric($minute)) {
             return FALSE;
         }

         if ($second < 0 || $second > 59 || !is_numeric($second)) {
             return FALSE;
         }

         return TRUE;
    }



    /**
     * <pre>
     * [概要]
     * arrayデータをentityへ代入します。
     * </pre>
     * @param array $arrData
     * @param entity $entity
     * @param headerString $headerString DB側の除外先頭文字
     * @author y.mori
     */
    public static function convertArrayToEntity($arrData, $entity, $deleteHeaderKeyString = "") {
		foreach ($arrData as $rowKey => $rowValue) {
			if ($deleteHeaderKeyString != "") {
				$keepRowKey = $rowKey;
				$rowKey = substr($rowKey, strlen($deleteHeaderKeyString));
			}
			foreach ($entity as $entityKey => $entityValue) {
				if ($entityKey == $rowKey) {
					$entity->$entityKey = $rowValue;
				}
			}
		}
    	return $entity;
    }

    /**
     * <pre>
     * [概要]
     * arrayデータをformへ代入します。
     * </pre>
     * @param array $arrData
     * @param form $form
     * @author y.mori
     */
    public static function convertArrayToForm($arrData, $form) {
    	foreach ($arrData as $rowKey => $rowValue) {
    		try {
	    		$rowKey = "set" . ucfirst($rowKey);
	    		if (method_exists($form, $rowKey)) {
	    			$form->$rowKey($rowValue);
	    		}
    		} catch (Exception $e) {
    			// 握りつぶす
    		}
    	}
    	return $form;
    }



    /**
     * <pre>
     * [概要]
     * データベースから取り出したarrayデータをformへ代入します。
     * </pre>
     * @param array $arrData
     * @param form $form
     * @author y.mori
     */
    public static function convertDBArrayToForm($arrData, $form) {
        foreach ($arrData as $rowKey => $rowValue) {
            try {
                $columns = explode("_", $rowKey);
                $columnName = "";
                foreach ($columns as $column) {
                    $columnName = $columnName . ucfirst($column);
                }
                $rowKey = "set" . $columnName;
                if (method_exists($form, $rowKey)) {
                    $form->$rowKey($rowValue);
                }
            } catch (Exception $e) {
                // 握りつぶす
            }
        }
        return $form;
    }

    /**
     * <pre>
     * [概要]
     * entityデータをentityへ代入します。
     * </pre>
     * @param array $arrData
     * @param entity $entity
     * @author y.mori
     */
    public static function convertEntityToEntity($from, $to) {
    	foreach ($from as $fromKey => $fromValue) {
    		foreach ($to as $toKey => $toValue) {
    			if ($fromKey == $toKey) {
    				$to->$toKey = $fromValue;
    			}
    		}
    	}
    	return $to;
    }

    /**
     * <pre>
     * [概要]
     * entityデータをentityへ代入します。
     * </pre>
     * @param array $arrData
     * @param entity $entity
     * @author y.mori
     */
    public static function convertFormToEntity($form, $to) {
    	foreach ($to as $toKey => $toValue) {
    		$rowKey = $toKey;
    		$rowValue = $toValue;
    		$columns = explode("_", $rowKey);
    		$columnName = "";
    		foreach ($columns as $column) {
    			$columnName = $columnName . ucfirst($column);
    		}
    		$rowKey = "get" . $columnName;
    		if (method_exists($form, $rowKey)) {
    			$to->$toKey = $form->$rowKey();
    		}
    	}
    	return $to;
    }

    public static function isSmartPhone($userAgent, $fowardTpl) {
    	$userAgent = mb_strtolower($userAgent);
//    	$userAgent = "iphone";

    	$device = "";
		if (strpos($userAgent,"iphone") !== false){
			$device = "mobile";
		} else if (strpos($userAgent,"ipod") !== false){
			$device = "mobile";
		} else if ((strpos($userAgent,"android") !== false) && (strpos($userAgent, "mobile") !== false)){
			$device = "mobile";
		} else if ((strpos($userAgent,"windows") !== false) && (strpos($userAgent, "phone") !== false)){
			$device = "mobile";
		} else if ((strpos($userAgent,"firefox") !== false) && (strpos($userAgent, "mobile") !== false)){
			$device = "mobile";
		} else if (strpos($userAgent,"blackberry") !== false){
			$device = "mobile";
		} else if (strpos($userAgent,"ipad") !== false){
			$device = "tablet";
		} else if ((strpos($userAgent,"windows") !== false) && (strpos($userAgent, "touch") !== false && (strpos($userAgent, "tablet pc") == false))){
//			$device = "tablet";
		} else if ((strpos($userAgent,"android") !== false) && (strpos($userAgent, "mobile") === false)){
			$device = "tablet";
		} else if ((strpos($userAgent,"firefox") !== false) && (strpos($userAgent, "tablet") !== false)){
			$device = "tablet";
		} else if ((strpos($userAgent,"kindle") !== false) || (strpos($userAgent, "silk") !== false)){
			$device = "tablet";
		} else if ((strpos($userAgent,"playbook") !== false)){
			$device = "tablet";
		}
//		$device = "ok";//テスト用
		if ($device != "") {
			$fowardTpl->setTemplate("/sp" . $fowardTpl->getTemplate());
		}
		return $fowardTpl;
	}
	
	/**
	 * 半角カナあるいはカナで濁音有りの場合の変換ロジック
	 * @param unknown $data
	 */
	public static function convertKana($data) {
		$data = mb_convert_kana($data, "K");
		$changeArray = array(
				array("ガ","カ゛"),
				array("ギ","キ゛"),
				array("グ","ク゛"),
				array("ゲ","ケ゛"),
				array("ゴ","コ゛"),
				array("ザ","サ゛"),
				array("ジ","シ゛"),
				array("ズ","ス゛"),
				array("ゼ","セ゛"),
				array("ゾ","ソ゛"),
				array("ダ","タ゛"),
				array("ヂ","チ゛"),
				array("ヅ","ツ゛"),
				array("デ","テ゛"),
				array("ド","ト゛"),
				array("バ","ハ゛"),
				array("ビ","ヒ゛"),
				array("ブ","フ゛"),
				array("ベ","ヘ゛"),
				array("ボ","ホ゛"),
				array("パ","ハ゜"),
				array("ピ","ヒ゜"),
				array("プ","フ゜"),
				array("ペ","ヘ゜"),
				array("ポ","ホ゜")
		);
		foreach ($changeArray as $changeData) {
			$data = str_replace($changeData[1], $changeData[0], $data);
		}
		
		return $data;
	}

	/**
	 * 電話番後のパース
	 * @param unknown $input
	 * @param string $strict
	 */
	public static function formatPhoneNumber($input, $strict = false) {
		$groups = array(
				5 =>
				array (
						"01564" => 1,
						"01558" => 1,
						"01586" => 1,
						"01587" => 1,
						"01634" => 1,
						"01632" => 1,
						"01547" => 1,
						"05769" => 1,
						"04992" => 1,
						"04994" => 1,
						"01456" => 1,
						"01457" => 1,
						"01466" => 1,
						"01635" => 1,
						"09496" => 1,
						"08477" => 1,
						"08512" => 1,
						"08396" => 1,
						"08388" => 1,
						"08387" => 1,
						"08514" => 1,
						"07468" => 1,
						"01655" => 1,
						"01648" => 1,
						"01656" => 1,
						"01658" => 1,
						"05979" => 1,
						"04996" => 1,
						"01654" => 1,
						"01372" => 1,
						"01374" => 1,
						"09969" => 1,
						"09802" => 1,
						"09912" => 1,
						"09913" => 1,
						"01398" => 1,
						"01377" => 1,
						"01267" => 1,
						"04998" => 1,
						"01397" => 1,
						"01392" => 1,
				),
				4 =>
				array (
						"0768" => 2,
						"0770" => 2,
						"0772" => 2,
						"0774" => 2,
						"0773" => 2,
						"0767" => 2,
						"0771" => 2,
						"0765" => 2,
						"0748" => 2,
						"0747" => 2,
						"0746" => 2,
						"0826" => 2,
						"0749" => 2,
						"0776" => 2,
						"0763" => 2,
						"0761" => 2,
						"0766" => 2,
						"0778" => 2,
						"0824" => 2,
						"0797" => 2,
						"0796" => 2,
						"0555" => 2,
						"0823" => 2,
						"0798" => 2,
						"0554" => 2,
						"0820" => 2,
						"0795" => 2,
						"0556" => 2,
						"0791" => 2,
						"0790" => 2,
						"0779" => 2,
						"0558" => 2,
						"0745" => 2,
						"0794" => 2,
						"0557" => 2,
						"0799" => 2,
						"0738" => 2,
						"0567" => 2,
						"0568" => 2,
						"0585" => 2,
						"0586" => 2,
						"0566" => 2,
						"0564" => 2,
						"0565" => 2,
						"0587" => 2,
						"0584" => 2,
						"0581" => 2,
						"0572" => 2,
						"0574" => 2,
						"0573" => 2,
						"0575" => 2,
						"0576" => 2,
						"0578" => 2,
						"0577" => 2,
						"0569" => 2,
						"0594" => 2,
						"0827" => 2,
						"0736" => 2,
						"0735" => 2,
						"0725" => 2,
						"0737" => 2,
						"0739" => 2,
						"0743" => 2,
						"0742" => 2,
						"0740" => 2,
						"0721" => 2,
						"0599" => 2,
						"0561" => 2,
						"0562" => 2,
						"0563" => 2,
						"0595" => 2,
						"0596" => 2,
						"0598" => 2,
						"0597" => 2,
						"0744" => 2,
						"0852" => 2,
						"0956" => 2,
						"0955" => 2,
						"0954" => 2,
						"0952" => 2,
						"0957" => 2,
						"0959" => 2,
						"0966" => 2,
						"0965" => 2,
						"0964" => 2,
						"0950" => 2,
						"0949" => 2,
						"0942" => 2,
						"0940" => 2,
						"0930" => 2,
						"0943" => 2,
						"0944" => 2,
						"0948" => 2,
						"0947" => 2,
						"0946" => 2,
						"0967" => 2,
						"0968" => 2,
						"0987" => 2,
						"0986" => 2,
						"0985" => 2,
						"0984" => 2,
						"0993" => 2,
						"0994" => 2,
						"0997" => 2,
						"0996" => 2,
						"0995" => 2,
						"0983" => 2,
						"0982" => 2,
						"0973" => 2,
						"0972" => 2,
						"0969" => 2,
						"0974" => 2,
						"0977" => 2,
						"0980" => 2,
						"0979" => 2,
						"0978" => 2,
						"0920" => 2,
						"0898" => 2,
						"0855" => 2,
						"0854" => 2,
						"0853" => 2,
						"0553" => 2,
						"0856" => 2,
						"0857" => 2,
						"0863" => 2,
						"0859" => 2,
						"0858" => 2,
						"0848" => 2,
						"0847" => 2,
						"0835" => 2,
						"0834" => 2,
						"0833" => 2,
						"0836" => 2,
						"0837" => 2,
						"0846" => 2,
						"0845" => 2,
						"0838" => 2,
						"0865" => 2,
						"0866" => 2,
						"0892" => 2,
						"0889" => 2,
						"0887" => 2,
						"0893" => 2,
						"0894" => 2,
						"0897" => 2,
						"0896" => 2,
						"0895" => 2,
						"0885" => 2,
						"0884" => 2,
						"0869" => 2,
						"0868" => 2,
						"0867" => 2,
						"0875" => 2,
						"0877" => 2,
						"0883" => 2,
						"0880" => 2,
						"0879" => 2,
						"0829" => 2,
						"0550" => 2,
						"0228" => 2,
						"0226" => 2,
						"0225" => 2,
						"0224" => 2,
						"0229" => 2,
						"0233" => 2,
						"0237" => 2,
						"0235" => 2,
						"0234" => 2,
						"0223" => 2,
						"0220" => 2,
						"0192" => 2,
						"0191" => 2,
						"0187" => 2,
						"0193" => 2,
						"0194" => 2,
						"0198" => 2,
						"0197" => 2,
						"0195" => 2,
						"0238" => 2,
						"0240" => 2,
						"0260" => 2,
						"0259" => 2,
						"0258" => 2,
						"0257" => 2,
						"0261" => 2,
						"0263" => 2,
						"0266" => 2,
						"0265" => 2,
						"0264" => 2,
						"0256" => 2,
						"0255" => 2,
						"0243" => 2,
						"0242" => 2,
						"0241" => 2,
						"0244" => 2,
						"0246" => 2,
						"0254" => 2,
						"0248" => 2,
						"0247" => 2,
						"0186" => 2,
						"0185" => 2,
						"0144" => 2,
						"0143" => 2,
						"0142" => 2,
						"0139" => 2,
						"0145" => 2,
						"0146" => 2,
						"0154" => 2,
						"0153" => 2,
						"0152" => 2,
						"0138" => 2,
						"0137" => 2,
						"0125" => 2,
						"0124" => 2,
						"0123" => 2,
						"0126" => 2,
						"0133" => 2,
						"0136" => 2,
						"0135" => 2,
						"0134" => 2,
						"0155" => 2,
						"0156" => 2,
						"0176" => 2,
						"0175" => 2,
						"0174" => 2,
						"0178" => 2,
						"0179" => 2,
						"0184" => 2,
						"0183" => 2,
						"0182" => 2,
						"0173" => 2,
						"0172" => 2,
						"0162" => 2,
						"0158" => 2,
						"0157" => 2,
						"0163" => 2,
						"0164" => 2,
						"0167" => 2,
						"0166" => 2,
						"0165" => 2,
						"0267" => 2,
						"0250" => 2,
						"0533" => 2,
						"0422" => 2,
						"0532" => 2,
						"0531" => 2,
						"0436" => 2,
						"0428" => 2,
						"0536" => 2,
						"0299" => 2,
						"0294" => 2,
						"0293" => 2,
						"0475" => 2,
						"0295" => 2,
						"0297" => 2,
						"0296" => 2,
						"0495" => 2,
						"0438" => 2,
						"0466" => 2,
						"0465" => 2,
						"0467" => 2,
						"0478" => 2,
						"0476" => 2,
						"0470" => 2,
						"0463" => 2,
						"0479" => 2,
						"0493" => 2,
						"0494" => 2,
						"0439" => 2,
						"0268" => 2,
						"0480" => 2,
						"0460" => 2,
						"0538" => 2,
						"0537" => 2,
						"0539" => 2,
						"0279" => 2,
						"0548" => 2,
						"0280" => 2,
						"0282" => 2,
						"0278" => 2,
						"0277" => 2,
						"0269" => 2,
						"0270" => 2,
						"0274" => 2,
						"0276" => 2,
						"0283" => 2,
						"0551" => 2,
						"0289" => 2,
						"0287" => 2,
						"0547" => 2,
						"0288" => 2,
						"0544" => 2,
						"0545" => 2,
						"0284" => 2,
						"0291" => 2,
						"0285" => 2,
						"0120" => 3,
						"0570" => 3,
						"0800" => 3,
						"0990" => 3,
				),
				3 =>
				array (
						"099" => 3,
						"054" => 3,
						"058" => 3,
						"098" => 3,
						"095" => 3,
						"097" => 3,
						"052" => 3,
						"053" => 3,
						"011" => 3,
						"096" => 3,
						"049" => 3,
						"015" => 3,
						"048" => 3,
						"072" => 3,
						"084" => 3,
						"028" => 3,
						"024" => 3,
						"076" => 3,
						"023" => 3,
						"047" => 3,
						"029" => 3,
						"075" => 3,
						"025" => 3,
						"055" => 3,
						"026" => 3,
						"079" => 3,
						"082" => 3,
						"027" => 3,
						"078" => 3,
						"077" => 3,
						"083" => 3,
						"022" => 3,
						"086" => 3,
						"089" => 3,
						"045" => 3,
						"044" => 3,
						"092" => 3,
						"046" => 3,
						"017" => 3,
						"093" => 3,
						"059" => 3,
						"073" => 3,
						"019" => 3,
						"087" => 3,
						"042" => 3,
						"018" => 3,
						"043" => 3,
						"088" => 3,
						"050" => 4,
				),
				2 =>
				array (
						"04" => 4,
						"03" => 4,
						"06" => 4,
				),
		);
		$groups[3] +=
		$strict ?
		array(
				"020" => 3,
				"070" => 3,
				"080" => 3,
				"090" => 3,
		) :
		array(
				"020" => 4,
				"070" => 4,
				"080" => 4,
				"090" => 4,
		)
		;
		$number = preg_replace("/[^\d]++/", "", $input);
		foreach ($groups as $len => $group) {
			$area = substr($number, 0, $len);
			if (isset($group[$area])) {
				$formatted = implode("-", array(
						$area,
						substr($number, $len, $group[$area]),
						substr($number, $len + $group[$area])
				));
				return strrchr($formatted, "-") !== "-" ? $formatted : $input;
			}
		}
		$pattern = "/\A(00(?:[013-8]|2\d|91[02-9])\d)(\d++)\z/";
		if (preg_match($pattern, $number, $matches)) {
			return $matches[1] . "-" . $matches[2];
		}
		return $input;
	}
	

}
