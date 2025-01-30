CREATE TABLE IF NOT EXISTS featured_products (
                                   id INTEGER PRIMARY KEY AUTOINCREMENT,
                                   product_id INTEGER NOT NULL,
                                   featured_start DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,
                                   featured_end DATETIME DEFAULT NULL,
                                   FOREIGN KEY (product_id) REFERENCES products(id)
);