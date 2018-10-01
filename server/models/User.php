<?php


class User extends Storage
{

    public $id;

    public $username;
    public $email;
    public $password;
    public $confirmed = 0;
    public $notified = 1;
    public $token;


    public function __construct()
    {
        parent::__construct();
    }

    public function init($username, $email, $password)
    {
        $this->username = $username;
        $this->email = $email;
        $this->password = $password;
        $this->id = self::uuid();
        $this->token = self::uuid();
    }

    public function newToken() {
        $this->token = self::uuid();
    }

    public function login()
    {
        $_SESSION["user"] = json_encode($this);
    }

    public static function logout()
    {
        $_SESSION["user"] = NULL;
    }

    public static function getUser()
    {
        $u = new User();
        if (!isset($_SESSION["user"]) || $_SESSION["user"] == NULL) return NULL;
        $uDecoded = json_decode($_SESSION["user"]);
        foreach ($uDecoded as $key => $value) $u->{$key} = $value;
        return $u;
    }

    public function save()
    {
        return $this->database->q(
        /** @lang MySQL */
            "INSERT INTO user VALUES (?, ?, ?, ?, ?, ?, ?)",
            array_slice(array_values((array)$this), 0, 7)
        )->errorCode();
    }

    public function update()
    {
        return $this->database->q(
            /** @lang MySQL */
            "UPDATE user
            SET id=?, username=?, email=?, password=?, confirmed=?, notified=?, token=?
            WHERE id='$this->id'",
            array_slice(array_values((array)$this), 0, 7)
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