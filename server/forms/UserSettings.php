<?php

class UserSettings implements FormValidation
{

    public $email;
    public $username;
    public $password;
    public $passwordNew;
    public $passwordNewConfirm;
    public $notify;

    public $user;
    public $changed = [];

    public static $CHANGED_USERNAME = "username";
    public static $CHANGED_EMAIL = "email";
    public static $CHANGED_NOTIFY = "notify";
    public static $CHANGED_PASSWORD = "password";

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
        if ($this->notify == "on") {
            if ($this->user->notified != 1) array_push($this->changed, "notify");
            $this->notify = 1;
        }
        if ($this->notify == "") {
            if ($this->user->notified != 0) array_push($this->changed, "notify");
            $this->notify = 0;
        }
    }

    public function email(): bool
    {
        if ($this->user->email == $this->email) return true;
        array_push($this->changed, "email");
        return Validations::validateUserEmail(new User(), $this->email, false);
    }

    public function username(): bool
    {
        if ($this->user->username == $this->username) return true;
        array_push($this->changed, "username");
        return Validations::validateUserUsername(new User(), $this->username, false);
    }

    public function password()
    {
        if ($this->password != "" && $this->passwordNew != "") {
            if (password_verify(SALT . $this->password, $this->user->password)) {
                array_push($this->changed, "password");
                if (!Validations::isGoodPassword($this->passwordNew)) {
                    return false;
                }
                return Validations::validateUserPassword($this->passwordNew, $this->passwordNewConfirm);
            } else {
                Messages::settingsPwdOldBad();
                return false;
            }
        } else if ($this->password != "" && $this->passwordNew == "") {
            Messages::settingsPwdMissingNew();
            return false;
        } else if ($this->password == "" && $this->passwordNew != "") {
            Messages::settingsPwdMissingOld();
            return false;
        } else {
            return true;
        }
    }

    public function changePassword(): bool
    {
        return $this->password != "" && $this->password != "";
    }

    public function getChanged(): array
    {
        return $this->changed;
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