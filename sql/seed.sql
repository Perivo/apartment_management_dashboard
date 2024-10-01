

-- Insert seed data into properties table
INSERT INTO properties (name, address, units) VALUES
('Greenwood Apartments', '123 Green St, Springfield', 20),
('Sunnyvale Estates', '456 Sunny Rd, Springfield', 15),
('Maple Leaf Residences', '789 Maple Ave, Springfield', 30);

-- Insert seed data into tenants table
INSERT INTO tenants (property_id, name, contact, lease_start, rent_amount) VALUES
(1, 'John Doe', 'john@example.com', '2024-01-01', 1200.00),
(1, 'Jane Smith', 'jane@example.com', '2024-02-01', 1150.00),
(2, 'Alice Johnson', 'alice@example.com', '2024-03-01', 1300.00),
(2, 'Bob Brown', 'bob@example.com', '2024-04-01', 1250.00),
(3, 'Charlie Black', 'charlie@example.com', '2024-05-01', 1100.00);

-- Insert seed data into rent_payments table
INSERT INTO rent_payments (tenant_id, amount_paid, payment_date, status) VALUES
(1, 1200.00, '2024-01-05', 'paid'),
(2, 1150.00, '2024-02-05', 'paid'),
(3, 1300.00, '2024-03-05', 'paid'),
(4, 1250.00, '2024-04-05', 'overdue'),
(5, 1100.00, '2024-05-05', 'paid');

-- Insert seed data into maintenance_requests table
INSERT INTO maintenance_requests (property_id, description, status, request_date) VALUES
(1, 'Leaking faucet in unit 101', 'pending', '2024-01-10'),
(2, 'Heating not working in unit 202', 'in progress', '2024-02-15'),
(3, 'Broken window in unit 303', 'completed', '2024-03-20'),
(1, 'Air conditioning repair needed', 'pending', '2024-04-25'),
(2, 'Light bulb replacement in hallway', 'completed', '2024-05-05');
