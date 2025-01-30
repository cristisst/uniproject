<?php

namespace App\Controllers;

use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Model;
use App\Core\Database\Sqlite\Connection;

class BaseController
{
    protected array $data = [];
    protected Connection $db;

    protected Model $user;

    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
        $this->data['categories'] = $this->fillCategories();
        $this->user = new Model();
        $this->user->id='1';
        $this->user->name='Test User';
    }

    protected function fillCategories(): array
    {
        $sql = 'SELECT * FROM categories';
        $query = $this->db->query($sql);
        while ($result = $query->fetchObject(Model::class)){
            $categories[] = $result->getAttributes();
        }
        return $categories;
    }
}