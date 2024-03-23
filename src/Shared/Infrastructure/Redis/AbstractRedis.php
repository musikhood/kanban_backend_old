<?php

namespace App\Shared\Infrastructure\Redis;

use Psr\Cache\CacheException;
use Psr\Cache\InvalidArgumentException;
use Symfony\Component\Cache\Adapter\RedisTagAwareAdapter;

abstract class AbstractRedis
{
    private RedisTagAwareAdapter $cache;

    abstract protected function getCachePrefix(): string;
    abstract protected function getCacheSecondsTTL(): int;
    abstract protected function getCacheTag(): string;

    public function __construct(private readonly RedisClientInterface $redisClient)
    {
        // Initialize Redis adapter for cache
        $this->cache = new RedisTagAwareAdapter(
            $this->redisClient->client(),
            $this->getCachePrefix(),
            $this->getCacheSecondsTTL()
        );
    }

    /**
     * @throws InvalidArgumentException
     * @throws CacheException
     */
    public function getDataFromCache(string $sid, $callback): mixed
    {
        $dataFromCache = $this->cache->getItem($sid);

        if ($dataFromCache->isHit()) {
            return $dataFromCache->get(); // Cached data
        }

        $data = $callback();

        // Save cache for future requests
        $dataFromCache->set($data)->tag($this->getCacheTag());
        $this->cache->save($dataFromCache);

        return $data;
    }

    /**
     * @throws InvalidArgumentException
     */
    public function clearCache(): void
    {
        $this->cache->invalidateTags([
            $this->getCacheTag()
        ]);
    }
}