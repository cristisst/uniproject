-- Create the products table
CREATE TABLE IF NOT EXISTS products (
                                        id INTEGER PRIMARY KEY AUTOINCREMENT,
                                        name TEXT NOT NULL,
                                        description TEXT NOT NULL,
                                        image TEXT NOT NULL,
                                        price REAL NOT NULL,
                                        category_id INTEGER NOT NULL,
                                        created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                        updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                        deleted_at DATETIME NULL,
                                        FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE CASCADE
    );