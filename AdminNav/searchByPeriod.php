<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_POST['startDate']) || !isset($_POST['endDate'])) {
    header("Location: AdminPage.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "car_rental_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];
$carId = $_POST['carId'] ?? '';

if (empty($carId)) {
    // Query for all reservations with car and customer info
    $query = "SELECT 
                a.reservation_date, a.end_date,
                c.PlateID, c.Manufacturer, c.Model, c.ManufactureYear, c.Status, c.Price,
                cust.CustomerID, cust.Name as CustomerName, cust.email, cust.phone_number
              FROM action a
              JOIN car c ON a.PlateID = c.PlateID
              JOIN customer cust ON a.CustomerID = cust.CustomerID
              WHERE a.reservation_date BETWEEN ? AND ?
              OR a.end_date BETWEEN ? AND ?";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("ssss", $startDate, $endDate, $startDate, $endDate);
} else {
    // Query for specific car reservations
    $query = "SELECT 
                a.reservation_date, a.end_date,
                c.PlateID, c.Manufacturer, c.Model, c.ManufactureYear, c.Status, c.Price
              FROM action a
              JOIN car c ON a.PlateID = c.PlateID
              WHERE c.PlateID = ?
              AND (a.reservation_date BETWEEN ? AND ?
              OR a.end_date BETWEEN ? AND ?)";
    
    $stmt = $conn->prepare($query);
    $stmt->bind_param("sssss", $carId, $startDate, $endDate, $startDate, $endDate);
}

$stmt->execute();
$result = $stmt->get_result();
$results = [];

while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}

$_SESSION['periodResults'] = $results;
header("Location: displayPeriodResults.php");
exit();
?>
