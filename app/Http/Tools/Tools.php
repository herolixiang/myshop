<?php
namespace App\Http\Tools;

class Tools{
	public function getRedis(){
		$redis =new \Redis();
    	$redis->connect('127.0.0.1','6379');
    	return $redis;
	}
}
?>