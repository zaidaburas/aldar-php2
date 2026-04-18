CREATE DATABASE IF NOT EXISTS aldar_restaurant CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE aldar_restaurant;

CREATE TABLE IF NOT EXISTS admins (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(100) NOT NULL UNIQUE,
    password_hash VARCHAR(255) NOT NULL,
    full_name VARCHAR(150) NULL,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    last_login_at DATETIME NULL,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS categories (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    slug VARCHAR(180) NOT NULL UNIQUE,
    icon VARCHAR(50) NULL,
    description TEXT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_categories_active_sort (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    category_id INT UNSIGNED NOT NULL,
    name VARCHAR(180) NOT NULL,
    slug VARCHAR(200) NOT NULL UNIQUE,
    short_description VARCHAR(255) NULL,
    description TEXT NULL,
    price DECIMAL(10,2) NOT NULL DEFAULT 0.00,
    image_path VARCHAR(255) NULL,
    icon VARCHAR(50) NULL,
    is_popular TINYINT(1) NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    sort_order INT NOT NULL DEFAULT 0,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    CONSTRAINT fk_items_category FOREIGN KEY (category_id) REFERENCES categories(id) ON DELETE RESTRICT ON UPDATE CASCADE,
    INDEX idx_items_category (category_id),
    INDEX idx_items_popular_active (is_popular, is_active),
    INDEX idx_items_sort (sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS slider_ads (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    subtitle VARCHAR(255) NULL,
    image_path VARCHAR(255) NOT NULL,
    button_text VARCHAR(80) NULL,
    link_url VARCHAR(255) NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_slider_active_sort (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS gallery (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(180) NOT NULL,
    image_path VARCHAR(255) NOT NULL,
    sort_order INT NOT NULL DEFAULT 0,
    is_active TINYINT(1) NOT NULL DEFAULT 1,
    created_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    INDEX idx_gallery_active_sort (is_active, sort_order)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

CREATE TABLE IF NOT EXISTS settings (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    setting_key VARCHAR(120) NOT NULL UNIQUE,
    setting_value LONGTEXT NULL,
    setting_type VARCHAR(50) NOT NULL DEFAULT 'text',
    setting_group VARCHAR(50) NOT NULL DEFAULT 'general',
    updated_at TIMESTAMP NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

INSERT INTO admins (username, password_hash, full_name, is_active)
VALUES ('admin', '$2y$10$RaLjd2E4N9vQ5dGVAs6M1eqCsze8LRAFqhK6ZmKwiPEJxwcejpuVe', 'مدير النظام', 1)
ON DUPLICATE KEY UPDATE username = VALUES(username);

INSERT INTO settings (setting_key, setting_value, setting_type, setting_group) VALUES
('site_title', 'مطاعم الدار دارك', 'text', 'general'),
('site_description', 'المنيو الكامل وطلب الوجبات', 'text', 'general'),
('order_now_url', '#order', 'url', 'links'),
('whatsapp_url', '#', 'url', 'links'),
('contact_url', '#contact', 'url', 'links'),
('about_text', 'اكتب نبذة المطعم هنا', 'textarea', 'about'),
('featured_item_id', NULL, 'number', 'featured'),
('topbar_text', 'مطاعم الدار دارك — أشهى المأكولات اليمنية والعربية', 'text', 'hero'),
('hero_title', 'ألذ الوجبات اليمنية والعربية', 'text', 'hero'),
('hero_description', 'وصف مختصر يظهر في واجهة الموقع.', 'textarea', 'hero')
ON DUPLICATE KEY UPDATE setting_key = VALUES(setting_key);
