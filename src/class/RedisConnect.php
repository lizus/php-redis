<?php

namespace Lizus\PHPRedis;


/*
Singleton pattern class
need php-redis first
use to connect redis server
see `get_redis`
*/

if (!defined('PHPREDIS_HOST')) define('PHPREDIS_HOST', '127.0.0.1');
if (!defined('PHPREDIS_PORT')) define('PHPREDIS_PORT', '6379');

class RedisConnect
{
  private static $_instance;
  protected $_redis;
  private function __construct() {
      $redis=new \Redis;
      $redis->connect(PHPREDIS_HOST,PHPREDIS_PORT);
      if (defined('PHPREDIS_AUTH')) $redis->auth(PHPREDIS_AUTH);
      if (defined('PHPREDIS_DATABASE')) $redis->select(PHPREDIS_DATABASE);
      $this->_redis=$redis;
  }
  private function __clone() {
    trigger_error('Clone is not allow!',E_USER_ERROR);
  }
  public static function getInstance(){
    if (!self::$_instance instanceof self) {
      self::$_instance=new self;
    }
    return self::$_instance;
  }
  public function getRedis(){
    return $this->_redis;
  }
}
