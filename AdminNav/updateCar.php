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
    $status = $_POST['status'];

    // First check if car exists
    $check_sql = "SELECT Status FROM car WHERE PlateID = '$plate_id'";
    $result = $conn->query($check_sql);

    if ($result->num_rows == 0) {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Error</title>
        </head>
        <body>
            <div style='text-align: center; padding: 20px; background: #f44336; color: white;'>Car with this Plate ID does not exist!</div>
            <script>
                setTimeout(function() {
                    window.location.href = 'AdminPage.php';
                }, 3000);
            </script>
        </body>
        </html>
        <?php
        exit();
    }

    // Check if car is rented
    $car_status = $result->fetch_assoc()['Status'];
    if ($car_status === 'rented') {
        ?>
        <!DOCTYPE html>
        <html>
        <head>
            <title>Error</title>
        </head>
        <body>
            <div style='text-align: center; padding: 20px; background: #f44336; color: white;'>Cannot update status: Car is currently rented!</div>
            <script>
                setTimeout(function() {
                    window.location.href = 'AdminPage.php';
                }, 3000);
            </script>
        </body>
        </html>
        <?php
        exit();
    }

    // If not rented, proceed with update
    $sql = "UPDATE car SET `status` = '$status' WHERE PlateID = '$plate_id'";
    try {
        if ($conn->query($sql) === TRUE) {
            ?>
            <!DOCTYPE html>
            <html>
            <head>
                <title>Success</title>
            </head>
            <body>
                <div style='text-align: center; padding: 20px; background: #4CAF50; color: white;'>Car Updated Successfully!</div>
                <script>
                    setTimeout(function() {
                        window.location.href = 'AdminPage.php';
                    }, 3000);
                </script>
            </body>
            </html>
            <?php
        }
    } finally {
        $conn->close();
    }
}
?>