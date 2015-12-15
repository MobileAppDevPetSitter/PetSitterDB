<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['activity_id']) && isset($_POST['status'])){
                            
        $activity_id         = htmlspecialchars($_POST['pet_sitting_id']);
        $status                 = htmlspecialchars($_POST['status']);

        // Check for email query
        $sql="UPDATE pet_sitting
              SET status = '"     . $status . 
              "' WHERE pet_sitting_id = '" . $activity_id . "';";

//        echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            $response['status']  = 'ok';
            $response['message'] = "Activity updated";
            print json_encode($response);
        }
        
    } else {
        
        $response['message'] = "Must set 'pet_sitting_id','status'";
        print json_encode($response);
    }


    $mysqli->close();

?>