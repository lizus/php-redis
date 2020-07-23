# php-redis
php redis class

## first thing to do

define your host and port, if empty it will use 127.0.0.1 and 6379 as port.

```php
if (!defined('PHPREDIS_HOST')) define('PHPREDIS_HOST', '127.0.0.1');
if (!defined('PHPREDIS_PORT')) define('PHPREDIS_PORT', '6379');
```

if your redis need auth:

```php
if (!defined('PHPREDIS_AUTH')) define('PHPREDIS_AUTH', 'your auth');
```

chose database:

```php
if (!defined('PHPREDIS_DATABASE')) define('PHPREDIS_DATABASE', 'your database');
```

## use sample

```php
use \Lizus\PHPRedis\PHPRedis;

class SampleRedis extends PHPRedis {}


$redis=new SampleRedis('sampleName');

$redis->set('sample data');

var_dump($redis->get());
```

if just wanna get redis instance:

```php
use function \Lizus\PHPRedis\get_redis;
$redis=get_redis();
var_dump($redis->keys('*'));
```
