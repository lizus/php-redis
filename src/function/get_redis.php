<?php
namespace Lizus\PHPRedis;

/**
 * get redis instance
 * @return redis instance
 */
function get_redis(){
  $redis=RedisConnect::getInstance();
  return $redis->getRedis();
}
