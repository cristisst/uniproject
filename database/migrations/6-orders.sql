CREATE TABLE IF NOT EXISTS orders (
                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                        user_id INTEGER NOT NULL,  -- References the user (optional for guest orders)
                        total_price REAL NOT NULL,
                        status TEXT DEFAULT 'Pending', -- Status: Pending, Completed, Canceled
                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);
