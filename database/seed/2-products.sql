-- Insert 20 products into the products table
INSERT INTO products (name, description, image, price, category_id) VALUES
-- Electronics
('Smartphone', 'A high-end smartphone with a great camera.', 'images/nope-not-here.avif', 699.99, 1),
('Laptop', 'Lightweight and powerful laptop for professionals.', 'images/nope-not-here.avif', 1299.99, 1),
('Headphones', 'Noise-canceling over-ear headphones.', 'images/nope-not-here.avif', 199.99, 1),

-- Fashion
('T-Shirt', 'Comfortable cotton T-shirt in various sizes.', 'images/nope-not-here.avif', 19.99, 2),
('Jeans', 'Slim-fit jeans available in different colors.', 'images/nope-not-here.avif', 49.99, 2),
('Sneakers', 'Stylish sneakers for everyday use.', 'images/nope-not-here.avif', 89.99, 2),

-- Books
('Novel', 'A gripping fiction novel.', 'images/nope-not-here.avif', 14.99, 3),
('Cookbook', 'Easy-to-follow recipes for home cooking.', 'images/nope-not-here.avif', 24.99, 3),
('Science Book', 'Explore the wonders of science.', 'images/nope-not-here.avif', 29.99, 3),

-- Toys
('Action Figure', 'Collectible action figure with accessories.', 'images/nope-not-here.avif', 14.99, 4),
('Lego Set', 'Build your imagination with this Lego set.', 'images/nope-not-here.avif', 59.99, 4),
('Dollhouse', 'A beautiful wooden dollhouse for kids.', 'images/nope-not-here.avif', 99.99, 4),

-- Clothes
('Jacket', 'Warm winter jacket with waterproof material.', 'images/nope-not-here.avif', 89.99, 5),
('Dress', 'Elegant evening dress for special occasions.', 'images/nope-not-here.avif', 119.99, 5),
('Scarf', 'Soft woolen scarf for chilly days.', 'images/nope-not-here.avif', 19.99, 5),

-- Sports
('Football', 'Official size football for outdoor play.', 'images/nope-not-here.avif', 24.99, 6),
('Yoga Mat', 'Non-slip yoga mat for comfortable workouts.', 'images/nope-not-here.avif', 34.99, 6),
('Tennis Racket', 'Lightweight racket for recreational players.', 'images/nope-not-here.avif', 79.99, 6),

-- Home
('Sofa', 'Modern and comfortable 3-seater sofa.', 'images/nope-not-here.avif', 399.99, 7),
('Lamp', 'Adjustable desk lamp with LED light.', 'images/nope-not-here.avif', 29.99, 7),
('Cookware Set', 'Durable stainless steel cookware set.', 'images/nope-not-here.avif', 99.99, 7);

INSERT INTO products (name, description, image, price, category_id, created_at, updated_at) VALUES
-- Electronics
('Smartphone Pro', 'Advanced smartphone with AI features.', 'images/nope-not-here.avif', 799.99, 1, '2024-01-10 12:30:00', '2024-01-15 14:00:00'),
('Wireless Earbuds', 'Compact wireless earbuds with noise cancellation.', 'images/nope-not-here.avif', 149.99, 1, '2024-02-20 09:45:00', '2024-02-22 11:00:00'),
('Smart TV', '50-inch 4K UHD Smart TV with streaming apps.', 'images/nope-not-here.avif', 499.99, 1, '2024-03-05 08:20:00', '2024-03-10 16:45:00'),
('Gaming Console', 'Next-gen gaming console with high-speed performance.', 'images/nope-not-here.avif', 399.99, 1, '2024-04-18 10:30:00', '2024-04-20 13:50:00'),
('Portable Speaker', 'Bluetooth speaker with 12-hour battery life.', 'images/nope-not-here.avif', 99.99, 1, '2024-05-25 14:15:00', '2024-05-30 17:30:00'),

-- Fashion
('Running Shoes', 'Lightweight running shoes with superior cushioning.', 'images/nope-not-here.avif', 120.00, 2, '2024-02-12 13:45:00', '2024-02-15 10:10:00'),
('Leather Jacket', 'Stylish leather jacket for all seasons.', 'images/nope-not-here.avif', 249.99, 2, '2024-03-10 12:00:00', '2024-03-12 18:25:00'),
('Wristwatch', 'Luxury wristwatch with sapphire crystal.', 'images/nope-not-here.avif', 349.99, 2, '2024-04-05 14:15:00', '2024-04-08 16:40:00'),
('Handbag', 'Premium leather handbag with multiple compartments.', 'images/nope-not-here.avif', 199.99, 2, '2024-06-14 09:30:00', '2024-06-18 14:20:00'),
('Sneakers', 'Trendy sneakers for casual wear.', 'images/nope-not-here.avif', 89.99, 2, '2024-07-22 11:00:00', '2024-07-25 13:50:00'),

