CREATE TABLE IF NOT EXISTS baskets (
                         id TEXT PRIMARY KEY,
                         user_id INTEGER NOT_NULL,
                         created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
                         updated_at DATETIME DEFAULT CURRENT_TIMESTAMP
);