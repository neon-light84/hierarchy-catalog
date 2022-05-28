<?php

namespace App\Services;

use App\Connections;
use App\Helpers\RelationToHierarchy;
use App\Config\MainConfig;

class CrudCatalog
{
    public static function getAll()  // Основной метод
    {
        // Получает из базы данных.
        $callBack = function () {
            $dbConnection = Connections::getInstance()->getMysql();
            $sth = $dbConnection->prepare('SELECT * FROM `catalog` ;');
            $sth->execute();
            if ($fieldsArr = $sth->fetchAll(\PDO::FETCH_ASSOC)) {
                return \json_encode(RelationToHierarchy::run($fieldsArr));
            } else {
                return '{}';
            }
        };

        $cache = new Cache();
        return $cache->tryGet(MainConfig::$cache['catalog_key'], $callBack, MainConfig::$cache['catalog_time']);
    }

    public static function create($data)
    {
        (new cache())->remove(MainConfig::$cache['catalog_key']);
        if (!$data['parent'] || (int)$data['parent'] < 0) $data['parent'] = null;
        $dbConnection = Connections::getInstance()->getMysql();
        $sth = $dbConnection->prepare('INSERT INTO `catalog` (`parent`, `name`, `description`) 
            VALUES (:parent, :name, :description );'
        );
        $sth->bindValue(':parent', $data['parent']);
        $sth->bindValue(':name', $data['name']);
        $sth->bindValue(':description', $data['description']);
        return $sth->execute();
    }

    public static function update($data)
    {
        (new cache())->remove(MainConfig::$cache['catalog_key']);
        if ((int)$data['parent'] == (int)$data['id']) return false;
        $dbConnection = Connections::getInstance()->getMysql();
        $sth = $dbConnection->prepare('UPDATE `catalog` 
            SET `parent` = :parent, `name` = :name, `description` = :description
            WHERE `id` = :id');
        $sth->bindValue(':parent', $data['parent'] >= 0 ? $data['parent'] : null);
        $sth->bindValue(':name', $data['name']);
        $sth->bindValue(':description', $data['description']);
        $sth->bindValue(':id', $data['id']);
        return $sth->execute();
    }

    public static function delete($data)
    {
        (new cache())->remove(MainConfig::$cache['catalog_key']);
        $dbConnection = Connections::getInstance()->getMysql();
        $sth = $dbConnection->prepare('DELETE FROM `catalog` WHERE `id` = :id;');
        $sth->bindValue(':id', $data['id']);
        return $sth->execute();
    }


}
