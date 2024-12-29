<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['name'])) {
    header("Location: Login.html");
    exit();
}

// Retrieve filtered cars from session
$filteredCars = $_SESSION['filteredCars'] ?? [];
unset($_SESSION['filteredCars']); // Clear session data after use
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Car List</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="userPage.php">Back to user page</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Available Cars</h2>
        <div class="table-responsive mt-4">
            <table class="table table-striped table-bordered">
                <thead class="table-primary">
                    <tr>
                        <th>PlateID</th>
                        <th>Manufacturer</th>
                        <th>Model</th>
                        <th>Year</th>
                        <th>Price</th>
                        <th>Car Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($filteredCars)): ?>
                        <tr>
                            <td colspan="6" class="text-center">No cars found.</td>
                        </tr>
                    <?php else: ?>
                        <?php foreach ($filteredCars as $car): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($car['PlateID']); ?></td>
                                <td><?php echo htmlspecialchars($car['Manufacturer']); ?></td>
                                <td><?php echo htmlspecialchars($car['Model']); ?></td>
                                <td><?php echo htmlspecialchars($car['ManufactureYear']); ?></td>
                                <td><?php echo htmlspecialchars($car['Price']); ?></td>
                                <td>
                                    <?php if ($car['Status'] === 'active'): ?>
                                        <form action="reserveCarDetails.php" method="POST" style="display: inline;">
                                            <input type="hidden" name="selectedCar" value="<?php echo htmlspecialchars(json_encode($car)); ?>">
                                            <button type="submit" class="btn btn-link text-success fw-bold p-0 m-0">Active</button>
                                        </form>
                                    <?php elseif ($car['Status'] === 'rented'): ?>
                                        <span class="text-warning fw-bold">Rented</span>
                                    <?php elseif ($car['Status'] === 'out of service'): ?>
                                        <span class="text-danger fw-bold">Out of Service</span>
                                    <?php else: ?>
                                        <span class="text-muted fw-bold">Unknown</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>

            </table>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
