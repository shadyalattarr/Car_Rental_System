CREATE DATABASE CAR_RENTAL_SYSTEM;

CREATE TABLE Car (
    PlateID varchar(8) NOT NULL,
    Manufacturer varchar(255) NOT NULL,
    Model varchar(255) NOT NULL,
    ManufactureYear YEAR NOT NULL,
    `Status` ENUM('active', 'out of service', 'rented') NOT NULL DEFAULT 'active',
    Price DECIMAL(12,2),
    PRIMARY KEY(PlateID)
);

CREATE TABLE Customer (
	CustomerID INT UNSIGNED AUTO_INCREMENT,
    Name varchar(255) NOT NULL,
    email varchar(255) NOT NULL UNIQUE,
    phone_number varchar(255) NOT NULL,
    last_4_card_digits CHAR(4), -- Store only last 4 digits
    `password` varchar(255),
    `Role` ENUM('user', 'admin') NOT NULL DEFAULT 'user',
    PRIMARY KEY(CustomerID)
); 

CREATE TABLE office (
	office_id INT UNSIGNED AUTO_INCREMENT,
    office_name varchar(255) NOT NULL,
    office_location varchar(255) NOT NULL,
    PRIMARY KEY(office_id)
); 

INSERT INTO office (office_name, office_location) VALUES
('Headquarters', 'New York'),
('Regional Office', 'Los Angeles'),
('Sales Office', 'Chicago'),
('Support Center', 'Seattle'),
('Branch Office', 'Miami');




CREATE TABLE action (
	CustomerID INT UNSIGNED,
    PlateID varchar(8) NOT NULL,
    office_id INT UNSIGNED,
    reservation_date DATE DEFAULT CURRENT_DATE,
    action_type ENUM('reserve', 'pick up','payment', 'return') NOT NULL, -- ???
    PRIMARY KEY(CustomerID,PlateID,office_id,) -- ?????
    -- forign ks
); 
