-- Insert products into the featured_products table
INSERT INTO featured_products (product_id, featured_start, featured_end) VALUES
-- Active featured products (not expired)
(1, '2024-01-10 10:00:00', NULL), -- Smartphone Pro
(2, '2024-02-15 12:00:00', NULL), -- Wireless Earbuds
(5, '2024-03-20 08:30:00', NULL), -- Running Shoes
(9, '2024-04-01 09:00:00', '2025-12-31 23:59:59'), -- Novel (still active)
-- Expired featured products
(10, '2023-12-01 08:00:00', '2024-01-01 23:59:59'), -- Cookbook
(15, '2023-11-15 10:00:00', '2024-02-01 23:59:59'), -- Dollhouse
(20, '2023-10-10 14:00:00', '2024-03-01 23:59:59'), -- Winter Coat
(25, '2023-09-01 09:00:00', '2024-01-15 23:59:59'); -- Yoga Mat