<?php

namespace App\Services;


use App\Helpers\Admins;

class Auth
{
    const PERMITTED_CHARS = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ'; // для генерации токена

    public static function logout() {
        unset($_SESSION['user_id']);
    }

    public static function login($login, $password) {
        $userFields = Admins::fieldsByLogin($login);
        if (!$userFields) {
            return false;
        }
        if ($userFields['password'] == Admins::getHash($password)) {
            // логин/пароль верные
            $_SESSION['user_id'] = $userFields['id'];
            $_SESSION['token'] = static::generateString();
            return true;
        }
        else {
            return false;
        }
    }

    public static function isAdminAuth() {
        return $_SESSION['user_id'] && $_SESSION['user_id'] > 0;
    }

    private static function generateString($strength = 32) {
        $input_length = strlen(static::PERMITTED_CHARS);
        $random_string = '';
        for($i = 0; $i < $strength; $i++) {
            $random_character = static::PERMITTED_CHARS[mt_rand(0, $input_length - 1)];
            $random_string .= $random_character;
        }

        return $random_string;
    }



}
