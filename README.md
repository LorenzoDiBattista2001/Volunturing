# Volunturing

**Volunturing** is a web application developed as the final project for the *Web Programming* course within the Bachelor's degree programme in **Computer Engineering** at the University of L'Aquila (Italy). 

The application is meant to serve as a digital bridge between a fictitious volunteering organisation based in the Italian city of Turin and people potentially interested in the organisation's social activities. The name 'Volunturing' was conceived as a portmanteau of the words 'Turin' and 'Volunteering', and it is directly linked to the institutional name of the fictitious organisation, 'VolonTorino' (a combination of the Italian words 'Volontario', meaning volunteer, and 'Torino', the Italian name of Turin).

The project implements a custom **MVC architecture** split into four strict layers (*View, Control, Entity, and Foundation*), ensuring secure data encapsulation, clean routing, and database concurrency handling (via row-level transactions).

The application is available on the web at the following address: [https://volunturing.altervista.org](https://volunturing.altervista.org)

---

## 👥 User Roles & Features

The application manages three distinct categories of users:

### 🌐 Unregistered Guests
* Browse the directory of currently scheduled social events.
* Read feedback and reviews left by registered volunteers.
* Access the organisation's history and **Contact Us** page.

### 🧑‍💻 Registered Volunteers
* Apply for active events by submitting a custom motivational message.
* Securely withdraw an open application at any time.
* Make monetary support contributions via a simulated credit card payment gateway.
* Write and publish experience reviews using a 1-to-5 star rating system.

### 🛡️ Administrators
* Create new social initiatives or safely delete scheduled ones (triggering automatic email updates to candidates via PHPMailer).
* Evaluate, approve, or reject pending applications with real-time race-condition protection.
* Manage user profiles by blocking or restoring access for inappropriate behavior.
* Moderate the public board by permanently removing offensive reviews.

---

## Installation Guide

In order to install and test out the application on your own machine, follow these steps.

### System Requirements
- **PHP**: Version 8.2 or higher
- **DBMS**: MySQL / MariaDB
- **Web Server**: Apache (make sure you have 'mod_rewrite' enabled)
- **Composer**: PHP dependency manager

### 1. Install application files and dependencies
1. Extract the whole project folder into the document root of your local Apache server (e.g., 'htdocs' if you are using XAMPP).
2. Open up your terminal window in the project's main directory and run the following command:
```bash
composer install
```
3. Make sure you give Apache read/write permissions on the `var/` directory and all subdirectories.

### 2. Set up the Database
1. Open your preferred database management tool (e.g., phpMyAdmin, DBeaver, or MySQL Workbench).
2. Create a new database schema with a name of your choice (e.g., `volunturing`).
3. Select the newly created database to ensure it is active.
4. Import and execute the provided `volunturing.sql` script to automatically generate the table structures and populate them with dummy data.

### 3. Edit the Configuration File
1. Open the `include/config.php` file.
2. Set the `DB_NAME` constant value to 'volunturing' (or whatever you have called the schema).
3. Update the `DB_HOST`, `DB_USER` and `DB_PASSWORD` constants values with your MySQL/MariaDB credentials.
4. Update the `CSS_PATH` and `JS_PATH` constants values with the URL relative paths of the `public/css/` and `public/js/` directories on your machine, making sure to leave out the trailing forward-slash (e.g., `/Volunturing/public/css` if your project is located in a subdirectory, or simply `/public/css` if it runs directly on the server document root).
5. Update the `SMTP_HOST`, `SMTP_PORT`, `SMTP_USER`, `SMTP_PASSWORD` constants values with your SMTP server (e.g., Mailtrap.io, Gmail SMTP) parameters to test out the automatic emails system functionalities.

### 4. Start using the application
Once your local Apache server is properly configured and running, you can access the application's main homepage through your browser by typing your local server's address in the URL bar (e.g., http://localhost/ or http://localhost/Volunturing/)