<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_POST['searchDate'])) {
    header("Location: AdminPage.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "car_rental_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$searchDate = $_POST['searchDate'];

$query = "SELECT 
            car.PlateID, 
            car.Manufacturer, 
            car.Model, 
            car.ManufactureYear,
            CASE
                WHEN car.Status = 'rented' AND ? > action.end_date THEN 'active'
                WHEN car.Status = 'rented' AND ? < action.reservation_date THEN 'active'
                ELSE car.Status
            END as Status,
            car.Price
          FROM car 
          LEFT JOIN action ON car.PlateID = action.PlateID
          WHERE ? BETWEEN action.reservation_date AND action.end_date
          OR (action.reservation_date IS NULL AND action.end_date IS NULL)
          OR (car.Status = 'rented' AND ? > action.end_date)
          OR (car.Status = 'rented' AND ? < action.reservation_date)";

$stmt = $conn->prepare($query);
$stmt->bind_param("sssss", $searchDate, $searchDate, $searchDate, $searchDate, $searchDate);
$stmt->execute();
$result = $stmt->get_result();
$results = [];

while ($row = $result->fetch_assoc()) {
    $results[] = $row;
}

// Store results in session and redirect to search results page
$_SESSION['searchResults'] = $results;
header("Location: displayDateSearch.php");
exit();
?>
