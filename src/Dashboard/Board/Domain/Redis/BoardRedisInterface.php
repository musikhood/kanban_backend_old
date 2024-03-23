<?php

namespace App\Dashboard\Board\Domain\Redis;

interface BoardRedisInterface
{
    public function getDataFromCache(string $sid, $callback): mixed;
    public function clearCache(): void;
}