<?php

class Database extends PDO
{
    private $DB_DSN = "mysql:dbname=camagru;host=db";
    private $DB_USER = "root";
    private $DB_PASSWORD = "test";
    private $DB_DEBUG = true;

    /**
     * Database constructor.
     */
    public function __construct()
    {
        parent::__construct($this->DB_DSN, $this->DB_USER, $this->DB_PASSWORD);
        if ($this->DB_DEBUG) self::setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }

    public function q($query, $arguments = []): PDOStatement
    {
        $statement = self::prepare($query);
        $statement->execute($arguments);
        return $statement;
    }

    public function tc($class, $query, $arguments = [])
    {
        $statement = self::prepare($query);
        $statement->execute($arguments);
        $res = $statement->fetchObject($class);
        if (gettype($res) == "boolean") {
            return NULL;
        }
        return $res;
    }

    public function lst($query, $arguments = []) {
        $statement = self::prepare($query);
        $statement->execute($arguments);
        $res = $statement->fetchAll(PDO::FETCH_OBJ);
        if (gettype($res) == "boolean") {
            return NULL;
        }
        return $res;
    }
}