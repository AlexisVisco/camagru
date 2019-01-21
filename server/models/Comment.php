<?php

class Comment extends Storage {

    public $id;
    public $id_picture;
    public $id_user;
    public $body;
    public $date;

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
            "INSERT INTO comment VALUES (?, ?, ?, ?, ?)",
            array_slice(array_values((array)$this), 0, 5)
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

    static function countComments($pictureId)
    {
        $d = new Database();
        return (int)$d->ta(
        /** @lang MySQL */
            "SELECT count(*) AS counts FROM comment WHERE id_picture = ?",
            [$pictureId]
        )->counts;
    }

    static function comments($pictureId)
    {
        $d = new Database();
        return $d->lst(
        /** @lang MySQL */
            "SELECT * FROM comment WHERE id_picture = ? ORDER BY date DESC",
            [$pictureId]
        );
    }
}