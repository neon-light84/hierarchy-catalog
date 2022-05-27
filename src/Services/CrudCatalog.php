<?php

namespace App\Services;

use App\Connections;
use App\Helpers\RelationToHierarchy;

class CrudCatalog
{
    public static function getAll() {
        $dbConnection = Connections::getInstance()->getMysql();
        $sth = $dbConnection->prepare('SELECT * FROM `catalog` ;');
        $sth->execute();
        //TODO: подключить редис и закешировать
        if ($fieldsArr = $sth->fetchAll(\PDO::FETCH_ASSOC)) {
            return \json_encode(RelationToHierarchy::run($fieldsArr));
        } else {
            return '';
        }
    }

    public static function  insert ($data) {
        $dbConnection = Connections::getInstance()->getMysql();
        $sth = $dbConnection->prepare('INSERT INTO `catalog` (`parent`, `name`, `description`) 
            VALUES (:parent, :name, :description );'
        );
        $sth->bindValue(':parent', $data['parent']);
        $sth->bindValue(':name', $data['name']);
        $sth->bindValue(':description', $data['description']);
        $sth->execute();
    }

    public static function  update ($data) {
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

    public static function  delete ($data) {
        $dbConnection = Connections::getInstance()->getMysql();
        $sth = $dbConnection->prepare('DELETE FROM `catalog` WHERE `id` = :id;');
        $sth->bindValue(':id', $data['id']);
        $res = $sth->execute();
        return $res;
    }



}
