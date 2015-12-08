<?php
    $response = array("status" => "bad");

    if(!isset($_POST['email']) || !isset($_POST['password'])) {
        $response['message'] = "Missing Input!";
        
        die(json_encode($response));
    }

    require '/home/robert/config/conn.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $password = htmlspecialchars($_POST['password']);
    $email    = htmlspecialchars($_POST['email']);
    
    
    $sql="SELECT * FROM user WHERE email = '" . $email . "';";
    
    //echo $sql;
    $result = mysqli_query($mysqli,$sql);
    
    //echo mysql_error();
    if (!$result) {
        $response['message'] = "SQL Failed";
        die(json_encode($response));
    }
    
    if($result->num_rows>0) {
        $row = $result->fetch_assoc();
        $saltedPass = hash("md5", $password.$row['salt']);

        
        if($saltedPass == $row['password']) {
            $response['status'] = "ok";
            $response['message'] = "Successful login!";
            $response['id']      = $row['user_id'];
        } else {
            $response['message'] = "Password does not match!";
        }

        echo json_encode($response);
    } else {
        
        $response['message'] = "Code does not match!";
        echo (json_encode($response));
    }
           
           
    $mysqli->close();

?>