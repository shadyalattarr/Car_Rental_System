<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup.php</title>
</head>
<body>
    <?php 
    $server_name="localhost";
    $username = "root";
    $password = "";
    $dbname = "car_rental_system";

    $table_name="customer";

    $conn = new mysqli($server_name, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }
    echo "Connected successfully<br>";
    
    $sql = "SELECT * FROM ".$table_name; // selects all emails of all users from user table
    $result = $conn->query($sql); //to run a query through our connection
    $taken = false;



    if ($result->num_rows > 0) { // if there's data
        // go through each row and check email

        while($row = $result->fetch_assoc()) { // fetch_assoc() funtion that gets you the each row in an array, each row is a dictionary
            if ($row["email"] == $_POST["email"]) { // comparing the each email form the table to the email we got from POST
                // will have customer id increment and  email unique?
                // same : we cant have that
                //$errors[] = $row["email"]." is ALREADY TAKEN";
                echo "TAKEN";
                $taken=true;
                break;
            }
        }

    } else {
        //$errors[] = "Table is empty: 0 results";// shouldnt be able to come here?
    }
    

    if (!$taken) {
            
        $sql = "INSERT INTO ".$table_name." (Name,email,phone_number,last_4_card_digits,password) VALUES ('".$_POST["name"]."','".$_POST["email"]."','".$_POST["phone"]."','".$_POST["card_num"]."','".md5($_POST["password"])."')";
        
        if ($conn->query($sql) === TRUE) { // can check if TRUE with certain queries including INSET, DELETE , UPDATE
            echo "New record created successfully<br>";
            echo '<a href="HomePage.html">Log in NOW!</a>';
        } else {
            //$errors[] = "Error: creating new account failed: " . $sql . "<br>" . $conn->error;
        }
    }

    $conn->close();

    // if(!empty($errors)){// not being empty means we had errors
    //         echo "Errors Encountered:";
    //         foreach ($errors as $error): 
    //                 echo htmlspecialchars($error); 
    //         endforeach; 
    // }
    ?>
</body>
</html>