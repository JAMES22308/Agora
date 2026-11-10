
-- =====================================================
-- AGORA E-COMMERCE SYSTEM
-- COMPLETE DATABASE SETUP
-- =====================================================

-- 1. RESET DATABASE
DROP DATABASE IF EXISTS agora;

CREATE DATABASE agora
CHARACTER SET utf8mb4
COLLATE utf8mb4_unicode_ci;

USE agora;


-- =====================================================
-- 2. BUSINESSES TABLE
-- =====================================================

CREATE TABLE businesses (
    business_id INT AUTO_INCREMENT PRIMARY KEY,
    business_name VARCHAR(100) NOT NULL,
    logo VARCHAR(255) NULL
) ENGINE=InnoDB;


-- =====================================================
-- 3. USERS TABLE
-- =====================================================

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

    CONSTRAINT fk_users_business
        FOREIGN KEY (business_id)
        REFERENCES businesses(business_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =====================================================
-- 4. PRODUCTS TABLE
-- =====================================================

CREATE TABLE products (
    product_id INT AUTO_INCREMENT PRIMARY KEY,
    seller_id INT NOT NULL,
    product_name VARCHAR(150) NOT NULL,
    description TEXT NULL,
    price DECIMAL(10,2) NOT NULL,
    quantity INT NOT NULL DEFAULT 0,

    CONSTRAINT chk_product_price
        CHECK (price >= 0),

    CONSTRAINT chk_product_quantity
        CHECK (quantity >= 0),

    CONSTRAINT fk_products_seller
        FOREIGN KEY (seller_id)
        REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =====================================================
-- 5. ORDERS TABLE
-- =====================================================

CREATE TABLE orders (
    order_id INT AUTO_INCREMENT PRIMARY KEY,
    buyer_id INT NOT NULL,
    order_date DATETIME NOT NULL DEFAULT CURRENT_TIMESTAMP,

    CONSTRAINT fk_orders_buyer
        FOREIGN KEY (buyer_id)
        REFERENCES users(user_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =====================================================
-- 6. ORDER ITEMS TABLE
-- =====================================================

CREATE TABLE order_items (
    order_item_id INT AUTO_INCREMENT PRIMARY KEY,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    unit_price DECIMAL(10,2) NOT NULL DEFAULT 0.00,

    CONSTRAINT chk_order_item_quantity
        CHECK (quantity > 0),

    CONSTRAINT chk_order_item_price
        CHECK (unit_price >= 0),

    CONSTRAINT fk_order_items_order
        FOREIGN KEY (order_id)
        REFERENCES orders(order_id)
        ON UPDATE CASCADE
        ON DELETE CASCADE,

    CONSTRAINT fk_order_items_product
        FOREIGN KEY (product_id)
        REFERENCES products(product_id)
        ON UPDATE CASCADE
        ON DELETE RESTRICT
) ENGINE=InnoDB;


-- =====================================================
-- 7. INSERT BUSINESSES
-- =====================================================

INSERT INTO businesses (business_name, logo)
VALUES
('NZ Mega Supplies', NULL),
('Fox Butcher', NULL);


-- =====================================================
-- 8. INSERT TEST USERS
-- TEMPORARY PLAIN-TEXT PASSWORD:
-- AgoraTest123!
-- =====================================================

-- NZ Mega Supplies
INSERT INTO users
    (business_id, full_name, email, password, role, is_active)
VALUES
(1, 'Sam Colo', 'sam@nzmega.test',
 '$2y$12$T1daVxzxBI2K0piNaHG5OOzGFd1dvhuxA3YPhx17XYlPz/wcSYRvC', 'business_admin', 1),

(1, 'James Kennedy', 'james@nzmega.test',
 '$2y$12$T1daVxzxBI2K0piNaHG5OOzGFd1dvhuxA3YPhx17XYlPz/wcSYRvC', 'seller', 1),

(1, 'Emma Wilson', 'emma@nzmega.test',
 '$2y$12$T1daVxzxBI2K0piNaHG5OOzGFd1dvhuxA3YPhx17XYlPz/wcSYRvC', 'buyer', 1);


-- Fox Butcher
INSERT INTO users
    (business_id, full_name, email, password, role, is_active)
VALUES
(2, 'Alex Fox', 'alex@foxbutcher.test',
 '$2y$12$T1daVxzxBI2K0piNaHG5OOzGFd1dvhuxA3YPhx17XYlPz/wcSYRvC', 'business_admin', 1),

(2, 'David Brown', 'david@foxbutcher.test',
 '$2y$12$T1daVxzxBI2K0piNaHG5OOzGFd1dvhuxA3YPhx17XYlPz/wcSYRvC', 'seller', 1),

(2, 'Lisa Schmitt', 'lisa@foxbutcher.test',
 '$2y$12$T1daVxzxBI2K0piNaHG5OOzGFd1dvhuxA3YPhx17XYlPz/wcSYRvC', 'buyer', 1);


-- Agora Platform Administrator
INSERT INTO users
    (business_id, full_name, email, password, role, is_active)
VALUES
(NULL, 'Simon Lau', 'simon@agora.test',
 'AgoraTest123!', 'agora_admin', 1);


-- =====================================================
-- 9. INSERT SAMPLE PRODUCTS
-- =====================================================

INSERT INTO products
    (seller_id, product_name, description, price, quantity)
VALUES

-- James Kennedy: NZ Mega Supplies
(2, 'Chicken Breast',
 'Fresh chicken breast suitable for everyday meals.',
 12.50, 30),

(2, 'Beef Steak',
 'Quality beef steak supplied by NZ Mega Supplies.',
 25.00, 20),

(2, 'Fresh Salmon',
 'Fresh salmon fillets.',
 18.90, 15),

-- David Brown: Fox Butcher
(5, 'Premium Beef Mince',
 'Fresh premium beef mince from Fox Butcher.',
 16.50, 25),

(5, 'Pork Sausages',
 'Fresh pork sausages.',
 11.90, 40),

(5, 'Lamb Chops',
 'Fresh lamb chops supplied by Fox Butcher.',
 22.00, 18);


select * from users;
select * from products;
select * from orders;
select * from order_items;
select * from businesses;