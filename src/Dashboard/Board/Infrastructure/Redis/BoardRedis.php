<?php

namespace App\Dashboard\Board\Infrastructure\Redis;

use App\Dashboard\Board\Domain\Redis\BoardRedisInterface;
use App\Shared\Infrastructure\Redis\AbstractRedis;

class BoardRedis extends AbstractRedis implements BoardRedisInterface
{
    protected function getCachePrefix(): string
    {
        return 'board_';
    }

    protected function getCacheSecondsTTL(): int
    {
        return 60;
    }

    protected function getCacheTag(): string
    {
        return 'boards';
    }
}