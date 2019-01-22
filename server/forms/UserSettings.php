<?php

class UserSettings implements FormValidation
{

    public $email;
    public $username;
    public $password;
    public $passwordNew;
    public $notified;

    public $user;

    /**
     * UserRegister constructor.
     * @param $array
     */
    public function __construct($array)
    {
        $this->user = json_decode($_SESSION["user"]);
        foreach ($array as $key => $item) {
            $this->{$key} = $item;
        }
    }

    public function email($email): bool
    {
        if ($this->user->email == $email) return true;
        return Validations::validateUserEmail(new User(), $email, false);
    }

    public function username($username): bool
    {
        if ($this->user->username == $username) return true;
        return Validations::validateUserUsername(new User(), $this->username, false);
    }

    public function password() {
        if ($this->password != "" && $this->password != "" ) {
            if ($this->passwordNew == $this->password) {
                $m = new FlashMessage("Mot de passe invalide.",  FlashType::$ERROR);
                $m->register();
                return false;
            }
            if (password_verify(SALT . $this->password, $this->user->password)) {
                if (Validations::isGoodPassword($this->passwordNew)) {
                    return true;
                }
            } else {
                $m = new FlashMessage("Mot de passe invalide.",  FlashType::$ERROR);
                $m->register();
            }
        }
        return false;
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