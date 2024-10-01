# Apartment Management System

## Project Overview
This is a simple web-based **Apartment Management System** built using PHP, MySQL, HTML, CSS, JavaScript, and Bootstrap. It allows an admin to manage properties, tenants, rent payments, and maintenance requests through a user-friendly dashboard.

## Features
1. **Admin Login System**: 
   - Admin can log in using a username and password.
   
2. **Property Management**:
   - Admin can add, edit, or delete properties.
   
3. **Tenant Management**:
   - Admin can add, edit, or delete tenants.
   - Each tenant is associated with a specific property.

4. **Rent Tracking**:
   - Admin can record rent payments and track which tenants have paid or are overdue.

5. **Maintenance Request Management**:
   - Admin can create and manage maintenance requests for properties.

6. **Dashboard**:
   - Admin can see an overview of key statistics such as the total number of properties, tenants, rent due, and pending maintenance requests.

## Installation

1. **Download and Install XAMPP** from [here](https://www.apachefriends.org/index.html).
2. **Start Apache and MySQL** in XAMPP Control Panel.
3. **Clone this repository** or download the project files and place them inside the `htdocs` folder of XAMPP (e.g., `C:/xampp/htdocs/apartment_management`).
4. **Create a database**:
   - Go to [phpMyAdmin](http://localhost/phpmyadmin).
   - Create a new database named `apartment_db`.
   - Import the `sql/setup.sql` file into your database to create the required tables.

5. **Access the project**:
   - Visit [http://localhost/apartment_management/index.php](http://localhost/apartment_management/index.php) in your browser.
   - Use the **register page** to create your admin account or directly log in if you've already registered.

## Technologies Used
- PHP
- MySQL
- HTML
- CSS
- JavaScript
- Bootstrap

## Author
- Your Name
