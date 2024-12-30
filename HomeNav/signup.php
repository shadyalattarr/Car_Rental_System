

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>signup.php</title>
</head>
<body>
    <?php 
    // did you submit or not

    //$_POST["submit"] -> true if you came in here through submission
    // if true 
    // validate
    //errors 
    // redirect to original page ?


    // i will assume we come here with 100% validates info
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
    
    $sql = "SELECT * FROM ".$table_name; // selects all emails of all users from user table
    $result = $conn->query($sql); //to run a query through our connection
    $taken = false;



    if ($result->num_rows > 0) { // if there's data
        // go through each row and check email

        while($row = $result->fetch_assoc()) { // fetch_assoc() funtion that gets you the each row in an array, each row is a dictionary
            if ($row["email"] == $_POST["email"]) { // comparing the each email form the table to the email we got from POST
                $taken=true;
                break;
            }
        }

    }
    

    if (!$taken) {
            
        $sql = "INSERT INTO ".$table_name." (Name,email,phone_number,password) VALUES ('".$_POST["name"]."','".$_POST["email"]."','".$_POST["phone"]."','".md5($_POST["password"])."')";
        
        if ($conn->query($sql) === TRUE) { // can check if TRUE with certain queries including INSET, DELETE , UPDATE
            header("Location: Homepage.html"); // will want to redirect to either a user page or admin page
            // exit; // i think nn to exit?
        } else {
            echo "i think we have problem";
        }
    } else {// Invalid credentials
        echo "<script>alert('Email already in use! Please use another email!'); window.location.href='Signup.html';</script>";
        // echo "EMAIL IS DUPLICATED IDK WHERE ETO PUT THIS MESSAGE i think i will make seesiion to send it but need all php";
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