<?php
session_start();

if (!isset($_SESSION['CustomerID']) || !isset($_POST['plateId'])) {
    header("Location: userPage.php");
    exit();
}

$conn = new mysqli("localhost", "root", "", "car_rental_system");
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$customerId = $_SESSION['CustomerID'];
$plateId = $_POST['plateId'];
$today = date('Y-m-d');

// Begin transaction
$conn->begin_transaction();

try {
    // Update the action table end_date to today
    $updateAction = "UPDATE action 
                    SET end_date = ? 
                    WHERE CustomerID = ? 
                    AND PlateID = ? 
                    AND end_date > CURRENT_DATE";
    $stmt1 = $conn->prepare($updateAction);
    $stmt1->bind_param("sis", $today, $customerId, $plateId);
    $stmt1->execute();

    // Update car status to active
    $updateCar = "UPDATE car SET Status = 'active' WHERE PlateID = ?";
    $stmt2 = $conn->prepare($updateCar);
    $stmt2->bind_param("s", $plateId);
    $stmt2->execute();

    // Commit transaction
    $conn->commit();
    header("Location: returnCar.php?success=1");
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    header("Location: returnCar.php?error=1");
}

$conn->close();
?>
