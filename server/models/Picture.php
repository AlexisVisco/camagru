<?php

class Picture extends Storage
{

    private $id;
    private $id_user;
    private $data;
    private $date;


    public function __construct()
    {
        parent::__construct();
    }

    public function init($id_user, $b64img) {
        $this->id = self::uuid();
        $this->id_user = $id_user;
        $this->data = $b64img;
    }

    function update()
    {
        return;
    }

    function save()
    {
        return $this->database->q(
        /** @lang MySQL */
            "INSERT INTO user VALUES (?, ?, ?)",
            array_slice(array_values((array)$this), 0, 3)
        )->errorCode();
    }

    function delete()
    {
        return $this->database->q(
        /** @lang MySQL */
            "DELETE FROM user WHERE id = ?",
            [$this->id]
        )->errorCode();
    }

    public function load($id_user)
    {
        return $this->loadWhere("id_user", $id_user);
    }

    function loadWhere($field, $val)
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