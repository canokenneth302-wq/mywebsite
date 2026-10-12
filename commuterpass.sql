CREATE DATABASE IF NOT EXISTS commuterpass
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE commuterpass;

CREATE TABLE IF NOT EXISTS student_accounts (
    id VARCHAR(20) PRIMARY KEY,
    name VARCHAR(150) NOT NULL,
    email VARCHAR(190) NOT NULL UNIQUE,
    school VARCHAR(190) NOT NULL,
    password VARCHAR(255) NOT NULL,
    eligible TINYINT(1) NOT NULL DEFAULT 1,
    expires_at DATE NOT NULL,
    failed_scan_day DATE NULL,
    failed_scan_attempts TINYINT UNSIGNED NOT NULL DEFAULT 0,
    created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP
);

CREATE TABLE IF NOT EXISTS transactions (
    id VARCHAR(40) PRIMARY KEY,
    student_id VARCHAR(20) NOT NULL DEFAULT '',
    student_name VARCHAR(150) NOT NULL,
    passenger_type VARCHAR(30) NOT NULL,
    destination VARCHAR(255) NOT NULL,
    regular_fare DECIMAL(10,2) NOT NULL,
    discount DECIMAL(10,2) NOT NULL,
    paid_fare DECIMAL(10,2) NOT NULL,
    created_at DATETIME NOT NULL,
    INDEX idx_transactions_created_at (created_at)
);

CREATE TABLE IF NOT EXISTS fare_matrix (
    id BIGINT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    fare_month CHAR(7) NOT NULL,
    origin VARCHAR(150) NOT NULL,
    destination VARCHAR(150) NOT NULL,
    route_key VARCHAR(255) NOT NULL,
    distance_km DECIMAL(8,2) NOT NULL,
    fare DECIMAL(10,2) NOT NULL,
    updated_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    UNIQUE KEY uq_fare_matrix_route_month (fare_month, route_key),
    INDEX idx_fare_matrix_month (fare_month)
);
