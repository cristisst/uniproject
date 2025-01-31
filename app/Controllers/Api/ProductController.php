<?php

namespace App\Controllers\Api;

use App\Controllers\BaseController;
use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Model;
use App\Core\Database\Sqlite\Connection;
use App\Core\Http\Routing\Request;
use App\Traits\HasSorting;

/**
 * This class handles operations related to products, including retrieving featured products,
 * listing all products with optional sorting, and searching for products based on various criteria.
 */
class ProductController
{
    use HasSorting;

    /**
     * @var array
     */
    protected array $data = [];

    /**
     * @var Connection
     */
    protected Connection $db;

    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function __construct()
    {
        $this->db = Connection::getInstance();
    }
    /**
     * @return array
     * @throws ContainerException|NotFoundException
     */
    public function featured(): array
    {
        $sql = "SELECT p.* FROM products p";
        $sql .= " JOIN featured_products fp ON p.id = fp.product_id";
        $sql .= " WHERE fp.featured_end IS NULL OR fp.featured_end > CURRENT_TIMESTAMP";
        $query = $this->db->query($sql);
        while ($result = $query->fetchObject(Model::class)){
            $result->image = rtrim(app()->get('app_url'), '/') . '/' . $result->image;
            $this->data[] = $result->getAttributes();
        }


        return $this->data;
    }

    /**
     * @throws ContainerException|NotFoundException
     */
    public function index(Request $request): array
    {

        $queryString = $request->getQueryParams();

        $sql = 'SELECT p.* FROM products p';
        $sql .= $this->sort($queryString);

        $query = $this->db->query($sql);

        while ($result = $query->fetchObject(Model::class)){
            $result->image = rtrim(app()->get('app_url'), '/') . '/' . $result->image;
            $this->data[] = $result->getAttributes();
        }

        return $this->data;
    }

    /**
     * @param Request $request
     * @return array
     */
    public function search(Request $request)
    {
        $queryString = $request->getQueryParams();

        if (empty($queryString)) {
            return [];
        }

        $sql = 'SELECT * FROM products ';
        $sql .= ' WHERE (name LIKE "%' . $queryString['query'] . '%"  OR description LIKE "%' . $queryString['query'] . '%")';
        if (array_key_exists('min_price', $queryString)) {
            $sql .= ' AND price >= ' . $queryString['min_price'];
        }

        if (array_key_exists('max_price', $queryString)) {
            $sql .= ' AND price <= ' . $queryString['max_price'];
        }

        if (array_key_exists('category', $queryString)) {
            $sql .= ' AND category_id = ' . $queryString['category'];
        }

        $sql .= $this->sort($queryString);

        $query = $this->db->query($sql);

        while ($result = $query->fetchObject(Model::class)){
            $products[] = $result->getAttributes();
        }

        $this->data['products'] = $products ?? [];

        return $this->data;
    }
}