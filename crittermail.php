<?php

if(isset($_POST['email'])){
    
    require '/home/robert/config/conn.php';
    ini_set('display_errors', 1);
    ini_set('display_startup_errors', 1);
    error_reporting(E_ALL);
    
    $email = htmlspecialchars($_POST['email']);
    $password = htmlspecialchars($_POST['password']);
    $salt = htmlspecialchars($_POST['salt']);
    $activation = strtoupper(substr(hash("sha256",time(),false),0,5));
    
    
    $sql="select * from user where email = '" . $email . "';";
    
    //echo $sql;
    $result = mysqli_query($mysqli,$sql);
    
    //echo mysql_error();
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }
    
    if($result->num_rows!=0){
        die(json_encode(['taken'=>'true','email'=>'notSent'])); 
    }
    
    
    $sql="Insert into user (email, status, verification_code, password, salt) values ('" . $email . "','not','" . $activation . "','" . $password . "','" . $salt . "');";

    
    $result = mysqli_query($mysqli,$sql);
    
    
    if (!$result) {
        die('Invalid query: ' . mysql_error());
    }

    
    $to      = $email;
    $subject = 'Critter Sitter Activation number!';
    $message = 'Your activation number is ' . $activation;
    $headers = 'From: CritterSitter' . "\r\n" .
    'Reply-To: NOREPLY@example.com' . "\r\n" .
    'X-Mailer: PHP/' . phpversion();

    if(mail($to, $subject, $message, $headers)){
        echo json_encode(['taken'=>'false','email'=>'sent']);
    }else{
        echo json_encode(['taken'=>'false','email'=>'notSent']);
    }
}
?>