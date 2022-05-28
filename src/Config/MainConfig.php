<?php
namespace App\Config;

class MainConfig
{
    public static $dbMysql = [
        'host' => 'localhost',
        'db_name' => 'kfi',
        'user' => 'test',
        'password' => 'test',
    ];
    public static $dbRedis = [
        'host' => 'localhost',
        'port' => '6379',
    ];
    public static $cache = [
        'is_caching' => true,
        'catalog_key' => 'catalog_hierarchy',
        'catalog_time' => 600, //в секундах
    ];
}
