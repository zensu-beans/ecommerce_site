🗺️ How XAMPP Runs Your Store (Mental Map)
Before jumping in, it helps to understand what you are setting up. XAMPP turns your personal computer into a local website server.
Apache: The engine that serves your HTML, CSS, and JS web pages to your browser.
htdocs: The magic folder where all your project files must live so Apache can find them.
MySQL: The storage vault where your product inventory and admin passwords are kept.

🛠️ Step-by-Step Setup Guide

Step 1: Prepare the XAMPP Folders

Download and install XAMPP on your computer.
Open the XAMPP Control Panel.
Click the Start buttons next to both Apache and MySQL (they will turn green once they are running).

Open your computer's file explorer and navigate to your htdocs folder. (Windows: C:\xampp\htdocs | Mac: /Applications/XAMPP/htdocs/)

Create a brand-new folder named crud-store directly inside the htdocs directory.
Copy and paste all your project files (your HTML, CSS, JS, and the api folder) into this new crud-store folder.

Step 2: Set Up Your Database

Open your web browser and navigate to http://localhost/phpmyadmin.
Click on the SQL tab located in the top menu bar.

Copy the SQL code block below.
Paste it into the large white text box and click the Go button at the bottom right.

SQL

CREATE DATABASE IF NOT EXISTS crud_store CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
USE crud_store;

CREATE TABLE IF NOT EXISTS admins (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(80) NOT NULL UNIQUE,
    password VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

INSERT INTO admins (username, password)
VALUES ('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi')
ON DUPLICATE KEY UPDATE id = id;

CREATE TABLE IF NOT EXISTS products (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(200) NOT NULL,
    category ENUM('Laptops','Smartphones','Gaming','Smartwatches') NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    old_price DECIMAL(12,2) DEFAULT NULL,
    stock INT NOT NULL DEFAULT 0,
    rating DECIMAL(3,1) DEFAULT 0.0,
    reviews INT DEFAULT 0,
    badge ENUM('new','sale','hot','') DEFAULT '',
    img VARCHAR(300) DEFAULT '',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);


Step 3: Add the Store Banner Table
Stay in phpmyadmin and ensure you are still on the SQL tab.

Copy the second SQL code block below.
Paste it into the text box and click the Go button to generate your homepage content table.

SQL

CREATE TABLE IF NOT EXISTS store_banner (
    id INT PRIMARY KEY,
    eyebrow VARCHAR(100),
    title VARCHAR(255),
    description TEXT,
    price VARCHAR(100),
    img_path VARCHAR(300)
);


Step 4: Connect Your PHP Code to XAMPP

Go back to your computer's file explorer and open your crud-store folder.

Open the api folder and locate your database connection file (this is your config.php file).
Verify that the database login credentials inside the file match XAMPP's default settings exactly as shown below:

PHP
$servername = "localhost";
$username   = "root";         // This is always 'root' in XAMPP
$password   = "";             // This must be completely empty/blank in XAMPP
$dbname     = "crud_store";   // This must match the database name exactly


Step 5: Open and Test Your Store!
Open a clean tab in your web browser.
Go to this exact address: http://localhost/crud-store/index.html
Navigate to your Products page. If your products load onto the screen, everything is configured perfectly!
