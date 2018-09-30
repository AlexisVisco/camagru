<?php


class User extends Storage
{

    public $id;

    public $username;
    public $email;
    public $password;
    public $confirmed = false;
    public $notified = true;
    public $token;


    public function __construct()
    {
        parent::__construct();
        $this->id = self::uuid();
        $this->token = self::uuid();
    }

    public function init($username, $email, $password) {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
    }

    public function save()
    {
        var_dump(array_slice(array_values((array) $this), 0, 7));
        return $this->database->q(
            /** @lang MySQL */
            "INSERT INTO user VALUES (?, ?, ?, ?, ?, ?, ?)",
            array_slice(array_values((array) $this), 0, 7)
        )->errorCode();
    }

    public function load($id)
    {
        return $this->loadWhere("id", $id);
    }

    public function loadWhere($field, $val)
    {
        return $this->database->tc(__CLASS__,
            /** @lang MySQL */
            "SELECT * FROM user WHERE $field = ?", [$val]
        );
    }

    function exist($field, $value): bool
    {
        return $this->loadWhere($field, $value) != NULL;
    }


}