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

$plateId = $_POST['plateId'];
$customerId = $_SESSION['CustomerID'];

// Verify that the reservation can be cancelled (current_date < reservation_date)
$checkQuery = "SELECT 1 FROM action 
              WHERE PlateID = ? AND CustomerID = ? 
              AND CURRENT_DATE < reservation_date
              AND end_date > CURRENT_DATE";

$checkStmt = $conn->prepare($checkQuery);
$checkStmt->bind_param("si", $plateId, $customerId);
$checkStmt->execute();
$result = $checkStmt->get_result();

if ($result->num_rows === 0) {
    header("Location: returnCar.php?error=1&message=Cannot cancel this reservation");
    exit();
}

// Begin transaction
$conn->begin_transaction();

try {
    // Delete the reservation from action table
    $deleteAction = "DELETE FROM action 
                    WHERE CustomerID = ? 
                    AND PlateID = ? 
                    AND CURRENT_DATE < reservation_date";
    $stmt1 = $conn->prepare($deleteAction);
    $stmt1->bind_param("is", $customerId, $plateId);
    $stmt1->execute();

    // Update car status to active
    $updateCar = "UPDATE car SET Status = 'active' WHERE PlateID = ?";
    $stmt2 = $conn->prepare($updateCar);
    $stmt2->bind_param("s", $plateId);
    $stmt2->execute();

    // Commit transaction
    $conn->commit();
    header("Location: returnCar.php?success=1&message=Reservation cancelled successfully");
} catch (Exception $e) {
    // Rollback transaction on error
    $conn->rollback();
    header("Location: returnCar.php?error=1&message=Error cancelling reservation");
}

$conn->close();
?>
