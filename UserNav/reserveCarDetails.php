<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: Login.html");
    exit();
}

// Check if car details and dates are set
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['selectedCar']) && isset($_POST['endDate']) && isset($_POST['reservationDate'])) {
    $selectedCar = json_decode($_POST['selectedCar'], true);
    $endDate = $_POST['endDate'];
    $reservationDate = $_POST['reservationDate'];
    $_SESSION['selectedCar'] = $selectedCar;
    $_SESSION['endDate'] = $endDate;
    $_SESSION['reservationDate'] = $reservationDate;
} elseif (isset($_SESSION['selectedCar']) && isset($_SESSION['endDate']) && isset($_SESSION['reservationDate'])) {
    $selectedCar = $_SESSION['selectedCar'];
    $endDate = $_SESSION['endDate'];
    $reservationDate = $_SESSION['reservationDate'];
} else {
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
        <h2 class="text-center">Confirm Reservation</h2>
        <div class="card mt-4">
            <div class="card-body">
                <h5 class="card-title">Reservation Details</h5>
                <p><strong>PlateID:</strong> <?php echo htmlspecialchars($selectedCar['PlateID']); ?></p>
                <p><strong>Manufacturer:</strong> <?php echo htmlspecialchars($selectedCar['Manufacturer']); ?></p>
                <p><strong>Model:</strong> <?php echo htmlspecialchars($selectedCar['Model']); ?></p>
                <p><strong>Year:</strong> <?php echo htmlspecialchars($selectedCar['ManufactureYear']); ?></p>
                <p><strong>Price:</strong> $<?php echo htmlspecialchars($selectedCar['Price']); ?></p>
                <p><strong>Start Date:</strong> <?php echo htmlspecialchars($reservationDate); ?></p>
                <p><strong>End Date:</strong> <?php echo htmlspecialchars($endDate); ?></p>
                <form action="processReservation.php" method="POST">
                    <input type="hidden" name="endDate" value="<?php echo htmlspecialchars($endDate); ?>">
                    <input type="hidden" name="reservationDate" value="<?php echo htmlspecialchars($reservationDate); ?>">
                    <button type="submit" class="btn btn-primary w-100">Confirm Reservation</button>
                </form>
            </div>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
