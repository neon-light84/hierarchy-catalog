<?php

namespace App\Helpers;

class DB
{
    public static function createDsn($host, $dbName, $driver = 'mysql') {
        return "$driver:host=$host;dbname=$dbName";
    }

}
