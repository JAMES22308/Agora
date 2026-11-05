-- ==========================================
-- RESET AGORA DATABASE
-- ==========================================

DROP DATABASE IF EXISTS agora;

CREATE DATABASE agora;

USE agora;


-- ==========================================
-- 1. BUSINESSES
-- ==========================================

CREATE TABLE businesses (
    business_id INT AUTO_INCREMENT PRIMARY KEY,
    business_name VARCHAR(100) NOT NULL,
    logo VARCHAR(255) NULL
);


-- ==========================================
-- 2. USERS
-- ==========================================

CREATE TABLE users (
    user_id INT AUTO_INCREMENT PRIMARY KEY,
    business_id INT NULL,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(150) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    role ENUM(
        'agora_admin',
        'business_admin',
        'seller',
        'buyer'
    ) NOT NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,

    FOREIGN KEY (business_id)
        REFERENCES businesses(business_id)
);


-- ==========================================
-- 3. PRODUCTS
-- ==========================================

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(10, 2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,

    FOREIGN KEY (seller_id)
        REFERENCES users(user_id)
);


-- ==========================================
-- 4. ORDERS
-- ==========================================

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    order_date DATETIME DEFAULT CURRENT_TIMESTAMP,

    FOREIGN KEY (buyer_id)
        REFERENCES users(user_id)
);


-- ==========================================
-- 5. ORDER ITEMS
-- ==========================================

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,

    FOREIGN KEY (order_id)
        REFERENCES orders(order_id),

    FOREIGN KEY (product_id)
        REFERENCES products(product_id)
);


USE agora;

INSERT INTO businesses (business_name)
VALUES
('NZ Mega Supplies'),
('Fox Butcher');



INSERT INTO users
(full_name, email, password, role, business_id, is_active)
VALUES

(
    'Sam Colo',
    'sam@nzmega.co.nz',
    '$2y$12$eBzlcx/iXBcg862rPHfaZuBhUq277g7F6RPCpGLSRhA6J59KhE7Vu',
    'business_admin',
    1,
    1
),

(
    'James Kennedy',
    'james@nzmega.co.nz',
    '$2y$12$nrLuGqvwhgCKTeqE4xIpSuVWCI.Adc5SGwm9tOTODXNyRYqZAHfgK',
    'seller',
    1,
    1
),

(
    'Alex Fox',
    'alex@foxbutcher.co.nz',
    '$2y$12$ROdKbPxJED6PU.L.w14zQOvmE4dq9jd9vw3XZDAPhZRtCpxFVNsOES',
    'business_admin',
    2,
    1
),

(
    'Lisa Schmitt',
    'lisa@foxbutcher.co.nz',
    '$2y$12$vsnDwPpgKGQ/xCY.vTupXOUCn8oKcaXsTB8YQ.rnBvY0G4KxLQR/S',
    'buyer',
    2,
    1
),

(
    'Simon Lau',
    'simon@agora.co.nz',
    '$2y$12$ROdKbPxJED6PU.L.w14zQOvmE4dq9jd9vw3XZDAPhZRtCpxFVNsOES',
    'agora_admin',
    NULL,
    1
);


INSERT INTO products
(seller_id, product_name, description, price, quantity)
VALUES
(2, 'Chicken Breast', 'Fresh chicken breast', 12.50, 50),
(2, 'Beef Steak', 'Premium beef steak', 18.00, 30),
(2, 'Fresh Salmon', 'Fresh salmon fillet', 15.00, 20);