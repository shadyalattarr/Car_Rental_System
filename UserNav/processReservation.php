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

    // Simulate a successful reservation
    // In a real-world application, you might update the car's status in the database here.
    
    unset($_SESSION['selectedCar']); // Clear session data after successful reservation
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
