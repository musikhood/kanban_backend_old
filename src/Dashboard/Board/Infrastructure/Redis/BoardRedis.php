<?php

namespace App\Dashboard\Board\Infrastructure\Redis;

use App\Dashboard\Board\Application\Service\BoardRedisInterface;
use App\Dashboard\Board\Domain\Entity\Board;
use App\Dashboard\Board\Domain\Entity\BoardId;
use App\Dashboard\Board\Domain\Repository\BoardRepositoryInterface;
use App\Dashboard\Board\Infrastructure\Repository\BoardRepository;
use App\Dashboard\User\Domain\Entity\UserId;
use App\Shared\Infrastructure\Redis\RedisClientInterface;
use Psr\Cache\CacheException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\RedisTagAwareAdapter;

class BoardRedis implements BoardRedisInterface
{
    private RedisTagAwareAdapter $cache;

    const CACHE_PREFIX = 'board_';
    const CACHE_SECONDS_TTL = 60;
    const CACHE_TAG = 'boards';


    public function __construct(
        private readonly RedisClientInterface $redisClient,
    ) {
        // Init Redis adapter for cache
        $this->cache = new RedisTagAwareAdapter(
            $this->redisClient->client(),
            self::CACHE_PREFIX,
            self::CACHE_SECONDS_TTL
        );
    }

    /**
     * @throws InvalidArgumentException
     * @throws CacheException
     */
    public function get(string $sid, $callback): mixed
    {
        $dataFromCache = $this->cache->getItem($sid);

        if ($dataFromCache->isHit()) {
            return $dataFromCache->get(); // Cached data
        }

        $data = $callback();

        // Save cache for future requests
        $dataFromCache->set($data)->tag(self::CACHE_TAG);
        $this->cache->save($dataFromCache);

        return $data;
    }
}