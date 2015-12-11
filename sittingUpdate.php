<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['pet_sitting_id']) && isset($_POST['status'])){
                            
        $pet_sitting_id         = htmlspecialchars($_POST['pet_sitting_id']);
        $status                 = htmlspecialchars($_POST['status']);

        // Check for email query
        $sql="UPDATE pet_sitting
              SET status = '"     . $status . 
              "' WHERE pet_sitting_id = '" . $pet_sitting_id . "';";

//        echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            $response['status']  = 'ok';
            $response['message'] = "Sitting updated";
            print json_encode($response);
        }
        
    } else {
        
        response['message'] = "Must set 'pet_sitting_id','status','bio','bathroom', and 'exercise'";
        print json_encode($response);
    }


    $mysqli->close();

?>