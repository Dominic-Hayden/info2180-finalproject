-- Create the dolphin_crm database
DROP DATABASE IF EXISTS dolphin_crm;
CREATE DATABASE dolphin_crm;

-- Use the newly created database
USE dolphin_crm;

-- Create the Users table
CREATE TABLE Users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    password VARCHAR(255),
    email VARCHAR(255) UNIQUE,
    role VARCHAR(100),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP
);

-- Create the Contacts table
CREATE TABLE Contacts (
    id INT AUTO_INCREMENT PRIMARY KEY,
    title VARCHAR(50),
    firstname VARCHAR(255),
    lastname VARCHAR(255),
    email VARCHAR(255),
    telephone VARCHAR(50),
    company VARCHAR(255),
    type VARCHAR(50), -- Sales Lead or Support
    assigned_to INT, -- Foreign key to Users table (User ID)
    created_by INT,  -- Foreign key to Users table (User ID)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    updated_at DATETIME DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (assigned_to) REFERENCES Users(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

-- Create the Notes table
CREATE TABLE Notes (
    id INT AUTO_INCREMENT PRIMARY KEY,
    contact_id INT, -- Foreign key to Contacts table
    comment TEXT,
    created_by INT, -- Foreign key to Users table (User ID)
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (contact_id) REFERENCES Contacts(id),
    FOREIGN KEY (created_by) REFERENCES Users(id)
);

-- Insert a user with email admin@project2.com and hashed password
INSERT INTO Users (firstname, lastname, password, email, role) 
VALUES (
    'Admin', 
    'User', 
    SHA2('password123', 256),  -- SHA256 hashed password (Secure Hash Algorithm 2)
    'admin@project2.com', 
    'admin'
);

UNLOCK TABLES;

