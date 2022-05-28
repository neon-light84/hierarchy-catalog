<?php

namespace App\Services;


use App\Helpers\Admins;

class Auth
{
    public static function logout() {
        unset($_SESSION['user_id']);
    }

    public static function login($login, $password) {
        $userFields = Admins::fieldsByLogin($login);
        if (!$userFields) {
            return false;
        }
        if ($userFields['password'] === Admins::getHash($password)) {
            // логин/пароль верные
            $_SESSION['user_id'] = $userFields['id'];
            return true;
        }
        else {
            return false;
        }
    }

    public static function isAdminAuth() {
        return isset($_SESSION['user_id']) && $_SESSION['user_id'] > 0;
    }

}
