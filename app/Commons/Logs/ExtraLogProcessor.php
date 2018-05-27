<?php

/*
 * This file is part of the Monolog package.
 *
 * (c) Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace App\Commons\Logs;

/**
 * オリジナルのログを追加する場合に追加
 * @author Administrator
 *
 */
class ExtraLogProcessor
{
    /**
     * @param  array $record
     * @return array
     */
    public function __invoke(array $record)
    {
    	$args = '';
    	$proxyAddr = '';
    	if (isset($_SERVER['HTTP_X_FORWARDED_FOR'])) {
    		$proxyAddr = $_SERVER['HTTP_X_FORWARDED_FOR'];
    	}
    	$remoteAddr = '';
    	if (isset($_SERVER['REMOTE_ADDR'])) {
    		$remoteAddr = $_SERVER['REMOTE_ADDR'];
    	}
    	$args = '[' . $remoteAddr . '][' . $proxyAddr . '] ' . $args;
    	
        $record['extra']['ip_address'] = $args;
        $record['extra']['loginId'] = '';
        
        return $record;
    }
}