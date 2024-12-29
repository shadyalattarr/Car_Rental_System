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
    $plate_id = $_POST['plateid'];
    $manufacturer = $_POST['manufacturer'];
    $model = $_POST['model'];
    $manufactureYear = $_POST['manufactureYear'];
    $status = $_POST['status'];
    $price = $_POST['price'];
    $officeID = $_POST['officeId'];


    $sql = "INSERT INTO car (PlateID, manufacturer, model, ManufactureYear, `status`, price, office_id) VALUES ('$plate_id', '$manufacturer', '$model', '$manufactureYear', '$status', '$price','$officeID')";
    try {
        if ($conn->query($sql) === TRUE) {
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Success</title>
            </head>
            <body>
                <div style='text-align: center; padding: 20px; background: #4CAF50; color: white;'>Car Added Successfully!</div>
                <script>
                    setTimeout(function() {
                        window.location.href = 'AdminPage.php';
                    }, 3000);
                </script>
            </body>
            </html>
            <?php
        }
    } catch (mysqli_sql_exception $e) {
        if ($e->getCode() == 1062) {//1062 is error for duplicate entry of pk
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Error</title>
            </head>
            <body>
                <div style='text-align: center; padding: 20px; background: #f44336; color: white;'>Car with this Plate ID already exists!</div>
                <script>
                    setTimeout(function() {
                        window.location.href = 'AdminPage.php';
                    }, 3000);
                </script>
            </body>
            </html>
            <?php
        } else {
            throw $e;
        }
    }
}
?>