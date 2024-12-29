CREATE DATABASE CAR_RENTAL_SYSTEM;

CREATE TABLE Car (
    PlateID INT UNSIGNED AUTO_INCREMENT,
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