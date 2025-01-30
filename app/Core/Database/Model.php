<?php

namespace App\Core\Database;

use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Sqlite\Connection;

class Model
{
    protected $table;
    protected $fillable = [];
    protected $attributes = [];
    protected Connection $db;

    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function __get($name)
    {
        return $this->attributes[$name] ?? null;
    }

    public function __set($name, $value)
    {
        $this->attributes[$name] = $value;
    }
}