-- Create the categories table
CREATE TABLE IF NOT EXISTS categories (
                                          id INTEGER PRIMARY KEY,
                                          name TEXT NOT NULL,
                                          created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                          updated_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                                          deleted_at DATETIME NULL
);

