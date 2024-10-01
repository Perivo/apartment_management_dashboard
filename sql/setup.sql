-- Create Database
CREATE DATABASE IF NOT EXISTS apartment_db;
USE apartment_db;

-- Create the admins table
CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);


-- Properties Table
CREATE TABLE properties (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    address VARCHAR(255) NOT NULL,
    units INT(11) NOT NULL
);

-- Tenants Table
CREATE TABLE tenants (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    property_id INT(11),
    name VARCHAR(100),
    contact VARCHAR(100),
    lease_start DATE,
    rent_amount DECIMAL(10, 2),
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

-- Rent Payments Table
CREATE TABLE rent_payments (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    tenant_id INT(11),
    amount_paid DECIMAL(10, 2),
    payment_date DATE,
    status ENUM('paid', 'overdue'),
    FOREIGN KEY (tenant_id) REFERENCES tenants(id) ON DELETE CASCADE
);

-- Maintenance Requests Table
CREATE TABLE maintenance_requests (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    property_id INT(11),
    description TEXT,
    status ENUM('pending', 'in progress', 'completed') DEFAULT 'pending',
    request_date DATE,
    FOREIGN KEY (property_id) REFERENCES properties(id) ON DELETE CASCADE
);

