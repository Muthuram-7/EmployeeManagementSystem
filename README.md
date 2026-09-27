Employee Management System

A web-based Employee Management System built with PHP and MySQL. The application provides employee record management, role-based access control, authentication, search, filtering, pagination, and dashboard insights through a responsive Bootstrap interface.

Features
User login and logout
Role-based access control
Add, view, edit, and delete employees
Search employees by name, email, phone, department, and designation
Filter employees by department and status
Pagination for employee records
Dashboard with employee and payroll statistics
User management for administrators
Password change functionality
Server-side input validation
CSRF protection
Prepared SQL statements
HTML output escaping
User Roles
Admin
View dashboard
View employees
Add employees
Edit employees
Delete employees
Manage system users
Change password
HR Manager
View dashboard
View employees
Add employees
Edit employees
Delete employees
Change password
HR Staff
View dashboard
View employee records
Change password
Technologies Used
PHP
MySQL
HTML5
CSS3
Bootstrap 5
Apache
XAMPP
Git
GitHub

Project Structure
EmployeeManagementSystem/
├── assets/
│   └── css/
├── config/
├── dashboard/
├── employees/
├── includes/
├── users/
├── authenticate.php
├── change_password.php
├── index.php
├── login.php
├── logout.php
└── update_password.php

Database
The application uses a MySQL database named:

employee_management_system

Main tables:

employees
users
Running Locally
Install XAMPP.
Start Apache and MySQL from the XAMPP Control Panel.
Place the project inside:
C:\xampp\htdocs\
Create the employee_management_system database in phpMyAdmin.
Create the required employees and users tables.
Configure the database connection in:
config/db_connect.php
Open the application in a browser:
http://localhost/EmployeeManagementSystem/
Security

The application includes:

Password hashing and verification
Prepared statements for database queries
CSRF token validation
Server-side input validation
Session-based authentication
Role-based authorization
HTML output escaping
Protection against unauthorized employee management
Protection against deleting the currently logged-in user
Protection against deleting the last administrator account
Author

Muthuram M