<?php

class UserRegister implements FormValidation
{

    public $email;
    public $username;
    public $password;
    public $passwordConfirm;

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

    public function email(User $user): bool
    {
        return Validations::validateUserEmail($user, $this->email, false);
    }

    public function username(User $user): bool
    {
        return Validations::validateUserUsername($user, $this->username, false);
    }

    public function password() {
        return Validations::validateUserPassword($this->password, $this->passwordConfirm);
    }

    function validate(): bool
    {
        $emptyUser = new User();
        if (!$this->email($emptyUser)) return false;
        if (!$this->username($emptyUser)) return false;
        if (!$this->password()) return false;

        return true;
    }
}