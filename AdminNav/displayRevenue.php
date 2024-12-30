<?php
session_start();

if (!isset($_SESSION['name']) || !isset($_SESSION['revenueResults'])) {
    header("Location: AdminPage.php");
    exit();
}

$results = $_SESSION['revenueResults'];
$totalRevenue = $_SESSION['totalRevenue'];
unset($_SESSION['revenueResults']);
unset($_SESSION['totalRevenue']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Revenue Report</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="AdminPage.php">Back to Admin Page</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Daily Revenue Report</h2>
        <?php if (empty($results)): ?>
            <p class="text-center mt-4">No revenue data found for this period.</p>
        <?php else: ?>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <th>Date</th>
                            <th>Cars Rented</th>
                            <th>Daily Revenue</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['payment_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['cars_rented']); ?></td>
                                <td>$<?php echo htmlspecialchars($row['daily_revenue'] ?? '0.00'); ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr class="table-info">
                            <td colspan="2" class="text-end fw-bold">Total Revenue:</td>
                            <td class="fw-bold">$<?php echo htmlspecialchars($totalRevenue); ?></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>
        <button onclick="window.location.href='AdminPage.php'" class="btn btn-primary mt-4">Return to Admin Page</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
