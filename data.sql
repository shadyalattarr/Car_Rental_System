INSERT INTO Customer (Name, email, phone_number, `password`, `Role`) VALUES
('Alice Johnson', 'alice.johnson@example.com', '1234567890', '482c811da5d5b4bc6d497ffa98491e38', 'user'),
('Bob Smith', 'bob.smith@example.com', '2345678901', '482c811da5d5b4bc6d497ffa98491e38', 'user'),
('Charlie Brown', 'charlie.brown@example.com', '3456789012', '482c811da5d5b4bc6d497ffa98491e38', 'user'),
('Diana Prince', 'diana.prince@example.com', '4567890123', '482c811da5d5b4bc6d497ffa98491e38', 'user'),
('Edward Norton', 'edward.norton@example.com', '5678901234', '482c811da5d5b4bc6d497ffa98491e38', 'user'),
('Fiona Green', 'fiona.green@example.com', '6789012345', '482c811da5d5b4bc6d497ffa98491e38', 'user'),
('George White', 'george.white@example.com', '7890123456', '482c811da5d5b4bc6d497ffa98491e38', 'user'),
('Hannah Black', 'hannah.black@example.com', '8901234567', '482c811da5d5b4bc6d497ffa98491e38', 'user'),
('Irene Red', 'irene.red@example.com', '9012345678', '482c811da5d5b4bc6d497ffa98491e38', 'admin'),
('Jack Brown', 'jack.brown@example.com', '0123456789', '482c811da5d5b4bc6d497ffa98491e38', 'admin');

INSERT INTO office (office_name, office_location) VALUES
('Downtown Office', '123 Main St, Cityville'),
('Airport Office', '456 Airport Rd, Cityville'),
('Suburban Office', '789 Suburb Ln, Cityville'),
('Harbor Office', '321 Ocean Dr, Seaville'),
('Central Office', '567 Park Ave, Metropolis'),
('Northside Office', '890 Hilltop Rd, Northville'),
('Eastside Office', '234 Sunrise Blvd, Eastville'),
('Westside Office', '345 Sunset Blvd, Westville');

INSERT INTO Car (PlateID, Manufacturer, Model, ManufactureYear, office_id, `Status`, Price) VALUES
('ABC1234', 'Toyota', 'Corolla', 2020, 1, 'active', 25.00),
('XYZ5678', 'Honda', 'Civic', 2019, 2, 'active', 30.00),
('LMN9101', 'Ford', 'Focus', 2021, 3, 'active', 28.00),
('QWE7890', 'Chevrolet', 'Cruze', 2022, 2, 'out of service', 27.50),
('JKL4321', 'Nissan', 'Altima', 2018, 2, 'active', 22.00),
('ASD6543', 'Hyundai', 'Elantra', 2020, 6, 'active', 24.00),
('ZXC9876', 'Volkswagen', 'Jetta', 2021, 7, 'active', 26.50),
('TYU8765', 'Mazda', 'Mazda3', 2019, 7, 'active', 23.00),
('BNM5432', 'Kia', 'Forte', 2022, 5, 'out of service', 27.00),
('GHJ3210', 'Subaru', 'Impreza', 2020, 4, 'active', 25.50),
('VBN6547', 'Tesla', 'Model 3', 2023, 1, 'active', 50.00),
('ERT9874', 'BMW', '3 Series', 2018, 2, 'active', 45.00),
('PLM1239', 'Mercedes', 'C-Class', 2020, 3, 'active', 48.00),
('UYT0987', 'Audi', 'A4', 2019, 7, 'active', 40.00),
('WQX6548', 'Lexus', 'IS', 2021, 4, 'out of service', 42.00),
('OPA4325', 'Acura', 'TLX', 2022, 6, 'active', 43.00),
('CVB7654', 'Infinity', 'Q50', 2021, 7, 'active', 44.00),
('NMO9821', 'Volvo', 'S60', 2019, 4, 'active', 41.00),
('YUI2134', 'Cadillac', 'CT4', 2020, 7, 'active', 39.50),
('HJK4321', 'Jaguar', 'XE', 2023, 3, 'active', 55.00);