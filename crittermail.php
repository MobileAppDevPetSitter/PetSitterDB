<?php
    $response = array("status" => "bad");

    if(!isset($_POST['email']) || !isset($_POST['password'])) {
        $response['message'] = "Missing Input!";
        
        die($response);
    }

    // Valid input
    require '/home/robert/config/conn.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);

    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $salt = uniqid(mt_rand(), false);
    $activation = strtoupper(substr(hash("sha256",time(),false),0,5));

    // Check for email query
    $sql="select * from user where email = '" . $email . "';";

    //echo $sql;
    $result = mysqli_query($mysqli,$sql);

    //echo mysql_error();
    if (!$result) {
        $response['message'] = "Creation Unsuccessful!" . mysql_error();
        die(json_encode($response));
    }

    // Check if email is already take
    if($result->num_rows != 0) {
        $response['message'] = "Email already taken!";
        die(json_encode($response));
    }

    // Salt and hash of password
    $saltedPassword = hash("md5", $password.$salt);


    // SQL for insertion
    $sql="Insert into user (email, status, verification_code, password, salt) values ('" . $email . "','PENDING','" . $activation . "','" . $saltedPassword . "','" . $salt . "');";


    // Parse result
    $result = mysqli_query($mysqli,$sql);
    $response["id"] = mysqli_insert_id($mysqli);

    // Check for succes insert
    if (!$result) {
        $response['errorMessage'] = "Creation Unsuccessful!" . mysql_error();

        die(json_encode($response));
    }

    // Verification email setup
    $to      = $email;
    $subject = 'Critter Sitter Activation number!';
    $message = 'Your activation number is ' . $activation;
    $headers = 'From: CritterSitter' . "\r\n" .
    'Reply-To: NOREPLY@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    if(mail($to, $subject, $message, $headers)) {
        $response['status'] = "ok";
        $response['message'] = "Successful account creation!";

        echo json_encode($response);
    } else {
        $response["message"] = "Failed to send to email account provided!";
        echo json_encode($response);
    }


    $mysqli->close();
?>