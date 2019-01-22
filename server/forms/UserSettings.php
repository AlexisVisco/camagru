<?php

class UserSettings implements FormValidation
{

    public $email;
    public $username;
    public $password;
    public $passwordNew;
    public $notify;

    public $user;

    /**
     * UserRegister constructor.
     * @param $array
     */
    public function __construct($array)
    {
        $this->user = json_decode($_SESSION["user"]);
        $this->notify = 0;
        foreach ($array as $key => $item) {
            $this->{$key} = $item;
        }
        if ($this->notify == "checked") {
            $this->notify = 1;
        }
    }

    public function email(): bool
    {
        if ($this->user->email == $this->email) return true;
        return Validations::validateUserEmail(new User(), $this->email, false);
    }

    public function username(): bool
    {
        if ($this->user->username == $this->username) return true;
        return Validations::validateUserUsername(new User(), $this->username, false);
    }

    public function password()
    {
        if ($this->password != "" && $this->password != "") {
            if ($this->passwordNew == $this->password) {
                $m = new FlashMessage("Mot de passe invalide.", FlashType::$ERROR);
                $m->register();
                return false;
            }
            if (password_verify(SALT . $this->password, $this->user->password)) {
                if (Validations::isGoodPassword($this->passwordNew)) {
                    return true;
                }
            } else {
                $m = new FlashMessage("Mot de passe invalide.", FlashType::$ERROR);
                $m->register();
            }
        }
        if ($this->password == "" && $this->password == "")  {
            return true;
        } else {
            $m = new FlashMessage("Mot de passe invalide.", FlashType::$ERROR);
            $m->register();
        }
        return false;
    }


    public function changePassword(): bool
    {
        return $this->password != "" && $this->password != "";
    }

    function validate(): bool
    {
        if (!$this->email()) {
            return false;
        }
        if (!$this->username()) {
            return false;
        }
        if (!$this->password()) {
            return false;
        }

        return true;
    }
}