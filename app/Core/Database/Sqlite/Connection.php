<?php

namespace App\Core\Database\Sqlite;

use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use PDO;
use PDOStatement;

class Connection
{
    private static ?Connection $instance = null;
    public PDO $conn;

    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function __construct()
    {
        $this->openconnection();
    }

    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function openconnection(): static
    {
        $databasePath = app()->get('sqlite_path');
        $this->conn = new PDO("sqlite:$databasePath");
        return $this;
    }

    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public static function getInstance($basePath = null): Connection
    {
        if (self::$instance === null) {
            self::$instance = new self($basePath);
        }

        return self::$instance;
    }

    /**
     * @param $sql
     * @return void
     */
    public function exec($sql)
    {
        $this->conn->exec($sql);
    }

    /**
     * @param $sql
     * @return PDOStatement
     */
    public function query($sql): PDOStatement
    {
        return $this->conn->query($sql);
    }

    /**
     * Retrieves the ID of the last inserted row or sequence value.
     *
     * @return string The ID of the last inserted row, or an empty string if no insert operation has been performed.
     */
    public function lastInsertId()
    {
        return $this->conn->lastInsertId();
    }

    /**
     * @param $sql
     * @return PDOStatement
     */
    public function prepare($sql)
    {
        return $this->conn->prepare($sql);
    }
}