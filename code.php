<?php
    $response = array("status" => "bad");
	//hey
    if(!isset($_POST['email']) || !isset($_POST['code'])) {
        $response['message'] = "Missing Input!";
        
        die(json_encode($response));
    }

    require '/home/robert/config/conn.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $code = htmlspecialchars($_POST['code']);
    $email = htmlspecialchars($_POST['email']);
    
    
    $sql="SELECT * FROM user WHERE email = '" . $email . "' AND verification_code = '" . $code . "';";
    
    //echo $sql;
    $result = mysqli_query($mysqli,$sql);
    
    //echo mysql_error();
    if (!$result) {
        $response['message'] = "SQL Failed";
        die(json_encode($response));
    }
    
    if($result->num_rows>0){
        $response['status'] = "ok";
        $response['message'] = "Successful account creation!";

        echo json_encode($response);
    } else {
        
        $response['message'] = "Code does not match!";
        echo (json_encode($response));
    }

    $mysqli->close();

?>
