<?php

namespace Lizus\PHPRedis;


/*
Singleton pattern class
need php-redis first
use to connect redis server
see `get_redis`
*/

class RedisConnect
{
  private static $_instance;
  protected $_redis;
  private function __construct($args=[]) {
    $default=[
      'host'=>'127.0.0.1',
      'port'=>'6379',
      'auth'=>'',
      'database'=>0,
    ];
    $args=array_merge($default,$args);
    $redis=new \Redis;
    $redis->connect($args['host'],$args['port']);
    if (!empty($args['auth'])) $redis->auth($args['auth']);
    $redis->select(intval($args['database']));
    
    $this->_redis=$redis;
  }
  private function __clone() {
    trigger_error('Clone is not allow!',E_USER_ERROR);
  }
  protected static function createKey($args){
    $key=\md5(\json_encode($args));
    if (empty($key)) $key='default';
    return $key;
  }
  public static function getInstance($args=[]){
    $key=self::createKey($args);
    if (!isset(self::$_instance[$key]) || !self::$_instance[$key] instanceof self) {
      self::$_instance[$key]=new self($args);
    }
    return self::$_instance[$key];
  }
  public function getRedis(){
    return $this->_redis;
  } 
}
