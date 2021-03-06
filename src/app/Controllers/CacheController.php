<?php

namespace App\Controllers;

use App\Services\RedisCacheService as Redis;
use App\Services\CacheService;
use Phalcon\DI;
use Phalcon\Mvc\Controller;

/**
 * @SuppressWarnings(PHPMD.StaticAccess)
 */
class CacheController extends Controller
{
    private Redis $cache;

    public function clearAll(string $tag = null)
    {
        $di = DI::getDefault();
        $this->cache = new Redis($di->getShared('redisClient'));

        return !empty($tag) ?
            $this->executeClearTag() :
            $this->executeClearAll();
    }

    private function executeClearAll(): array
    {
        $this->cache->clear();
        return [
            'status_code' => 201,
            'message' => 'Flush cache successfully',
        ];
    }

    private function executeClearTag(): array
    {
        $keyQuery = $this->request->getQuery();
        $keyQuery['_url'] = (explode('/', $keyQuery['_url']))[2];
        $tagQuery =  $this->cache->getTag($keyQuery);
        $deletedItems = $this->cache->clearTag($tagQuery);
        return [
            'status_code' => 201,
            'message' => 'Deleted tags: ' . $deletedItems,
        ];
    }
}
