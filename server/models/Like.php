<?php

class Like extends Storage
{

    private $id_picture;
    private $id_user;
    private $date;

    public function __construct()
    {
        parent::__construct();
    }

    public function init($id_picture, $id_user)
    {
        $this->id_user = $id_user;
        $this->id_picture = $id_picture;
        $this->date = date('Y-m-d H:i:s');
    }

    function update()
    {
        return;
    }

    function save()
    {
        return $this->database->q(
        /** @lang MySQL */
            "INSERT INTO `like` VALUES (?, ?, ?)",
            array_slice(array_values((array)$this), 0, 3)
        )->errorCode();
    }

    function delete()
    {
        return $this->database->q(
        /** @lang MySQL */
            "DELETE FROM `like` WHERE id_picture = ? AND id_user = ?",
            [$this->id_picture, $this->id_user]
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
            "SELECT * FROM `like` WHERE $field = ?", [$val]
        );
    }

    function exist($field, $value): bool
    {
        return $this->loadWhere($field, $value) != NULL;
    }

    function loadLike($userId, $pictureId)
    {
        return $this->database->tc(__CLASS__,
            /** @lang MySQL */
            "SELECT * FROM `like` WHERE id_picture = ? AND id_user = ?", [$pictureId, $userId]
        );
    }

    static function likes($pictureId)
    {
        $d = new Database();
        return (int)$d->ta(
        /** @lang MySQL */
            "SELECT count(*) AS counts FROM `like` WHERE id_picture = ?",
            [$pictureId]
        )->counts;
    }

    static function hasLike($userId, $pictureId) {
        $d = new Database();
        return ((int)$d->ta(
        /** @lang MySQL */
            "SELECT count(*) AS counts FROM `like` WHERE id_picture = ? AND id_user = ?",
            [$pictureId, $userId]
        )->counts) == 1;
    }
}