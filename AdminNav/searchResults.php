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
    if ($_SERVER['REQUEST_METHOD']==='POST'){
        $searchBy = $_POST['searchBy'];
        #$results = [];
        if ($searchBy =='car'){
            $plate_id = $_POST['plateid'];
            $manufacturer = $_POST['manufacturer'];
            $model = $_POST['model'];
            $manufactureYear = $_POST['manufactureYear'];
            $status = $_POST['status'];
            $price = $_POST['price'];
            $query = "SELECT * FROM car WHERE 1";
            
            if ($plate_id) {#concatenates if that field isnt empty
                $query .= " AND PlateID = '$plate_id'";
            }
            if ($manufacturer) {
                $query .= " AND manufacturer = '$manufacturer'";
            }
            if ($model) {
                $query .= " AND model = '$model'";
            }
            if ($manufactureYear) {
                $query .= " AND manufactureyear = '$manufactureYear'";
            }
            if ($status) {
                $query .= " AND `status` = '$status'";
            }
            if ($price) {
                $query .= " AND price <= $price";
            }
            $result = $conn->query($query);
            #store all results in an array so we can display later
            $results = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }
            }
        }
        elseif ($searchBy =='customer'){
            $cust_id = $_POST['customerId'];
            $query = "SELECT * FROM customer WHERE 1";
            if ($cust_id) {
                $query .= " AND customer_id = '$cust_id'";
            }
            $result = $conn->query($query);
            $results = array();
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    $results[] = $row;
                }
            }
        }elseif ($searchBy =='reservation'){
            $res_date = $_POST['reservationDate'];
            $query = "SELECT * FROM reservation WHERE ";
            if ($res_date) { #THIS ISNT CORRECT YET BECAUSE TABLES DONT HAVE DATES, WE NEED TO ADJUST QUERY WHEN WE ADD DATES
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
    echo "<h1>Search Results</h1>";
    if (empty($results)) {
        echo "<p>No results found.</p>";
    } else {
        echo "<table border='1'>";
        foreach ($results[0] as $column => $value) {
            echo "<th>$column</th>";
        }
        foreach ($results as $row) {
            echo "<tr>";
            foreach ($row as $value) {
                echo "<td>$value</td>";
            }
            echo "</tr>";
        }
        echo "</table>";
    }
    echo "<button onclick='handleReturn()' style='padding: 10px 20px; background-color: #4CAF50; color: white; border: none; border-radius: 4px; cursor: pointer;'>Return to Admin Page</button>";
        echo "<script>
            function handleReturn() {
                // Reset the form if it exists
                if(window.opener && window.opener.document.getElementById('carSearchForm')) {
                    window.opener.document.getElementById('carSearchForm').reset();
                }
                // Redirect to admin page
                window.location.href = 'AdminPage.php';
            }
        </script>";
    $conn->close();
?>