<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: Login.html");
    exit();
}

// Check if car details exist in the session
if (isset($_SESSION['selectedCar'])) {
    $selectedCar = $_SESSION['selectedCar'];

    // Database connection
    $servername = "localhost";
    $username = "root"; // Modify with your DB username
    $password = ""; // Modify with your DB password
    $dbname = "CAR_RENTAL_SYSTEM";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Get the customer ID from session (assuming it exists)
    $customerId = $_SESSION['CustomerID']; // You should have this set during the login process

    // Fetch the office ID for the selected car from the Car table (assuming `office_id` is a column in the `Car` table)
    $carSql = "SELECT office_id FROM Car WHERE PlateID = ?";
    $carStmt = $conn->prepare($carSql);
    $carStmt->bind_param("s", $selectedCar['PlateID']);
    $carStmt->execute();
    $carStmt->bind_result($officeId);
    $carStmt->fetch();
    $carStmt->close();

    if (!$officeId) {
        die("Car's office ID could not be found.");
    }

    // Update the car's status to 'rented'
    $sql = "UPDATE Car SET Status = 'rented' WHERE PlateID = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $selectedCar['PlateID']);
    $stmt->execute();

    // Insert a new action record into the action table, including the office_id
    $actionSql = "INSERT INTO action (CustomerID, PlateID, office_id, reservation_date, action_type) 
                  VALUES (?, ?, ?, CURRENT_DATE, ?)";
    $actionStmt = $conn->prepare($actionSql);
    $actionType = 'reserve';
    $actionStmt->bind_param("isis", $customerId, $selectedCar['PlateID'], $officeId, $actionType);
    
    if (!$actionStmt->execute()) {
        die("Error creating reservation: " . $conn->error);
    }

    // Simulate a successful reservation (this is where the car status is updated)
    // You can clear session data after successful reservation
    unset($_SESSION['selectedCar']); // Clear session data after reservation

    // Close database connection
    $conn->close();

} else {
    // Redirect back if no car is selected
    header("Location: displayCars.php");
    exit();
}
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
