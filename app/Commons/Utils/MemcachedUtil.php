<?php

namespace App\Commons\Utils;

/**
 * Memcached絡みの共通関数
 * @author y.mori
 */
class MemcachedUtil {
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
		$cache = new \Memcached(\Config::get("memcached.MEMCACHED_CONNECTION_POOL"));
		if (count($cache->getServerList()) === 0) {
			$cache->addServer(\Config::get("memcached.MEMCACEHD_SERVER_ADDRESS"), \Config::get("memcached.MEMCACEHD_SERVER_PORT"));
			$cache->setOption(\Memcached::OPT_COMPRESSION, true);
			$cache->setOption(\Memcached::OPT_SERVER_FAILURE_LIMIT, \Config::get("memcached.MEMCACHED_FAILURE_LIMIT"));
		}
		
		$cache->set($key, $value, time() + $ttl);
	}
	
	/**
	 * データ取得
	 * @param unknown $key
	 */
	public static function get($key)
	{
		$cache = new \Memcached(\Config::get("memcached.MEMCACHED_CONNECTION_POOL"));
		if (count($cache->getServerList()) === 0) {
			$cache->addServer(\Config::get("memcached.MEMCACEHD_SERVER_ADDRESS"), \Config::get("memcached.MEMCACEHD_SERVER_PORT"));
			$cache->setOption(\Memcached::OPT_COMPRESSION, true);
			$cache->setOption(\Memcached::OPT_SERVER_FAILURE_LIMIT, \Config::get("memcached.MEMCACHED_FAILURE_LIMIT"));
		}
		
		$returnData = NULL;
		if ($key != "") {
			$returnData = $cache->get($key);
		}
		
		return $returnData;
	}
	
	/**
	 * 保存したデータをクリアする
	 * @param unknown $key
	 */
	public static function del($key) {
		$cache = new \Memcached(\Config::get("memcached.MEMCACHED_CONNECTION_POOL"));
		if (count($cache->getServerList()) === 0) {
			$cache->addServer(\Config::get("memcached.MEMCACEHD_SERVER_ADDRESS"), \Config::get("memcached.MEMCACEHD_SERVER_PORT"));
			$cache->setOption(\Memcached::OPT_COMPRESSION, true);
			$cache->setOption(\Memcached::OPT_SERVER_FAILURE_LIMIT, \Config::get("memcached.MEMCACHED_FAILURE_LIMIT"));
		}
		
		if ($key != "") {
			$cache->delete($key);
		}
	}

	/**
	 * KEYのデータがあれば更新、無ければ何もしない
	 * @param unknown $key
	 */
	public static function replace($key, $value, $ttl = 900) {
		$cache = new \Memcached(\Config::get("memcached.MEMCACHED_CONNECTION_POOL"));
		if (count($cache->getServerList()) === 0) {
			$cache->addServer(\Config::get("memcached.MEMCACEHD_SERVER_ADDRESS"), \Config::get("memcached.MEMCACEHD_SERVER_PORT"));
			$cache->setOption(\Memcached::OPT_COMPRESSION, true);
			$cache->setOption(\Memcached::OPT_SERVER_FAILURE_LIMIT, \Config::get("memcached.MEMCACHED_FAILURE_LIMIT"));
		}
	
		if ($key != "") {
			$cache->replace($key, $value, time() + $ttl);
		}
	}
	
}
