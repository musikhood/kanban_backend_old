<?php

namespace App\Shared\Infrastructure\Redis;

use Redis;

interface RedisClientInterface
{
    public function client(): Redis;

}