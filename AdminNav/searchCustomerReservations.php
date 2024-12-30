<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_POST['customerId']) || !isset($_POST['startDate']) || !isset($_POST['endDate'])) {
    header("Location: AdminPage.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "car_rental_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerId = $_POST['customerId'];
$startDate = $_POST['startDate'];
$endDate = $_POST['endDate'];

$query = "SELECT 
            c.CustomerID,
            c.Name as CustomerName,
            c.email,
            c.phone_number,
            car.PlateID,
            car.Model,
            car.Manufacturer,
            a.reservation_date,
            a.end_date
          FROM customer c
          JOIN action a ON c.CustomerID = a.CustomerID
          JOIN car ON a.PlateID = car.PlateID
          WHERE c.CustomerID = ?
          AND (
              (a.reservation_date BETWEEN ? AND ?) 
              OR (a.end_date BETWEEN ? AND ?)
              OR (a.reservation_date <= ? AND a.end_date >= ?)
          )
          ORDER BY a.reservation_date";

$stmt = $conn->prepare($query);
$stmt->bind_param("sssssss", 
    $customerId,
    $startDate, $endDate,
    $startDate, $endDate,
    $startDate, $endDate
);
$stmt->execute();
$result = $stmt->get_result();
$results = [];

while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}

$_SESSION['customerResults'] = $results;
header("Location: displayCustomerResults.php");
exit();
?>
