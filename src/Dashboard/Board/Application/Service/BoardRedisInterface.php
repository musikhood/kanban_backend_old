<?php

namespace App\Dashboard\Board\Application\Service;

interface BoardRedisInterface
{
    public function get(string $sid, $callback): mixed;
}