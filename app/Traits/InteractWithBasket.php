<?php

namespace App\Traits;

use App\Core\Container\ContainerException;
use App\Core\Container\NotFoundException;
use App\Core\Database\Model;
use App\Core\Database\Sqlite\Connection;
use Exception;

trait InteractWithBasket
{
    /**
     * Retrieves the basket associated with the current user. If no basket exists, a new one is created.
     *
     * @return Model Returns a Model object representing the user's basket.
     * @throws Exception If a new basket cannot be created.
     */
    protected function basket(): Model
    {
        $sql = 'SELECT * FROM baskets WHERE `user_id` = ' . $this->user->id;
        $query = $this->db->query($sql);
        $result = $query->fetchObject(Model::class);
        if ($result) {
            return $result;
        }

        $basket = new Model();
        $basket->id = uuid();
        $basket->user_id = $this->user->id;

        $sql = 'INSERT INTO baskets (id, user_id) values (\'' . $basket->id . '\', ' . $basket->user_id . ')';
        if ($this->db->query($sql)) {
            return $basket;
        }

        throw new Exception('Could not create basket');
    }

    protected function addProductToBasket($basketId, $productId, $quantity = 1): bool
    {
        $sql = "INSERT INTO basket_items (basket_id, product_id, quantity) VALUES ('" . $basketId . "', '" . $productId . "', '" . $quantity . "') ON CONFLICT(basket_id, product_id) DO UPDATE SET quantity = quantity + excluded.quantity";
        $result = $this->db->query($sql);
        return (bool)$result;
    }

    /**
     * @throws ContainerException
     * @throws NotFoundException
     */
    protected function getBasketProducts(): array
    {
        $sql = "SELECT 
                    b.id AS basket_id,
                    b.user_id,
                    bi.id AS basket_item_id,
                    bi.quantity,
                    p.id AS product_id,
                    p.name AS product_name,
                    p.description AS product_description,
                    p.price AS product_price,
                    p.image AS product_image,
                    (bi.quantity * p.price) AS total_price
                FROM 
                    baskets b
                JOIN 
                    basket_items bi 
                ON 
                    b.id = bi.basket_id
                JOIN 
                    products p 
                ON 
                    bi.product_id = p.id
                WHERE 
                    b.user_id = " . $this->user->id . "
                ";
        $query = $this->db->query($sql);
        while ($row = $query->fetchObject(Model::class)) {
            $row->product_image = rtrim(app()->get('app_url'), '/') . '/' . $row->product_image;
            $products[] = $row->getAttributes();
        }
        return $products ?? [];
    }

    protected function removeProductFromBasket($basketId, $productId): bool
    {
        $sql = "DELETE FROM basket_items WHERE basket_id = '" . $basketId . "' AND product_id = '" . $productId . "'";
        $result = $this->db->query($sql);
        return (bool)$result;
    }

    protected function updateProductInBasket($basketId, $productId, $quantity): bool
    {
        $sql = "UPDATE basket_items SET quantity = '". $quantity ."' WHERE basket_id = '" . $basketId . "' AND product_id = '" . $productId . "'";
        $result = $this->db->query($sql);
        return (bool)$result;
    }

    protected function clearBasket($basketId): bool
    {
        $sql = "DELETE FROM basket_items WHERE basket_id = '" . $basketId . "'";
        $result = $this->db->query($sql);
        return (bool)$result;
    }
}