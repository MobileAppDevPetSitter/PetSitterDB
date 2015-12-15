<?php
    require '/home/robert/config/conn.php';

    $response = array("status" => "bad");

    if(isset($_POST['sitting_id'])){
        
        $sitting_id = htmlspecialchars($_POST['sitting_id']);

        // Check for email query
        $sql="select * from pet_sitting where pet_sitting_id = '" . $sitting_id . " INNER JOIN pet WHERE pet_sitting.pet_id = pet.id';";

//        echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysql_error();
            die(json_encode($response));
        } else {
            $response["status"] = "ok";
            
            $pet = mysqli_fetch_assoc($result);
            
            $response['sitter_id']   = $pet['sitter_id'];
            $response['pet_id']      = $pet['pet_id'];
            $response['name']        = $pet['name'];
            $response['currentStatus']      = $pet['status'];
            $response['start']       = $pet['start_date'];
            $response['end']         = $pet['end_date'];
            
            
            
            print json_encode($response);
        }
        
        $mysqli->close();
        
    } else {
        print "must set sitting_id";
    }

?>