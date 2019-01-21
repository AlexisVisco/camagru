<?php

class UserLogin implements FormValidation
{

    public $email;
    public $password;

    /**
     * UserRegister constructor.
     * @param $array
     */
    public function __construct($array)
    {
        foreach ($array as $key => $item) {
            $this->{$key} = $item;
        }
    }

    function validate(): bool
    {
        $user = new User();
        if (!$user->exist("email", $this->email)) {
            Messages::loginFail();
            return false;
        }
        $user = $user->loadWhere("email", $this->email);
        if (!password_verify(SALT . $this->password, $user->password)
        || $user->confirmed == 0) {
            Messages::loginFail();
            return false;
        }
        return true;
    }
}