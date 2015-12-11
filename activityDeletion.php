<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['activity_id'])){
        
        $activity_id       = htmlspecialchars($_POST['activity_id']);

        // Check for email query
        $sql="Delete from activity where activity_id = '" . $activity_id . "';";

        // echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            $response['status'] = 'ok';
            $response['message'] = "pet deleted";
            print json_encode($response);
        }
        
    } else {
        
        $response['message'] =  "Must set 'pet_id'";
        print json_encode($response);
        
    }

    $mysqli->close();
    

?>