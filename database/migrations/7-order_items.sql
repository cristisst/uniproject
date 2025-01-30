CREATE TABLE IF NOT EXISTS order_items (
                             id INTEGER PRIMARY KEY AUTOINCREMENT,
                             order_id INTEGER NOT NULL,  -- References the `orders` table
                             product_id INTEGER NOT NULL, -- References the `products` table
                             quantity INTEGER NOT NULL,
                             price REAL NOT NULL,  -- Price per unit at the time of purchase
                             created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                             updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                             FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
                             FOREIGN KEY (product_id) REFERENCES products(id)
);
