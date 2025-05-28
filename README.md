# Recruitment Tracker

A simple yet powerful PHP & MySQL-based web application to streamline the hiring process. Designed for HR teams and recruitment managers, it enables easy tracking of job postings, candidate applications, department listings, and user activity with secure, role-based access.

---

## Features

-  **Role-Based Login**: Separate dashboards for Users and Admins
-  **Dashboard Analytics**: Real-time stats for candidates, jobs, departments, and users (admin only)
-  **CRUD Operations**: Manage candidates, job listings, and departments
-  **User Management**: Admins can add, edit, and delete user accounts
-  **User Activity Logs**: Track key actions performed by users (admin view only)
- **Secure Authentication**: Password hashing, session tracking, and role-based access
- **Responsive UI**: Built with Bootstrap 5 for seamless experience across devices

---

##  Tech Stack

**Frontend**
- HTML5
- CSS3 (Bootstrap 5)
- JavaScript

**Backend**
- Core PHP
- MySQL

---

##  Who Can Use It?

- HR staff and recruiters
- Recruitment managers or HR leads
- Small to medium-sized businesses or departments

---

## Getting Started

1. Clone the repository:
   ```bash
   git clone https://github.com/your-username/recruitment-tracker.git
Import the included SQL file into your MySQL database.

Update the database connection settings in config.php.

Run the project using a local server (e.g., XAMPP) or deploy on a PHP-enabled web server.

Admin Login (for Demo)
Use the following credentials to log in as an admin:

Username / Email: admin@gmail.com

Password: admin123

Note: Change these credentials in production environments for security reasons.

Database Structure
users: stores name, email, hashed password, and role

candidates: stores candidate info and linked user

jobs: stores job title, description, and salary

departments: stores department names and optional metadata

activity_logs: records user actions for admin monitoring

Benefits
Centralized and organized recruitment workflow

Secure, role-based access control

Transparent user action tracking

Department-wise data segregation

User-friendly interface for all technical levels

Easily extendable and customizable for future needs

License
This project is open-source and free to use for educational or organizational purposes.
