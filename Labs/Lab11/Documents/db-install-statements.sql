-- CPIT 405 Lab 11 | Atheer AlSulami | 2307149
-- Import with: mysql -u root -p < Documents/db-install-statements.sql

CREATE DATABASE IF NOT EXISTS cpit405_lab11
  CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE cpit405_lab11;

CREATE TABLE IF NOT EXISTS grades (
  id INT UNSIGNED NOT NULL AUTO_INCREMENT,
  name VARCHAR(100) NOT NULL,
  total DECIMAL(3,1) NOT NULL,
  PRIMARY KEY (id),
  CONSTRAINT chk_grade_total CHECK (total >= 0 AND total <= 5)
);

-- Sample records from the exact Lab 11 assessment table.
-- INSERT IGNORE prevents duplicate records when this script runs again.
INSERT INTO grades (id, name, total) VALUES
  (1, 'Mohammad', 4.0),
  (2, 'Fahad', 3.5)
ON DUPLICATE KEY UPDATE id = id;
