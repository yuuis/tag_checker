<?php
namespace App\Commons\Validations;
class CustomValidator 
{
	/**
	 * ひらがなのみの入力判定
	 *
	 * @param  string  $attribute
	 * @param  mixed  $value
	 * @return bool
	 */
	public function hiragana($attribute, $value)
	{
		if (preg_match("/[^ぁ-んー]/u", $value) !== 0) {
			return false;
		}
		
		return true;
	}
	
	/**
	 * カタカナのみの入力判定
	 */
	public function katakana($attribute, $value) {
		if (preg_match("/^[ァ-ヶー]+$/u", $value)) {
			return true;
		}
		return false;
	}
	
	/**
	 * 英数字のみの入力判定（デフォルトのものは全角を比較しないため）
	 * @param unknown $attribute
	 * @param unknown $value
	 */
	public function eisuu($attribute, $value) {
		if(ctype_alnum($value)) {
			return true;
		}		
		return false;
	}
}
