<?php

use App\Connections;
use App\Helpers\Admins;

require_once 'index.php';

$login = $argv[1];
$password = $argv[2];
$hashPassword = \App\Helpers\Admins::getHash($password);

$dbConnection = Connections::getInstance()->getMysql();
$sth = $dbConnection->prepare(
    'INSERT INTO `admins` (`login`, `password`) 
            VALUES (:login, :password);'
);
$sth->bindValue(':login', $login);
$sth->bindValue(':password', $hashPassword);
$sth->execute();
