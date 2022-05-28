<?php

namespace App\Services;

use App\Connections;
use App\Config\MainConfig;

class Cache
{
    /**
     * @var \Redis
     */
    private $redisConnection;

    public function __construct()
    {
        $this->redisConnection = MainConfig::$cache['is_caching'] ? Connections::getInstance()->getRedis() : null;
    }

    /**
     * Установка значения кеша
     * @param string $key
     * @param string $value
     * @param int $ttl время жизни значения в сек
     */
    public function set($key, $value, $ttl)
    {
        if (!MainConfig::$cache['is_caching']) return false; // Что бы легко отключать кеширование в конфиге
        return $this->redisConnection->set($key, $value, $ttl);
    }

    public function get($key)
    {
        if (!MainConfig::$cache['is_caching']) return false; // Что бы легко отключать кеширование в конфиге
        return $this->redisConnection->get($key);
    }

    public function remove($key)
    {
        if (!MainConfig::$cache['is_caching']) return false; // Что бы легко отключать кеширование в конфиге
        return $this->redisConnection->expire($key, 0);
    }

    public function tryGet($key, $callback, $ttlNew)
    {
        $res = $this->get($key);
        if (!$res) {
            $res = $callback();
            $this->set($key, $res, $ttlNew);
        }
        return $res;
    }

}
