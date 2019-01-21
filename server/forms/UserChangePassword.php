<?php

class UserChangePassword implements FormValidation
{

    public $token;
    public $id;

    public $password;
    public $passwordConfirm;

    /**
     * UserChangePassword constructor.
     * @param $id
     * @param $token
     * @param $array
     */
    public function __construct($id, $token, $array)
    {
        $this->id = $id;
        $this->token = $token;
        foreach ($array as $key => $item) {
            $this->{$key} = $item;
        }
    }

    public function password() {
        return Validations::validateUserPassword($this->password, $this->passwordConfirm);
    }

    function validate(): bool
    {
        $tok = new Token();
        $emptyUser = new User();
        $emptyUser = $emptyUser->load($this->id);
        $tok = $tok->loadWhereWithType("token", $this->token, Token::$TYPE_FORGOT_PWD);
        if (($tok == NULL || $emptyUser == null) || $emptyUser->id != $tok->id) {
            Messages::badEntity();
            return false;
        }
        if (!$this->password()) return false;

        return true;
    }
}