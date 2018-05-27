<?php

namespace Tests\Feature\Test;

use Tests\TestCase;

/**
 * このファイルのみを実行したい場合は、アプリケーションルートで以下を実行
 * sudo vendor/bin/phpunit ./tests/Feature/Test/TestFeatureTest.php
 * @author Administrator
 *
 */
class TestFeatureTest extends TestCase
{

	/**
	 * 初期表示テスト
	 */
	public function testSearchValidation1()
	{
		$response = $this->json(
				'POST',
				'/test/test/search',
				[
				]
			);
	
		$response->assertStatus(200)->assertViewHasAll(
				[
						"errors" => null,
						"inputs" => null,
				])->assertViewHas("results", []);
	}
	
	/**
	 * バリデーション失敗
	 */
    public function testSearchValidation2()
    {
        $response = $this->json(
        		'POST', 
        		'/test/test/search', 
        		[
        			'userId' => 'kigo123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
        			'key' => 'kigo@123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
        			'buttonNo' => 'search',
        		]
        );
        
        $response->assertStatus(200)->assertViewHasAll(
       		[
				"errors" => [
        			"userId" => [
        				"user idには数値を指定してください。"
        			],
					"key" => [
						"keyには255文字以下の文字列を指定してください。",
						"keyには半角英数字を指定してください。"
					]
				],
       			"inputs" => [
       					'userId' => 'kigo123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
       					'key' => 'kigo@123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
       					'buttonNo' => 'search',
       			],
       			"results" => null
       		]);
    }
    
    /**
     * バリデーション失敗（データプロバイダー使用）
     * 
     * @dataProvider validationProvider
     * @param unknown $userId
     * @param unknown $key
     * @param unknown $buttonNo
     * @param unknown $errors
     */
    public function testSearchValidationProvider($userId, $key, $buttonNo, $results)
    {
    	$response = $this->json(
    			'POST',
    			'/test/test/search',
    			[
    					'userId' => $userId,
    					'key' => $key,
    					'buttonNo' => $buttonNo,
    			]
    			);
    
    	$response->assertStatus(200)->assertViewHasAll([$results]);
    }
    
    public function validationProvider() {
    	return [
    			"pattern1" => [
    					'あ', 
    					'', 
    					'search', 
    					[
    							"errors" => [
    									"userId" => ["user idには数値を指定してください。"]
    							],
    							"inputs" => [
    									'userId' => 'あ',
    									'key' => '',
    									'buttonNo' => 'search',
    							],
    							"results" => null
    					],
    			],
    			"pattern2" => [
    					'1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
    					'',
    					'search',
    					[
    							"errors" => null,
    							"inputs" => [
    									'userId' => '1234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
    									'key' => '',
    									'buttonNo' => 'search',
    							],
    							"results" => []
    					],
    			],
    			"pattern3" => [
    					'',
    					'123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
    					'search',
    					[
    							"errors" => [
    									"key" => ["keyには255文字以下の文字列を指定してください。"]
    							],
    							"inputs" => [
    									'userId' => '',
    									'key' => '123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
    									'buttonNo' => 'search',
    							],
    							"results" => null
    					],
    			],
    			"pattern4" => [
    					'',
    					'あああ',
    					'search',
    					[
    							"errors" => [
    									"key" => ["keyには半角英数字を指定してください。"]
    							],
    							"inputs" => [
    									'userId' => '',
    									'key' => 'あああ',
    									'buttonNo' => 'search',
    							],
    							"results" => null
    					],
    			],
    			"pattern5" => [
    					'',
    					'あああ123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
    					'search',
    					[
    							"errors" => [
    									"key" => ["keyには255文字以下の文字列を指定してください。", "keyには半角英数字を指定してください。"]
    							],
    							"inputs" => [
    									'userId' => '',
    									'key' => 'あああ123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
    									'buttonNo' => 'search',
    							],
    							"results" => null
    					],
    			],
    			"pattern6" => [
    					'54*',
    					'あああ123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
    					'search',
    					[
    							"errors" => [
    									"userId" => ["user idには数値を指定してください。"],
    									"key" => ["keyには255文字以下の文字列を指定してください。", "keyには半角英数字を指定してください。"]
    							],
    							"inputs" => [
    									'userId' => '54*',
    									'key' => 'あああ123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890123456789012345678901234567890',
    									'buttonNo' => 'search',
    							],
    							"results" => null
    					],
    			]
    			 
    	];
    }
}
