<?php

class Picture extends Storage
{

    public $id;
    public $id_user;
    public $data;
    public $date;


    public function __construct()
    {
        parent::__construct();
    }

    public function init($id_user, $b64img)
    {
        $this->id = self::uuid();
        $this->id_user = $id_user;
        $this->data = $b64img;
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
            "INSERT INTO picture VALUES (?, ?, ?, ?)",
            array_slice(array_values((array)$this), 0, 4)
        )->errorCode();
    }

    function delete()
    {
        return $this->database->q(
        /** @lang MySQL */
            "DELETE FROM picture WHERE id = ?",
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
            "SELECT * FROM picture WHERE $field = ?", [$val]
        );
    }

    function exist($field, $value): bool
    {
        return $this->loadWhere($field, $value) != NULL;
    }

    static function pictures($currentPage, $amountPage)
    {
        $offset = $currentPage * $amountPage;
        $d = new Database();
        return $d->lst(
        /** @lang MySQL */
            "SELECT * FROM `picture` ORDER BY date DESC LIMIT $amountPage OFFSET $offset"
        );
    }

    static function countPictures()
    {
        $d = new Database();
        return (int)$d->ta(
        /** @lang MySQL */
            "SELECT count(*) AS counts FROM `picture`"
        )->counts;
    }

    function loadWhereIdAndUserId($id, $user_id)
    {
        return $this->database->tc(__CLASS__,
            /** @lang MySQL */
            "SELECT * FROM picture WHERE id = ? AND id_user = ?", [$id, $user_id]
        );
    }

    static function picturesWhere($user_id, $currentPage, $amountPage)
    {
        $offset = $currentPage * $amountPage;
        $d = new Database();
        return $d->lst(
        /** @lang MySQL */
            "SELECT * FROM `picture` WHERE id_user=? ORDER BY date DESC LIMIT $amountPage OFFSET $offset",
            [$user_id]
        );
    }

    static function countPicturesWhere($user_id)
    {
        $d = new Database();
        return (int)$d->ta(
        /** @lang MySQL */
            "SELECT count(*) AS counts FROM `picture` WHERE id_user=?",
            [$user_id]
        )->counts;
    }
}