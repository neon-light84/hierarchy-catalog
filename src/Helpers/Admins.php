<?php

namespace App\Helpers;

use App\Connections;

class Admins
{
    /**
     * По логину возвращает поля из БД в сыром виде. В отличии от этого метода,
     * класс пользователя, не содержит пароля.
     * @param $login
     * @return array|false
     */
    public static function fieldsByLogin($login) {
        $dbConnection = Connections::getInstance()->getMySql();
        $sth = $dbConnection->prepare(
            'SELECT * FROM `admins` WHERE  `login`=:login LIMIT 1;');
        $sth->bindParam(':login', $login);
        $sth->execute();
        if ($fieldsArr = $sth->fetch(\PDO::FETCH_ASSOC)) {
            return $fieldsArr;
        } else {
            return false;
        }
    }

    public static function getHash ($password) {
        return hash('sha256', $password);
    }

}
