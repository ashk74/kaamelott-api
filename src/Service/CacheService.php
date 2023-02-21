<?php

namespace App\Service;

use Symfony\Contracts\Cache\CacheInterface;
use Symfony\Contracts\Cache\ItemInterface;

class CacheService
{
    /**
     * CacheService constructor
     *
     * @param \Symfony\Contracts\Cache\CacheInterface $cache
     */
    public function __construct(private CacheInterface $cache)
    {
    }

    /**
     * Get data from the cache
     *
     * @param string $key Unique key to store data
     * @param array $callback Callback to get data if not in cache
     *
     * @return array $response
     */
    public function get(string $key, array $callback): array
    {
        return $this->cache->get($key, function (ItemInterface $item) use ($callback) {
            $item->expiresAfter(60 * 60 * 24 * 7);
            return $callback;
        });
    }
}
