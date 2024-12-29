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

// Check if form data is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];

    // Hash the entered password using md5
    $hashed_password = $password;

    // Query to check the user's role
    $sql = "SELECT `Name` , `Role` FROM customer WHERE email = ? AND `password` = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $email, $hashed_password);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        // Fetch the role of the user
        $row = $result->fetch_assoc();
        $role = $row['Role'];
        $name = $row['Name'];

        $_SESSION['name'] = $name;

        // Redirect based on role   
        if ($role == 'admin') {
            header("Location: ../AdminNav/AdminPage.php");
        } elseif ($role == 'user') {
            header("Location: UserPage.html");
        }
        exit();
    } else {
        // Invalid credentials
        echo "<script>alert('Invalid email or password!'); window.location.href='Login.html';</script>";
    }

    $stmt->close();
}

$conn->close();
?>
