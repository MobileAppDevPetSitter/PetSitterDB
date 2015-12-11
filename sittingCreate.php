<?php
    require '/home/robert/config/conn.php';
    $response['status'] = "bad";   
    if(isset($_POST['email']) && isset($_POST['pet_id']) && isset($_POST['start_date']) && isset($_POST['end_date'])){
        
        $email = $_POST['email'];
        
        $sql = "select user_id from user where email = '" . $email . "';";
        
        $result = mysqli_query($mysqli,$sql);
        
        if (!$result) {
            $response['message'] = "Email not found" . mysqli_error();
            die(json_encode($response));
            
        } else {
            
            $query       = mysqli_fetch_assoc($result);
            echo $query;
            $sitter      = htmlspecialchars($query['user_id']);                
            $pet         = htmlspecialchars($_POST['pet_id']);
            $start       = htmlspecialchars($_POST['start_date']);
            $end         = htmlspecialchars($_POST['end_date']);

            // Check for email query
            $sql="INSERT into pet_sitting (sitter_id,pet_id,status,start_date,end_date) 
                  VALUES ('" . $sitter . "','" . $pet . "','open','" . $start . "','" . $end . "');";

    //        echo $sql;
            $result = mysqli_query($mysqli,$sql);
            //echo mysql_error();
            if (!$result) {
                $response['message'] = "Query Failed" . mysqli_error();
                die(json_encode($response));
            } else {

                $response['message'] = "Sitting instance created";
                $response['status']  = "ok";
                print json_encode($response);
            }
        }
        
        
    } else {
        $response['message'] = "Must set 'email','pet_id','start_date','end_date'";
        die(json_encode($response));
        
    }


    $mysqli->close();

?>