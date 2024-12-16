-- Create the dolphin_crm database
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


--UNCOMMENT BELOW and add to your query if u wish 

INSERT INTO Users (firstname, lastname, password, email, role) 
VALUES 
('John', 'Manager', SHA2('password123', 256), 'john.manager@example.com', 'manager'),
('Jane', 'Supervisor', SHA2('password123', 256), 'jane.supervisor@example.com', 'supervisor'),
('Emily', 'Executive', SHA2('password123', 256), 'emily.executive@example.com', 'executive');



-- Insert Contacts
INSERT INTO Contacts (title, firstname, lastname, email, telephone, company, type, assigned_to)
VALUES 
('Mr.', 'John', 'Doe', 'johndoe@example.com', '123-456-7890', 'Example Corp', 'Sales Lead', 1),
('Ms.', 'Jane', 'Smith', 'janesmith@example.com', '987-654-3210', 'Acme Inc', 'Support', 2),
('Dr.', 'Emily', 'Johnson', 'emilyj@example.com', '555-123-9876', 'Health Solutions', 'Sales Lead', 3),
('Mr.', 'James', 'Williams', 'jameswilliams@example.com', '321-654-9870', 'Tech Innovators', 'Support', 2),
('Mrs.', 'Patricia', 'Brown', 'patricia.brown@example.com', '222-333-4444', 'Finances Co', 'Sales Lead', 1);



