🗺 How XAMPP Runs Your Store (Mental Map)
Before jumping in, it helps to understand what you are setting up. XAMPP turns your personal computer into a local website server.

Apache is the engine that serves your HTML, CSS, and JS web pages to your browser.

htdocs is the magic folder where all your project files must live so Apache can find them.

MySQL is the storage vault where your product inventory and admin passwords are kept.

🛠 Step-by-Step Setup Guide
📂 Step 1: Prepare the XAMPP Folders
Download and install XAMPP.

Open the XAMPP Control Panel on your computer.

Click the Start buttons next to both Apache and MySQL. (They will turn green once they are running).

Open your computer's file explorer and navigate to this exact folder:

Windows: C:\xampp\htdocs

Mac: /Applications/XAMPP/htdocs/

Inside that htdocs folder, create a brand-new folder named crud-store.

Copy and paste all your project files (your HTML files, CSS files, JS files, and the api folder) directly inside this new crud-store folder.

🗄 Step 2: Set Up Your Database (Since setup.sql is deleted)
Open your web browser and type this address: http://localhost/phpmyadmin

Look at the very top menu bar and click on the SQL tab.

Copy the entire gray code block below, paste it into the large white text box, and click the Go button at the bottom right.

------------------------------------------------------------------------------------------

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

------------------------------------------------------------------------------------------

🔗 Step 3: Connect Your PHP Code to XAMPP
Your PHP files need permission to read your newly created database.

Go into your crud-store folder, open your api folder, and find your database connection file (usually named db.php, or code located right at the top of your API files).

Make sure the database login credentials match XAMPP's default settings exactly:

------------------------------------------------------------------------------------------

$servername = "localhost";
$username   = "root";         // This is always 'root' in XAMPP
$password   = "";             // This must be completely empty/blank in XAMPP
$dbname     = "crud_store";   // This must match the database name exactly

------------------------------------------------------------------------------------------

💻 Step 4: Open and Test Your Store!
Open a clean tab in your web browser.

Go to this address: http://localhost/crud-store/index.html

Navigate to your Products page. If your 7 products load onto the screen, everything is configured perfectly!
