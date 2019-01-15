<?php

class Comment extends Storage {

    private $id;
    private $id_picture;
    private $id_user;
    private $body;
    private $date;

    public function __construct()
    {
        parent::__construct();
    }

    public function init($id_picture, $id_user, $body) {
        $this->id = self::uuid();
        $this->id_picture = $id_picture;
        $this->id_user = $id_user;
        $this->body = htmlspecialchars($body);
        $this->date = date('Y-m-d H:i:s');
    }

    function update()
    {
        return ;
    }

    function save()
    {
        return $this->database->q(
        /** @lang MySQL */
            "INSERT INTO comment VALUES (?, ?, ?, ?)",
            array_slice(array_values((array)$this), 0, 4)
        )->errorCode();
    }

    function delete()
    {
        return $this->database->q(
        /** @lang MySQL */
            "DELETE FROM comment WHERE id = ?",
            [$this->id]
        )->errorCode();
    }

    public function load($id)
    {
        return $this->loadWhere("id", $id);
    }

    function loadWhere($field, $val)
    {
        return $this->database->tc(__CLASS__,
            /** @lang MySQL */
            "SELECT * FROM comment WHERE $field = ?", [$val]
        );
    }

    function exist($field, $value): bool
    {
        return $this->loadWhere($field, $value) != NULL;
    }
}