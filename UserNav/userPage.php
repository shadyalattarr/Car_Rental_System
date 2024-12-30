<?php
session_start();

// Check if the user is logged in and is an admin
if (!isset($_SESSION['name'])) {
    header("Location: Login.html"); // Redirect to login page if not logged in
    exit();
}

$adminName = $_SESSION['name'];
?>




<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <script>
        // Function to toggle search fields based on the selected search method
        function toggleSearchFields() {
            var searchBy = document.getElementById("searchBy").value;
            var carFields = document.getElementById("carFields");
            var customerFields = document.getElementById("customerFields");
            var reservationFields = document.getElementById("reservationFields");

            // Hide all fields initially
            carFields.style.display = "none";
            customerFields.style.display = "none";
            reservationFields.style.display = "none";

            // Display the relevant fields based on the selected search method
            if (searchBy === "car") {
                carFields.style.display = "block";
            } else if (searchBy === "customer") {
                customerFields.style.display = "block";
            } else if (searchBy === "reservation") {
                reservationFields.style.display = "block";
            }
        }
    </script>
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <div class="container">
            <a class="navbar-brand" href="Homepage.html">CarRental</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav ms-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="../HomeNav/Login.html">Login</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="../HomeNav/Signup.html">Signup</a>
                    </li>
                </ul>
            </div>
        </div>
    </nav>

    <div class="container mt-5">
        <h2 class="text-center">Hello, Customer <?php echo $adminName; ?>!</h2>
        <p class="text-center text-muted">Welcome.</p>

        <div class="row mt-3 justify-content-center">
            <div class="col-md-4 text-center mb-3">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#reserveCar">Reserve Car</button>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-md-4 text-center mb-3">
                <a href="returnCar.php" class="btn btn-primary w-100">Return Car</a>
            </div>
        </div>
        
    </div>

    <!-- Modal to Reserve Car -->
    <div class="modal fade" id="reserveCar" tabindex="-1" aria-labelledby="reserveCarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                <div>
                    <h5 class="modal-title" id="reserveCarModalLabel">Car Details</h5>
                    <h6 class="modal-title" id="reserveCarModalLabel">Add Filters</h6>
                </div>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="reserveCar.php" method="POST">
                        <div class="mb-3">
                            <label for="manufacturer" class="form-label">Manufacturer</label>
                            <input type="text" class="form-control" id="manufacturer" name="manufacturer">
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control" id="model" name="model">
                        </div>
                        <div class="mb-3">
                            <label for="manufactureYear" class="form-label">Manufacture Year</label>
                            <input type="number" class="form-control" id="manufactureYear" name="manufactureYear" min="1900" max="2099">
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Maximum Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Look for Car</button>
                    </form>
                </div>
            </div>
        </div>
    </div>


    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
