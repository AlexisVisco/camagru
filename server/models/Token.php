<?php


class Token extends Storage
{

    public $token;
    public $id;
    public $type;

    public static $TYPE_CONFIRM = 0;
    public static $TYPE_FORGOT_PWD = 1;


    /**
     * Token constructor.
     */
    public function __construct()
    {
    }

    public function init($id, $type)
    {
        $this->token = self::uuid();
        $this->id = $id;
        $this->type = $type;
    }

    function update()
    {
        // TODO: Implement update() method.
    }

    function save()
    {
        return $this->database->q(
        /** @lang MySQL */
            "INSERT INTO token VALUES (?, ?, ?)",
            array_slice(array_values((array)$this), 0, 3)
        )->errorCode();
    }

    public function load($id)
    {
        return $this->loadWhere("id", $id);
    }

    function loadWhere($field, $value)
    {
        return $this->database->tc(
            __CLASS__,
            /** @lang MySQL */
            "SELECT * FROM token WHERE $field = ?",
            [$value]
        );
    }

    public function loadWhereWithType($field, $value, $type)
    {
        return $this->database->tc(
            __CLASS__,
            /** @lang MySQL */
            "SELECT * FROM token WHERE $field = ? AND `type` = ?",
            [$value, $type]
        );
    }

    function delete()
    {
        return $this->database->q(
        /** @lang MySQL */
            "DELETE FROM token WHERE token = ?",
            [$this->token]
        )->errorCode();
    }


    function exist($field, $value): bool
    {
        return $this->loadWhere($field, $value);
    }
}
