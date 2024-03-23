<?php

namespace App\Shared\Infrastructure\Redis;

use Redis;
use RedisException;
use Symfony\Component\Cache\Adapter\RedisAdapter;

class RedisClient implements RedisClientInterface
{

    private Redis $redis;

    public function __construct(string $host, int $port)
    {
        $this->redis = RedisAdapter::createConnection("$host:$port");
    }

    public function client(): Redis
    {
        return $this->redis;
    }
}