<?php

namespace App\Controllers\Web;

use App\Controllers\BaseController;
use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Model;
use App\Core\Http\Routing\Request;

class ProductController extends BaseController
{
    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function search(Request $request): ?string
    {
        $products = [];

        $queryString = $request->getQueryParams();
        $queryString = $queryString['q'] ?? '';

        $sql = 'SELECT * FROM products';
        $sql .= ' WHERE (name LIKE "%' . $queryString . '%" OR description LIKE "%' . $queryString . '%")';

        $query = $this->db->query($sql);

        while ($result = $query->fetchObject(Model::class)){
            $products[] = $result->getAttributes();
        }

        $this->data['products'] = $products;
        $this->data['query'] = $queryString;

        return template()->render('search_products.tpl.php', $this->data);
    }
    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    public function show(Request $request, $id): ?string
    {
        $sql = 'SELECT p.* FROM products p WHERE p.id = ' . $id;

        $query = $this->db->query($sql);

        if ($result = $query->fetchObject(Model::class)){
            $this->data['product'] = $result->getAttributes();
            return template()->render('product.tpl.php', $this->data);
        }

        throw new NotFoundException('Product not found');
    }
}