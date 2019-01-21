<?php

class UserForgotPassword implements FormValidation
{
    public $email;

    /**
     * UserForgotPassword constructor.
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
        $user = $user->loadWhere("email", $this->email);
        if ($user == NULL) {
            Messages::emailShouldExist();
            return false;
        }
        return true;
    }
}