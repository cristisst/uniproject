<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Model;
use App\Core\Database\Sqlite\Connection;
use App\Core\Http\Routing\Request;
use App\Traits\HasSorting;

class CategoryController
{
    use HasSorting;

    protected array $data = [];

    protected Connection $db;

    /**
     * @throws ContainerException|NotFoundException
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
    }

    /**
     * @return array
     */
    public function index(): array
    {

        $sql = 'SELECT c.id AS id, c.name AS name, COUNT(p.id) AS itemsCount ';
        $sql .= ' FROM categories c';
        $sql .= ' LEFT JOIN products p ';
        $sql .= ' ON c.id = p.category_id';
        $sql .= ' GROUP BY c.id, c.name';
        $sql .= ' ORDER BY c.name';
        $query = $this->db->query($sql);
        while ($result = $query->fetchObject(Model::class)){
            $this->data[] = $result->getAttributes();
        }
        return $this->data;
    }

    /**
     * @throws NotFoundException
     * @throws ContainerException
     */
    public function products(Request $request, $id): array
    {
        $queryString = $request->getQueryParams();

        $sql = 'SELECT p.* FROM products p';
        $sql .= ' WHERE p.category_id = ' . $id;
        $sql .= $this->sort($queryString);
        $query = $this->db->query($sql);
        while ($result = $query->fetchObject(Model::class)){
            $result->image = rtrim(app()->get('app_url'), '/') . '/' . $result->image;
            $this->data[] = $result->getAttributes();
        }
        return $this->data;
    }
}