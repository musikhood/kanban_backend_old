<?php

namespace App\Dashboard\Board\Application\Service;

interface BoardRedisInterface
{
    public function getDataFromCache(string $sid, $callback): mixed;
}