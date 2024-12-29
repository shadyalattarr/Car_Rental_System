<?php 
session_start();
// Define database connection variables
$servername = "localhost"; // Replace with your server name if different
$username = "root";        // Replace with your MySQL username
$password = "";            // Replace with your MySQL password (default is empty for XAMPP)
$dbname = "car_rental_system"; // Replace with your database name

// Create a connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $searchBy = $_POST['searchBy'];
    $results = [];
    
    if ($searchBy === 'car'){
        $plate_id = $_POST['plateid'];
        $manufacturer = $_POST['manufacturer'];
        $model = $_POST['model'];
        $manufactureYear = $_POST['manufactureYear'];
        $status = $_POST['status'];
        $price = $_POST['price'];
        $officeID = $_POST['officeId'];
        
        $query = "SELECT 
                    car.PlateID, car.Manufacturer, car.Model, car.ManufactureYear, car.Status, car.Price,office.office_location,
                    customer.CustomerID, customer.Name, customer.email, customer.phone_number
                  FROM car 
                  LEFT JOIN action ON car.PlateID = action.PlateID
                  LEFT JOIN customer ON action.CustomerID = customer.CustomerID
                  LEFT JOIN office ON car.office_id = office.office_id
                  WHERE 1";
        
        if ($plate_id) {
            $query .= " AND car.PlateID = '$plate_id'";
        }
        if ($manufacturer) {
            $query .= " AND car.Manufacturer = '$manufacturer'";
        }
        if ($model) {
            $query .= " AND car.Model = '$model'";
        }
        if ($manufactureYear) {
            $query .= " AND car.ManufactureYear = '$manufactureYear'";
        }
        if ($status) {
            $query .= " AND car.Status = '$status'";
        }
        if ($price) {
            $query .= " AND car.Price <= $price";
        }
        if ($officeID) {
            $query .= " AND car.office_id = '$officeID'";
        }
        $result = $conn->query($query);
        
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                // Check if customer details exist (indicating a reservation)
                if ($row['CustomerID'] === null) {
                    // No customer associated (not reserved), set customer details to '-'
                    $row['CustomerID'] = '-';
                    $row['Name'] = '-';
                    $row['email'] = '-';
                    $row['phone_number'] = '-';
                }
                $results[] = $row;
            }
        }
    } elseif ($searchBy === 'customer'){
        $cust_id = $_POST['customerId'];
        $query = "SELECT c.CustomerID, c.Name, c.email, c.phone_number, 
                         car.PlateID, car.Manufacturer, car.Model 
                  FROM customer c
                  LEFT JOIN action a ON c.CustomerID = a.CustomerID
                  LEFT JOIN car ON a.PlateID = car.PlateID
                  WHERE 1=1";
        if ($cust_id) {
            $query .= " AND c.CustomerID = '$cust_id'";
        }
        $result = $conn->query($query);
        $results = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
        }
    } elseif ($searchBy === 'reservation'){
        $res_date = $_POST['reservationDate'];
        $query = "SELECT * FROM reservation WHERE ";
        if ($res_date) {
            $query .= " AND reservation_id = '$res_date'";
        }
        $result = $conn->query($query);
        $results = array();
        if ($result->num_rows > 0) {
            while($row = $result->fetch_assoc()) {
                $results[] = $row;
            }
        }
    }
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Search Results</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="AdminPage.php">Back to Admin Page</a>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Search Results</h2>

        <?php if (empty($results)): ?>
            <p class="text-center">No results found.</p>
        <?php else: ?>
            <div class="table-responsive mt-4">
                <table class="table table-striped table-bordered">
                    <thead class="table-primary">
                        <tr>
                            <?php foreach (array_keys($results[0]) as $column): ?>
                                <th><?php echo htmlspecialchars(ucwords(str_replace('_', ' ', $column))); ?></th>
                            <?php endforeach; ?>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($results as $row): ?>
                            <tr>
                                <?php foreach ($row as $value): ?>
                                    <td><?php echo htmlspecialchars($value); ?></td>
                                <?php endforeach; ?>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        <?php endif; ?>

        <button onclick="handleReturn()" class="btn btn-primary mt-4">Return to Admin Page</button>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function handleReturn() {
            // Reset the form if it exists
            if(window.opener && window.opener.document.getElementById('carSearchForm')) {
                window.opener.document.getElementById('carSearchForm').reset();
            }
            // Redirect to admin page
            window.location.href = 'AdminPage.php';
        }
    </script>

</body>
</html>

