<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['selectedCar']) || !isset($_POST['endDate'])) {
    header("Location: userPage.php");
    exit();
}

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "car_rental_system";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$selectedCar = $_SESSION['selectedCar'];
$customerId = $_SESSION['CustomerID'];
$plateId = $selectedCar['PlateID'];
$officeId = $selectedCar['office_id'];
$endDate = $_POST['endDate'];

// Insert reservation into action table
$sql = "INSERT INTO action (CustomerID, PlateID, office_id, end_date) 
        VALUES (?, ?, ?, ?)";
$stmt = $conn->prepare($sql);
$stmt->bind_param("isss", $customerId, $plateId, $officeId, $endDate);

// Update car status to rented
$updateSql = "UPDATE car SET Status = 'rented' WHERE PlateID = ?";
$updateStmt = $conn->prepare($updateSql);
$updateStmt->bind_param("s", $plateId);

if ($stmt->execute() && $updateStmt->execute()) {
    unset($_SESSION['selectedCar']);
    unset($_SESSION['endDate']);
    header("Location: userPage.php?success=1");
} else {
    header("Location: reserveCarDetails.php?error=1");
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reservation Successful</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Redirect back to the user page after 3 seconds
        setTimeout(() => {
            window.location.href = 'userPage.php';
        }, 3000);
    </script>
</head>
<body>
    <div class="container mt-5 text-center">
        <h1 class="text-success">Reservation Successful!</h1>
        <p>Your reservation for the car with PlateID <strong><?php echo htmlspecialchars($selectedCar['PlateID']); ?></strong> has been completed.</p>
        <p class="text-muted">You will be redirected to the user page shortly.</p>
    </div>
</body>
</html>
