<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: Login.html");
    exit();
}

// Check if car details are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedCar'])) {
    $selectedCar = json_decode($_POST['selectedCar'], true);
    $_SESSION['selectedCar'] = $selectedCar; // Store in session for persistence
} elseif (isset($_SESSION['selectedCar'])) {
    $selectedCar = $_SESSION['selectedCar'];
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
    <title>Reserve Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h2 class="text-center">Reserve Car</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Car Details</h5>
                <p><strong>PlateID:</strong> <?php echo htmlspecialchars($selectedCar['PlateID']); ?></p>
                <p><strong>Manufacturer:</strong> <?php echo htmlspecialchars($selectedCar['Manufacturer']); ?></p>
                <p><strong>Model:</strong> <?php echo htmlspecialchars($selectedCar['Model']); ?></p>
                <p><strong>Year:</strong> <?php echo htmlspecialchars($selectedCar['ManufactureYear']); ?></p>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars($selectedCar['Price']); ?></p>
                <form action="processReservation.php" method="POST">
                    <div class="mb-3">
                        <label for="cardDetails" class="form-label">Enter Card Details</label>
                        <input type="text" class="form-control" id="cardDetails" name="cardDetails" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Complete Reservation</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
