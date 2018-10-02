<?php


abstract class Storage
{

    protected $database;

    /**
     * Storage constructor.
     */
    public function __construct()
    {
        $this->database = new Database();
    }

    abstract function update();

    abstract function save();

    abstract function delete();

    abstract public function load($id);

    abstract function loadWhere($field, $value);

    abstract function exist($field, $value) : bool;

    static function uuid() {
        return sprintf( '%04x%04x-%04x-%04x-%04x-%04x%04x%04x',
            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ),

            mt_rand( 0, 0xffff ),

            mt_rand( 0, 0x0fff ) | 0x4000,

            mt_rand( 0, 0x3fff ) | 0x8000,

            mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff ), mt_rand( 0, 0xffff )
        );
    }
}