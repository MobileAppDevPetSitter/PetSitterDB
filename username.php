<?php
if(isset($_POST['email'])){
    require '/home/robert/config/conn.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    
    $email = htmlspecialchars($_POST['email']);
    
    $sql="select * from user where email = '" . $email . "';";
    
    //echo $sql;
    $result = mysqli_query($mysqli,$sql);
    
    //echo mysql_error();
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
    
    if($result->num_rows!=0){
        echo json_encode(['taken'=>'true']); 
    } else {
        echo json_encode(['taken'=>'false']);
    }
    
    
    $mysqli->close();
}
?>