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
        <h2 class="text-center">Hello, Admin <?php echo $adminName; ?>!</h2>
        <p class="text-center text-muted">Welcome.</p>

        <div class="row mt-3 justify-content-center">
            <div class="col-md-4 text-center mb-3">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#addCarModal">Add Car</button>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-md-4 text-center">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#searchModal">Search</button>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-md-4 text-center">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#updateCarModal">Update Car</button>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-md-4 text-center">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#dateSearchModal">Search by Date</button>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-md-4 text-center">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#periodSearchModal">Search by Period for Car</button>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-md-4 text-center">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#customerPeriodModal">Search Customer Reservations</button>
            </div>
        </div>
        <div class="row mt-3 justify-content-center">
            <div class="col-md-4 text-center">
                <button class="btn btn-primary w-100" data-bs-toggle="modal" data-bs-target="#revenueSearchModal">View Revenue</button>
            </div>
        </div>
    </div>

    <!-- Modal to Add Car -->
    <div class="modal fade" id="addCarModal" tabindex="-1" aria-labelledby="addCarModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="addCarModalLabel">Add Car Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="addCar.php" method="POST">
                        <div class="mb-3">
                            <label for="plateid" class="form-label">Plate ID</label>
                            <input type="text" class="form-control" id="plateid" name="plateid" required>
                        </div>
                        <div class="mb-3">
                            <label for="manufacturer" class="form-label">Manufacturer</label>
                            <input type="text" class="form-control" id="manufacturer" name="manufacturer" required>
                        </div>
                        <div class="mb-3">
                            <label for="model" class="form-label">Model</label>
                            <input type="text" class="form-control" id="model" name="model" required>
                        </div>
                        <div class="mb-3">
                            <label for="manufactureYear" class="form-label">Manufacture Year</label>
                            <input type="number" class="form-control" id="manufactureYear" name="manufactureYear" min="1900" max="2099" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="out of service">Out of Service</option>
                                <option value="rented">Rented</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="price" class="form-label">Price</label>
                            <input type="number" class="form-control" id="price" name="price" step="0.01" required>
                        </div>
                        <div class="mb-3">
                            <label for="officeId" class="form-label">Office ID</label>
                            <input type="text" class="form-control" id="officeId" name="officeId" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Add Car</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal to Search -->
    <div class="modal fade" id="searchModal" tabindex="-1" aria-labelledby="searchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="searchModalLabel">Search</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="searchResults.php" method="POST">
                        <div class="mb-3">
                            <label for="searchBy" class="form-label">Search By</label>
                            <select class="form-select" id="searchBy" name="searchBy" required onchange="toggleSearchFields()">
                                <option value="">-- Select Search Method --</option> <!-- Empty initial option -->
                                <option value="car">Car Information</option>
                                <option value="customer">Customer Information</option>
                                <option value="reservation">Reservation Day</option>
                            </select>
                        </div>

                        <!-- Car Information Fields -->
                        <div id="carFields" style="display: none;">
                            <div class="mb-3">
                                <label for="plateid" class="form-label">Plate ID</label>
                                <input type="text" class="form-control" id="plateid" name="plateid">
                            </div>
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
                                <input type="number" class="form-control" id="manufactureYear" name="manufactureYear">
                            </div>
                            <div class="mb-3">
                                <label for="status" class="form-label">Status</label>
                                <select class="form-select" id="status" name="status">
                                    <option value="">-- Any Statuses --</option>
                                    <option value="active">Active</option>
                                    <option value="out of service">Out of Service</option>
                                    <option value="rented">Rented</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="price" class="form-label">Price</label>
                                <input type="number" class="form-control" id="price" name="price">
                            </div>
                            <div class="mb-3">
                                <label for="officeId" class="form-label">Office ID</label>
                                <input type="text" class="form-control" id="officeId" name="officeId">
                            </div>
                        </div>

                        <!-- Customer Information Field -->
                        <div id="customerFields" style="display: none;">
                            <div class="mb-3">
                                <label for="customerId" class="form-label">Customer ID</label>
                                <input type="text" class="form-control" id="customerId" name="customerId">
                            </div>
                        </div>

                        <!-- Reservation Date Field -->
                        <div id="reservationFields" style="display: none;">
                            <div class="mb-3">
                                <label for="reservationDate" class="form-label">Reservation Date</label>
                                <input type="date" class="form-control" id="reservationDate" name="reservationDate">
                            </div>
                        </div>

                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- Modal to update Car -->
    <div class="modal fade" id="updateCarModal" tabindex="-1" aria-labelledby="updateModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="updateModalLabel">Update Car Details</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="updateCar.php" method="POST">
                        <div class="mb-3">
                            <label for="plateid" class="form-label">Plate ID</label>
                            <input type="text" class="form-control" id="plateid" name="plateid" required>
                        </div>
                        <div class="mb-3">
                            <label for="status" class="form-label">Status</label>
                            <select class="form-select" id="status" name="status" required>
                                <option value="active">Active</option>
                                <option value="out of service">Out of Service</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Update Car</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this new modal for date search -->
    <div class="modal fade" id="dateSearchModal" tabindex="-1" aria-labelledby="dateSearchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="dateSearchModalLabel">Search Cars by Date</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="searchByDate.php" method="POST">
                        <div class="mb-3">
                            <label for="searchDate" class="form-label">Select Date</label>
                            <input type="date" class="form-control" id="searchDate" name="searchDate" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add this new modal for period search -->
    <div class="modal fade" id="periodSearchModal" tabindex="-1" aria-labelledby="periodSearchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="periodSearchModalLabel">Search Reservations by Period</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="searchByPeriod.php" method="POST">
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="carId" class="form-label">Car ID (Optional)</label>
                            <input type="text" class="form-control" id="carId" name="carId">
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add new modal for customer period search -->
    <div class="modal fade" id="customerPeriodModal" tabindex="-1" aria-labelledby="customerPeriodModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="customerPeriodModalLabel">Search Customer Reservations</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="searchCustomerReservations.php" method="POST">
                        <div class="mb-3">
                            <label for="customerId" class="form-label">Customer ID</label>
                            <input type="text" class="form-control" id="customerId" name="customerId" required>
                        </div>
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">Search</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Add new modal for revenue search -->
    <div class="modal fade" id="revenueSearchModal" tabindex="-1" aria-labelledby="revenueSearchModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="revenueSearchModalLabel">Search Revenue by Period</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form action="searchRevenue.php" method="POST">
                        <div class="mb-3">
                            <label for="startDate" class="form-label">Start Date</label>
                            <input type="date" class="form-control" id="startDate" name="startDate" required>
                        </div>
                        <div class="mb-3">
                            <label for="endDate" class="form-label">End Date</label>
                            <input type="date" class="form-control" id="endDate" name="endDate" required>
                        </div>
                        <button type="submit" class="btn btn-primary w-100">View Revenue</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
