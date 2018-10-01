<?php

class Validations
{
    public static function validateUserEmail(User $user, string $email, bool $shouldExist) : bool {

        if (!self::isGoodEmail($email)) return false;

        if (!self::isExisteableEmail($user, $email, $shouldExist)) return false;

        return true;
    }

    public static function validateUserUsername(User $user, string $username, bool $shouldExist) {
        if (!self::isGoodUsername($username)) return false;

        if (!self::isExisteableEmail($user, $username, $shouldExist)) return false;

        return true;
    }

    public static function validateUserPassword($pwd, $pwdConfirm) : bool {

        if ($pwd != $pwdConfirm) {
            Errors::passwordShouldMatch();
            return false;
        }

        if (!self::isGoodPassword($pwd)) return false;

        return true;
    }

    public static function isGoodPassword($password) : bool {
        $maj = /** @lang RegExp */ "[A-Z]";
        $number = /** @lang RegExp */ "[0-9]";
        $good = true;

        if (count_chars($password) < 6) $good = false;
        if (!preg_match("/$maj/", $password))  $good = false;
        if (!preg_match("/$number/", $password))  $good = false;

        if (!$good) {
            Errors::passwordShouldHaveComplexity();
            return false;
        }
        return true;
    }

    public static function isGoodEmail(string $email) : bool
    {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            Errors::emailShouldBeValid();
            return false;
        }
        return true;
    }

    public static function isExisteableEmail(User $user, string $email, bool $shouldExist): bool
    {
        if ($user->exist("email", $email) != $shouldExist) {
            if ($shouldExist) Errors::emailShouldExist();
            else Errors::emailShouldBeUnique();
            return false;
        }
        return true;
    }

    public static function isExisteableUsername(User $user, string $username, bool $shouldExist): bool
    {
        if ($user->exist("username", $username) != $shouldExist) {
            if ($shouldExist) Errors::usernameShouldExist();
            else Errors::usernameShouldBeUnique();
            return false;
        }
        return true;
    }

    private static function isGoodUsername(string $username)
    {
        $re = /** @lang RegExp */ "^[A-Za-z0-9]{3,32}$";
        if (!preg_match("/$re/", $username)) {
            Errors::usernameShouldBeValid();
            return false;
        }
        return true;
    }
}