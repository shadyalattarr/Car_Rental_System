<?php
session_start();

if (!isset($_SESSION['name'])) {
    header("Location: Login.html");
    exit();
}

$conn = new mysqli("localhost", "root", "", "car_rental_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerId = $_SESSION['CustomerID'];

// Get rented cars for current user
$query = "SELECT c.PlateID, c.Manufacturer, c.Model, a.reservation_date, a.end_date 
          FROM car c 
          JOIN action a ON c.PlateID = a.PlateID 
          WHERE a.CustomerID = ? AND c.Status = 'rented' AND a.end_date > CURRENT_DATE";

$stmt = $conn->prepare($query);
$stmt->bind_param("i", $customerId);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Return Car</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="userPage.php">Back to User Page</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Return Rented Car</h2>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="alert alert-success" role="alert">
                Car returned successfully!
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="alert alert-danger" role="alert">
                Error returning car: <?php echo htmlspecialchars($_GET['message'] ?? 'Unknown error'); ?>
            </div>
        <?php endif; ?>
        
        <?php if ($result->num_rows > 0): ?>
            <div class="table-responsive mt-4">
                <table class="table table-striped">
                    <thead class="table-primary">
                        <tr>
                            <th>Plate ID</th>
                            <th>Manufacturer</th>
                            <th>Model</th>
                            <th>Rental Date</th>
                            <th>Planned Return Date</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php while ($row = $result->fetch_assoc()): ?>
                            <tr>
                                <td><?php echo htmlspecialchars($row['PlateID']); ?></td>
                                <td><?php echo htmlspecialchars($row['Manufacturer']); ?></td>
                                <td><?php echo htmlspecialchars($row['Model']); ?></td>
                                <td><?php echo htmlspecialchars($row['reservation_date']); ?></td>
                                <td><?php echo htmlspecialchars($row['end_date']); ?></td>
                                <td>
                                    <form action="processReturn.php" method="POST" style="display: inline;">
                                        <input type="hidden" name="plateId" value="<?php echo htmlspecialchars($row['PlateID']); ?>">
                                        <button type="submit" class="btn btn-success btn-sm">Return Now</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endwhile; ?>
                    </tbody>
                </table>
            </div>
        <?php else: ?>
            <p class="text-center mt-4">You have no cars to return.</p>
        <?php endif; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
