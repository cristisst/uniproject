<?php

namespace App\Traits;

use App\Core\Database\Model;

trait InteractWithOrder
{
    /**
     *  status can be
     *  - placed
     *  - confirmed
     *  - processing
     *  - dispatched
     *
     * @param int $userId
     * @param float $basketTotalPrice
     * @param string $status
     * @return int
     */
    protected function insertOrder(int $userId, float $basketTotalPrice, string $status = 'placed'): int
    {
        $sql = "INSERT INTO orders (user_id, total_price, created_at, updated_at)
            VALUES (:user_id, :total_price, :created_at, :updated_at)";
        $stmt = $this->db->prepare($sql);
        $currentTimestamp = date('Y-m-d H:i:s');
        $stmt->bindValue(':user_id', $userId, SQLITE3_INTEGER);
        $stmt->bindValue(':total_price', $basketTotalPrice, SQLITE3_FLOAT);
        $stmt->bindValue(':created_at', $currentTimestamp, SQLITE3_TEXT);
        $stmt->bindValue(':updated_at', $currentTimestamp, SQLITE3_TEXT);
        $stmt->execute();

        // Return the inserted Order ID
        return $this->db->lastInsertId();

    }
    /**
     * @param array $products
     * @param string $orderId
     * @return void
     */
    public function insertOrderProducts(array $products, string $orderId): void
    {
        $sql = "INSERT INTO order_items (order_id, product_id, quantity, price, created_at, updated_at)
            VALUES (:order_id, :product_id, :quantity, :price, :created_at, :updated_at)";

        $stmt = $this->db->prepare($sql);

        $currentTimestamp = date('Y-m-d H:i:s');

        foreach ($products as $product) {
            // Bind values to the query parameters
            $stmt->bindValue(':order_id', $orderId, SQLITE3_INTEGER);
            $stmt->bindValue(':product_id', $product['product_id'], SQLITE3_INTEGER);
            $stmt->bindValue(':quantity', $product['quantity'], SQLITE3_INTEGER);
            $stmt->bindValue(':price', $product['product_price'], SQLITE3_FLOAT);
            $stmt->bindValue(':created_at', $currentTimestamp, SQLITE3_TEXT);
            $stmt->bindValue(':updated_at', $currentTimestamp, SQLITE3_TEXT);

            // Execute the query
            $stmt->execute();
        }
    }

    public function getOrderWithItems(int $orderId): array
    {
        // Write the JOIN query to fetch order and its items
        $sql = "
        SELECT 
            o.id AS order_id,
            o.user_id,
            o.total_price,
            o.status,
            oi.id AS order_item_id,
            oi.product_id,
            oi.quantity,
            oi.price
        FROM 
            orders o
        LEFT JOIN 
            order_items oi
        ON 
            o.id = oi.order_id
        WHERE 
            o.id = '".$orderId."'
        ";
        $query = $this->db->query($sql);
        while ($row = $query->fetchObject(Model::class)) {
            $order = [
                'order_id' => $row->order_id,
                'total_price' => $row->total_price,
                'status' => $row->status,
            ];
            $orderItems[] = $row->getAttributes();
        }
        $order['order_items'] = $orderItems ?? [];
        return $order ?? [];
    }
}