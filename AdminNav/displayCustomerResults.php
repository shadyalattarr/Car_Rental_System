<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['customerResults'])) {
    header("Location: AdminPage.php");
    exit();
}

$results = $_SESSION['customerResults'];
unset($_SESSION['customerResults']); // Clear session data after use
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Reservations</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="AdminPage.php">Back to Admin Page</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Customer Reservation History</h2>
        <?php if (empty($results)): ?>
            <p class="text-center mt-4">No reservations found for this customer in the specified period.</p>
        <?php else: ?>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Customer ID</th>
                            <th>Customer Name</th>
                            <th>Email</th>
                            <th>Phone</th>
                            <th>Car Model</th>
                            <th>Plate ID</th>
                            <th>Reservation Date</th>
                            <th>End Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['CustomerID']); ?></td>
                                <td><?php echo htmlspecialchars($row['CustomerName']); ?></td>
                                <td><?php echo htmlspecialchars($row['email']); ?></td>
                                <td><?php echo htmlspecialchars($row['phone_number']); ?></td>
                                <td><?php echo htmlspecialchars($row['Manufacturer'] . ' ' . $row['Model']); ?></td>
                                <td><?php echo htmlspecialchars($row['PlateID']); ?></td>
                                <td><?php echo htmlspecialchars($row['reservation_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <button onclick="window.location.href='AdminPage.php'" class="btn btn-primary mt-4">Return to Admin Page</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
