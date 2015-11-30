<?php

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
        die('Invalid query: ' . mysql_error());
    }
    
    if($result->num_rows==0){
        echo json_encode(['match'=>'false']); 
    } else {
        echo json_encode(['match'=>'true']);
    }

?>