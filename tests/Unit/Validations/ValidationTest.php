<?php

namespace Tests\Unit;

use Tests\TestCase;

/**
 * このファイルのみを実行したい場合は、アプリケーションルートで以下を実行
 * sudo vendor/bin/phpunit ./tests/Unit/Validations/ValidationTest.php
 * @author Administrator
 *
 */
class ValidationTest extends TestCase
{
	static $hanKigo = "!\"#$%&'()*+,-./:;<=>?@[\]^_`{|}~";
	static $hanSuuji = "0123456789";
	static $hanOoEigo = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
	static $hanKoEigo = "abcdefghijklmnopqrstuvwxyz";
	static $zenKigo = "、。，．・：；？！゛゜´｀¨＾￣＿ヽヾゝゞ〃仝々〆〇ー―‐／＼～∥｜…‥‘’“”（）〔〕［］｛｝〈〉《》「」『』【】＋－±×÷＝≠＜＞≦≧∞∴♂♀°′″℃￥＄￠￡％＃＆＊＠§☆★○●◎◇◆□■△▲▽▼※〒→←↑↓〓∈∋⊆⊇⊂⊃∪∩∧∨￢⇒⇔∀∃∠⊥⌒∂∇≡≒≪≫√∽∝∵∫∬Å‰♯♭♪ΑΒΓΔΕΖΗΘΙΚΛΜΝΞΟΠΡΣΤΥΦΧΨΩαβγδεζηθικλμνξοπρστυφχψωАБВГДЕЁЖЗИЙКЛМНОПРСТУФХЦЧШЩЪЫЬЭЮЯабвгдеёжзийклмнопрстуфхцчшщъыьэюя─│┌┐┘└├┬┤┴┼━┃┏┓┛┗┣┳┫┻╋┠┯┨┷┿┝┰┥┸╂｡｢｣､･①②③④⑤⑥⑦⑧⑨⑩⑪⑫⑬⑭⑮⑯⑰⑱⑲⑳ⅠⅡⅢⅣⅤⅥⅦⅧⅨⅩ㍉㌔㌢㍍㌘㌧㌃㌶㍑㍗㌍㌦㌣㌫㍊㌻㎜㎝㎞㎎㎏㏄㎡㍻〝〟№㏍℡㊤㊥㊦㊧㊨㈱㈲㈹㍾㍽㍼≒≡∫∮∑√⊥∠∟⊿∵∩∪";
	static $zenSuuji = "０１２３４５６７８９";
	static $zenOoEigo = "ＡＢＣＤＥＦＧＨＩＪＫＬＭＮＯＰＱＲＳＴＵＶＷＸＹＺ";
	static $zenKoEigo = "ａｂｃｄｅｆｇｈｉｊｋｌｍｎｏｐｑｒｓｔｕｖｗｘｙｚ";
	static $hiragana = "ぁあぃいぅうぇえぉおかがきぎくぐけげこごさざしじすずせぜそぞただちぢっつづてでとどなにぬねのはばぱひびぴふぶぷへべぺほぼぽまみむめもゃやゅゆょよらりるれろゎわゐゑをん";
	static $zenKana = "ァアィイゥウェエォオカガキギクグケゲコゴサザシジスズセゼソゾタダチヂッツヅテデトドナニヌネノハバパヒビピフブプヘベペホボポマミムメモャヤュユョヨラリルレロヮワヰヱヲンヴヵヶ";
	static $hanKana = "ｦｧｨｩｪｫｬｭｮｯｰｱｲｳｴｵｶｷｸｹｺｻｼｽｾｿﾀﾁﾂﾃﾄﾅﾆﾇﾈﾉﾊﾋﾌﾍﾎﾏﾐﾑﾒﾓﾔﾕﾖﾗﾘﾙﾚﾛﾜﾝﾞﾟ";
	
	public function testHiraganaTrue()
	{
		$validation = new \App\Commons\Validations\CustomValidator();
		$this->assertTrue($validation->hiragana('hiragana', self::$hiragana));
	}
	/**
	 * @dataProvider hiraganaProvider
	 * @param unknown $hiragana
	 */
	public function testHiraganaFalse($hiragana)
	{
		$validation = new \App\Commons\Validations\CustomValidator();
		$this->assertFalse($validation->hiragana('hiragana', $hiragana));
	}
	public function hiraganaProvider() {
		$returnArray = array();
		foreach (str_split(self::$hanKigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hanSuuji) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hanOoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hanKoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenKigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenSuuji) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenOoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenKoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenKana) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hanKana) as $value) {
			$returnArray[$value] = [$value];
		}
		return $returnArray;
	}
	
	public function testKatakanaTrue()
	{
		$validation = new \App\Commons\Validations\CustomValidator();
		$this->assertTrue($validation->Katakana('Katakana', self::$zenKana));
	}

	/**
	 * @dataProvider katakanaProvider
	 * @param unknown $katakana
	 */
	public function testKatakanaFalse($katakana)
	{
		$validation = new \App\Commons\Validations\CustomValidator();
		$this->assertFalse($validation->Katakana('Katakana', $katakana));
	}
	public function katakanaProvider() {
		$returnArray = array();
		foreach (str_split(self::$hanKigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hanSuuji) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hanOoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hanKoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenKigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenSuuji) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenOoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenKoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hiragana) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hanKana) as $value) {
			$returnArray[$value] = [$value];
		}
		
		return $returnArray;
	}
	
	public function testEisuuTrueSuuji()
	{
		$validation = new \App\Commons\Validations\CustomValidator();
		$this->assertTrue($validation->eisuu('eisuu1', self::$hanSuuji));
	}
	public function testEisuuTrueOoEigo()
	{
		$validation = new \App\Commons\Validations\CustomValidator();
		$this->assertTrue($validation->eisuu('eisuu1', self::$hanOoEigo));
	}
	public function testEisuuTrueKoEigo()
	{
		$validation = new \App\Commons\Validations\CustomValidator();
		$this->assertTrue($validation->eisuu('eisuu1', self::$hanKoEigo));
	}
	public function testEisuuTrue()
	{
		$validation = new \App\Commons\Validations\CustomValidator();
		$this->assertTrue($validation->eisuu('eisuu1', self::$hanSuuji . self::$hanOoEigo . self::$hanKoEigo));
	}
	
	/**
	 * @dataProvider eisuuProvider
	 * @param unknown $eisuu
	 */
	public function testEisuuFalse($eisuu)
	{
		$validation = new \App\Commons\Validations\CustomValidator();
		$this->assertFalse($validation->eisuu('eisuu1', $eisuu));
	}
	
	public function eisuuProvider()
	{
		$returnArray = array();
		foreach (str_split(self::$hanKigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenKigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenSuuji) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenOoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenKoEigo) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hiragana) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$zenKana) as $value) {
			$returnArray[$value] = [$value];
		}
		foreach (str_split(self::$hanKana) as $value) {
			$returnArray[$value] = [$value];
		}
		
		
		return $returnArray;
	}

}
