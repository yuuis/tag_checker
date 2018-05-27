<?php

namespace App\Commons\Utils;

/**
 * Redis絡みの共通関数
 * @author y.mori
 */
class RedisUtil {
	private function __construct()
	{
	}
	
	/**
	 * データセット
	 * @param unknown $key
	 * @param unknown $value
	 * @param string $ttl
	 */
	public static function set($key, $value, $ttl = 900)
	{
		$cache = new \Redis();
		$cache->pconnect(\Config::get("redis.REDIS_IP_ADDRESS"), \Config::get("redis.REDIS_PORT"), \Config::get("redis.REDIS_TIMEOUT"), \Config::get("redis.REDIS_CONNECTION_POOL"));
		
		if ($key != "") {
    		$cache->set($key, $value);
    		$cache->expire($key, $ttl);
		}
		
		$cache->close();
	}
	
	/**
	 * データ取得
	 * @param unknown $key
	 */
	public static function get($key)
	{
		$cache = new \Redis();
		$cache->pconnect(\Config::get("redis.REDIS_IP_ADDRESS"), \Config::get("redis.REDIS_PORT"), \Config::get("redis.REDIS_TIMEOUT"), \Config::get("redis.REDIS_CONNECTION_POOL"));
		
		$returnData = NULL;
		if ($key != "") {
			$returnData = $cache->get($key);
		}
		
		$cache->close();
		return $returnData;
	}
	
	/**
	 * 保存したデータをクリアする
	 * @param unknown $key
	 */
	public static function del($key)
	{
		$cache = new \Redis();
		$cache->pconnect(\Config::get("redis.REDIS_IP_ADDRESS"), \Config::get("redis.REDIS_PORT"), \Config::get("redis.REDIS_TIMEOUT"), \Config::get("redis.REDIS_CONNECTION_POOL"));
		
		if ($key != "") {
			$cache->del($key);
		}
		
		$cache->close();
	}
}
