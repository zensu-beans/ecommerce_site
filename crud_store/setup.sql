-- ══════════════════════════════════════════════
--  CRUD Tech Store — Database Setup
--  Run this once in phpMyAdmin or MySQL CLI
-- ══════════════════════════════════════════════

CREATE DATABASE IF NOT EXISTS crud_store
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE crud_store;

-- ── Admins table ──────────────────────────────
CREATE TABLE IF NOT EXISTS admins (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    username   VARCHAR(80)  NOT NULL UNIQUE,
    password   VARCHAR(255) NOT NULL,   -- bcrypt hash
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Default admin: username=admin  password=admin123
-- (change this password after first login!)
INSERT INTO admins (username, password)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE id = id;

-- ── Products table ────────────────────────────
CREATE TABLE IF NOT EXISTS products (
    id         INT AUTO_INCREMENT PRIMARY KEY,
    name       VARCHAR(200) NOT NULL,
    category   ENUM('Laptops','Smartphones','Gaming','Smartwatches') NOT NULL,
    price      DECIMAL(12,2) NOT NULL,
    old_price  DECIMAL(12,2) DEFAULT NULL,
    stock      INT NOT NULL DEFAULT 0,
    rating     DECIMAL(3,1) DEFAULT 0.0,
    reviews    INT DEFAULT 0,
    badge      ENUM('new','sale','hot','') DEFAULT '',
    img        VARCHAR(300) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- ── Seed products ─────────────────────────────
INSERT INTO products (name, category, price, old_price, stock, rating, reviews, badge, img) VALUES
('MacBook Air M3',          'Laptops',      74990, NULL,  42, 4.9, 128, 'new',  'assets/macbook.jpg'),
('iPhone 17 Pro Max',       'Smartphones',  74990, NULL,  15, 4.8, 214, 'new',  'assets/apple-iphone.jpg'),
('Samsung Galaxy S25 Ultra','Smartphones',  62990, 69990, 30, 4.7,  89, 'sale', 'assets/samsung.jpg'),
('PlayStation 5 Slim',      'Gaming',       29990, NULL,   8, 4.9, 301, 'hot',  'assets/ps5.jpg'),
('Apple Watch Ultra 2',     'Smartwatches', 49990, NULL,  24, 4.6,  56, '',     'assets/smartwatch.png'),
('Dell XPS 15',             'Laptops',      89990, 99990,  5, 4.5,  72, 'sale', 'assets/dell.jpg'),
('Garmin Venu 3',           'Smartwatches', 22990, NULL,   3, 4.4,  33, '',     'assets/garmin.jpg');
