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
                                            <div class="mb-3">
                                                <label for="reservationDate" class="form-label">Start Date</label>
                                                <input type="date" class="form-control" id="reservationDate" name="reservationDate" 
                                                       min="<?php echo date('Y-m-d'); ?>" required>
                                            </div>
                                            <div class="mb-3">
                                                <label for="endDate" class="form-label">End Date</label>
                                                <input type="date" class="form-control" id="endDate" name="endDate" required>
                                            </div>
                                            <button type="submit" class="btn btn-primary" onclick="return validateDates()">Reserve</button>
                                        </form>
                                        <script>
                                            function validateDates() {
                                                var startDate = document.getElementById('reservationDate').value;
                                                var endDate = document.getElementById('endDate').value;
                                                var today = new Date().toISOString().split('T')[0];
                                                
                                                if (startDate < today) {
                                                    alert('Start date cannot be in the past');
                                                    return false;
                                                }
                                                
                                                if (endDate <= startDate) {
                                                    alert('End date must be after start date');
                                                    return false;
                                                }
                                                
                                                return true;
                                            }

                                            // Set min date for end date based on selected start date
                                            document.getElementById('reservationDate').addEventListener('change', function() {
                                                var startDate = this.value;
                                                document.getElementById('endDate').min = startDate;
                                            });
                                        </script>
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
