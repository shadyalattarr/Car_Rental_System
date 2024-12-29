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
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];
    $manufactureYear = $_POST['manufactureYear'];
    $status = "active";
    $maxPrice = $_POST['price'];


    $query = "SELECT * FROM car WHERE 1";
    
    if ($manufacturer) {
        $query .= " AND manufacturer = '$manufacturer'";
    }
    if ($model) {
        $query .= " AND model = '$model'";
    }
    if ($manufactureYear) {
        $query .= " AND manufactureyear = '$manufactureYear'";
    }
    if ($maxPrice) {
        $query .= " AND price <= $maxPrice";
    }

    //$query .= " AND `status` = '$status'"; // status active to be able to reserve?

    $result = $conn->query($query);
    #store all results in an array so we can display later
    $results = array();
    if ($result->num_rows > 0) {
        while($row = $result->fetch_assoc()) {
            $results[] = $row;
        }
    }
   
   // Store filtered cars in session and redirect to displayCars.php
   $_SESSION['filteredCars'] = $results;
   header("Location: displayCars.php");
   exit();
   
    
}
?>