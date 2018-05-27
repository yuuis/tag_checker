<?php

return [
	// Memcachedのエンドポイント
	'MEMCACEHD_SERVER_ADDRESS' => '127.0.0.1',
	// Memcachedのポート
	'MEMCACEHD_SERVER_PORT' => 11211,
	// Memcachedタイムアウト
	'MEMCACHED_FAILURE_LIMIT' => 3,
	// Memcachedコネクション
	'MEMCACHED_CONNECTION_POOL' => 'pool',
	//秒数,
	'MEMCACHED_DEFAULT_EXPIRE' => 900,
];
