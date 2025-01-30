CREATE TABLE IF NOT EXISTS basket_items (
                                            id INTEGER PRIMARY KEY AUTOINCREMENT,
                                            basket_id TEXT NOT NULL,  -- References the `baskets` table
                                            product_id INTEGER NOT NULL, -- References the `products` table
                                            quantity INTEGER DEFAULT 1 NOT NULL,
                                            created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                            updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                            FOREIGN KEY (basket_id) REFERENCES baskets(id) ON DELETE CASCADE,
                                            FOREIGN KEY (product_id) REFERENCES products(id),
                                            CONSTRAINT unique_basket_product UNIQUE (basket_id, product_id) -- UNIQUE constraint
);
