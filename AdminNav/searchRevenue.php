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

$query = "WITH RECURSIVE dates AS (
            SELECT ? AS date
            UNION ALL
            SELECT date + INTERVAL 1 DAY
            FROM dates
            WHERE date < ?
          )
          SELECT 
            dates.date as payment_date,
            COUNT(DISTINCT c.PlateID) as cars_rented,
            SUM(c.Price) as daily_revenue
          FROM dates
          LEFT JOIN action a ON dates.date BETWEEN a.reservation_date AND a.end_date
          LEFT JOIN car c ON a.PlateID = c.PlateID
          GROUP BY dates.date
          ORDER BY dates.date";

$stmt = $conn->prepare($query);
$stmt->bind_param("ss", $startDate, $endDate);
$stmt->execute();
$result = $stmt->get_result();
$results = [];
$totalRevenue = 0;

while ($row = $result->fetch_assoc()) {
    $results[] = $row;
    $totalRevenue += $row['daily_revenue'] ?? 0;
}

$_SESSION['revenueResults'] = $results;
$_SESSION['totalRevenue'] = $totalRevenue;
header("Location: displayRevenue.php");
exit();
?>
