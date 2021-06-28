# php-redis
php redis class

## First thing to do

Define your host and port, if empty it will use 127.0.0.1 and 6379 as port.

```php
if (!defined('PHPREDIS_HOST')) define('PHPREDIS_HOST', '127.0.0.1');
if (!defined('PHPREDIS_PORT')) define('PHPREDIS_PORT', '6379');
```

If your redis need auth:

```php
if (!defined('PHPREDIS_AUTH')) define('PHPREDIS_AUTH', 'your auth');
```

Chose database:

```php
if (!defined('PHPREDIS_DATABASE')) define('PHPREDIS_DATABASE', 'your database');
```

or you can use `protected $database=1` to select your database

or you can run the class method `select();` to select your database, this may change the proteced var $database

## use sample

```php
use \Lizus\PHPRedis\PHPRedis;

class SampleRedis extends PHPRedis 
{
    protected $database=1; //Not necessary 自定义数据库
    protected $host='127.0.0.1'; //Not necessary 自定义host
    protected $port='6379'; //Not necessary 自定义port
    protected $auth='***'; //Not necessary 自定义auth
}


$a=new SampleRedis('sampleName');

$a->set('sample data');

var_dump($a->get());
```
