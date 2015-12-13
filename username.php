<?php
$response['status'] = 'bad';
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
        $response['message'] = 'taken';
        echo json_encode($response); 
    } else {
        $response['status'] = 'ok';
        $response['message'] = 'not taken';
        echo json_encode($response);
    }
    
    
    $mysqli->close();
} else {
    print json_encode($response);
}
?>