-- Books
('Novel', 'A gripping fiction novel.', 'images/nope-not-here.avif', 14.99, 3, '2024-01-18 08:20:00', '2024-01-22 10:10:00'),
('Cookbook', 'Easy-to-follow recipes for home cooking.', 'images/nope-not-here.avif', 24.99, 3, '2024-03-01 12:15:00', '2024-03-04 14:50:00'),
('Science Book', 'Explore the wonders of science.', 'images/nope-not-here.avif', 29.99, 3, '2024-05-12 10:30:00', '2024-05-15 11:45:00'),
('History Book', 'Dive into the past with this comprehensive history book.', 'images/nope-not-here.avif', 34.99, 3, '2024-06-01 09:00:00', '2024-06-05 13:30:00'),
('Self-Help Book', 'Tips and techniques to improve your daily life.', 'images/nope-not-here.avif', 19.99, 3, '2024-08-10 15:30:00', '2024-08-12 17:10:00'),

-- Toys
('Lego Set', 'Build your imagination with this Lego set.', 'images/nope-not-here.avif', 59.99, 4, '2024-02-20 11:30:00', '2024-02-25 15:50:00'),
('Action Figure', 'Collectible action figure with accessories.', 'images/nope-not-here.avif', 14.99, 4, '2024-03-15 12:00:00', '2024-03-18 14:25:00'),
('Puzzle', '1000-piece puzzle for puzzle enthusiasts.', 'images/nope-not-here.avif', 19.99, 4, '2024-04-10 10:20:00', '2024-04-14 12:50:00'),
('Board Game', 'A fun family board game.', 'images/nope-not-here.avif', 39.99, 4, '2024-06-22 14:00:00', '2024-06-24 16:35:00'),
('Dollhouse', 'Beautiful wooden dollhouse for kids.', 'images/nope-not-here.avif', 99.99, 4, '2024-07-14 13:45:00', '2024-07-17 18:20:00'),

-- Clothes
('Winter Coat', 'Warm and cozy winter coat.', 'images/nope-not-here.avif', 129.99, 5, '2024-01-10 09:15:00', '2024-01-12 11:45:00'),
('Summer Dress', 'Stylish summer dress for women.', 'images/nope-not-here.avif', 59.99, 5, '2024-03-01 14:20:00', '2024-03-04 15:30:00'),
('Jeans', 'Classic blue jeans for men.', 'images/nope-not-here.avif', 49.99, 5, '2024-04-15 10:10:00', '2024-04-18 12:50:00'),
('T-Shirt', 'Comfortable cotton T-shirt.', 'images/nope-not-here.avif', 19.99, 5, '2024-06-10 11:30:00', '2024-06-13 14:15:00'),
('Sweater', 'Soft woolen sweater for winter.', 'images/nope-not-here.avif', 39.99, 5, '2024-08-05 12:00:00', '2024-08-08 14:25:00'),

-- Sports
('Football', 'Official size football.', 'images/nope-not-here.avif', 24.99, 6, '2024-02-12 08:20:00', '2024-02-15 09:30:00'),
('Yoga Mat', 'Non-slip yoga mat.', 'images/nope-not-here.avif', 34.99, 6, '2024-03-05 10:15:00', '2024-03-07 11:45:00'),
('Tennis Racket', 'Lightweight tennis racket.', 'images/nope-not-here.avif', 79.99, 6, '2024-04-18 12:30:00', '2024-04-20 14:50:00'),
('Basketball', 'Durable basketball for outdoor play.', 'images/nope-not-here.avif', 29.99, 6, '2024-05-10 09:15:00', '2024-05-12 10:45:00'),
('Cycling Helmet', 'Safety helmet for cyclists.', 'images/nope-not-here.avif', 49.99, 6, '2024-06-25 14:10:00', '2024-06-28 15:35:00'),

-- Home
('Sofa', 'Modern and comfortable sofa.', 'images/nope-not-here.avif', 399.99, 7, '2024-01-20 10:45:00', '2024-01-22 14:00:00'),
('Dining Table', 'Elegant wooden dining table.', 'images/nope-not-here.avif', 499.99, 7, '2024-03-10 11:30:00', '2024-03-12 13:20:00'),
('Bed Frame', 'Sturdy bed frame for all mattress sizes.', 'images/nope-not-here.avif', 299.99, 7, '2024-04-15 12:20:00', '2024-04-17 14:45:00'),
('Curtains', 'Blackout curtains for bedrooms.', 'images/nope-not-here.avif', 79.99, 7, '2024-06-20 09:30:00', '2024-06-22 12:15:00'),
('Coffee Maker', 'Programmable coffee maker with timer.', 'images/nope-not-here.avif', 59.99, 7, '2024-08-01 10:20:00', '2024-08-03 11:40:00');
