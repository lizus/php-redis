<?php
namespace Lizus\PHPRedis;

class PHPRedis
{
  protected $redis;//redis instance
  protected $key;//the key name to store
  protected $expire=86400;//expire time count second, default is a day
  protected $host='';//redis服务器IP,默认127.0.0.1
  protected $port='';//端口,默认6379
  protected $auth='';//密码
  protected $database=0;//选择数据库，一般为0-10

  /**
   * initialize
   * it will always create a key-value redis data, and always has expire time
   * this class use redis as a temp data store
   * so don't use it for data storage
   * @param string  $name [special name in the key]
   * @param integer $exp  [expire time]
   */
  function __construct($name,$exp=0)
  {
    $args=[];
    if(!empty($this->host)) {
      $args['host']=$this->host;
    }else {
      if(\defined('PHPREDIS_HOST')) $args['host']=PHPREDIS_HOST;
    }
    if(!empty($this->port)) {
      $args['port']=$this->port;
    }else {
      if(\defined('PHPREDIS_PORT')) $args['port']=PHPREDIS_PORT;
    }
    if(!empty($this->auth)) {
      $args['auth']=$this->auth;
    }else {
      if(\defined('PHPREDIS_AUTH')) $args['auth']=PHPREDIS_AUTH;
    }
    $args['database']=intval($this->database);

    $redis=RedisConnect::getInstance($args);
    $this->redis=$redis->getRedis();

    $this->key=$this->create_key($name);
    if($exp>0) $this->expire=$exp;
  }
  
  /**
   * select
   * 选择redis数据库
   * @param  int $num
   * @return $this
   */
  public function select($num){
    if($num>0) $this->database=intval($num);
    return $this;
  }
  /**
   * set data to redis
   * @param any $data [the data want to storage]
   */
  public function set($data){
    $this->redis->select($this->database);
    $this->redis->setEx($this->key,$this->expire,json_encode($data));
    return $this;
  }
  /**
   * get data from redis, always as an array or string
   * @return array/string [the data]
   */
  public function get(){
    $this->redis->select($this->database);
    $data=$this->redis->get($this->key);
    if (!empty($data)) {
      $data=json_decode($data,true);
    }else {
      $data=array();
    }
    return $data;
  }
  /**
   * delete redis key
   * @return null
   */
  public function del(){
    $this->redis->select($this->database);
    if (method_exists($this->redis,'del')) {
      $this->redis->del($this->key);
    }else {
      $this->redis->delete($this->key);
    }
    return $this;
  }

  /**
   * create key name
   * use name to create the key
   * @param  string $str [name]
   * @return string      [the key]
   */
  protected function create_key($str){
    $str=preg_replace('/\\\/','-',$_SERVER['SERVER_NAME'].':'.get_class($this).':'.$str);
    return preg_replace('/[\s&\\\]/',':',$str);
  }
}
