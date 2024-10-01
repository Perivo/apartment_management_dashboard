
CREATE TABLE propertie (
    id INT AUTO_INCREMENT PRIMARY KEY,
    property_name VARCHAR(255) NOT NULL,
    address VARCHAR(255) NOT NULL,
    number_of_units INT NOT NULL
);

CREATE TABLE tenant (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    contact VARCHAR(20) NOT NULL,
    lease_start_date DATE NOT NULL,
    rent_amount DECIMAL(10, 2) NOT NULL
);

CREATE TABLE maintenance_request (
    id INT AUTO_INCREMENT PRIMARY KEY,
    request_description TEXT NOT NULL,
    status ENUM('pending', 'in progress', 'completed') DEFAULT 'pending'
);

CREATE TABLE rent_payment (
    id INT AUTO_INCREMENT PRIMARY KEY,
    tenant_id INT NOT NULL,
    amount_paid DECIMAL(10, 2) NOT NULL,
    payment_date DATE NOT NULL,
    status ENUM('paid', 'unpaid') DEFAULT 'unpaid',
    FOREIGN KEY (tenant_id) REFERENCES tenants(id)
);