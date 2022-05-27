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
//    public static $dbRedis = [  // потом хочу кеширование сделать
//        'host' => 'localhost',
//        'port' => '6379',
//    ];
}
