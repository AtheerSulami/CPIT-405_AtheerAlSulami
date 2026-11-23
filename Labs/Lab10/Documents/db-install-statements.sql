-- Student: Atheer AlSulami | ID: 2307149 | CPIT 405 Lab 10
-- Import using: mysql -u root -p < Documents/db-install-statements.sql
CREATE DATABASE IF NOT EXISTS cpit405_lab10
    CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cpit405_lab10;

CREATE TABLE IF NOT EXISTS tasks (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(100) NOT NULL,
    status ENUM('pending', 'in_progress', 'done') NOT NULL DEFAULT 'pending',
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO tasks (title, status) VALUES
('Complete PHP power function', 'done'),
('Translate Person / Professor UML', 'done'),
('Connect to MariaDB with PDO', 'in_progress'),
('Test the AJAX task list', 'pending');
