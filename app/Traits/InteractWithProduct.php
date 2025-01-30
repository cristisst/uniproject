<?php

namespace App\Traits;

use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Model;

trait InteractWithProduct
{
    use HasSorting;
    /**
     * Fetches a product record from the database using the provided product ID.
     *
     * @param int $productId The unique identifier of the product to fetch.
     * @return Model|null Returns a Model object representing the product if found, or null if no product is found.
     */
    protected function fetchProduct(int $productId): ?Model
    {
        $sql = 'SELECT * FROM products WHERE id = ' . $productId;
        $query = $this->db->query($sql);
        return $query->fetchObject(Model::class);
    }

    /**
     * @throws ContainerException|NotFoundException
     */
    protected function fetchProductByCategory(int $categoryId, $queryString): array
    {
        $products = [];
        $sql = 'SELECT p.* FROM products p WHERE p.category_id = ' . $categoryId;
        $sql .= $this->sort($queryString);
        $query = $this->db->query($sql);
        while ($row = $query->fetchObject(Model::class)) {
            $row->image = rtrim(app()->get('app_url'), '/') . '/' . $row->image;
            $products[] = $row->getAttributes();;
        }
        return $products;
    }
}