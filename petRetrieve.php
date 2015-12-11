<?php
    require '/home/robert/config/conn.php';

    $response = array("status" => "bad");
    
    if(isset($_POST['pet_id'])){
        
        $pet_id = htmlspecialchars($_POST['pet_id']);

        // Check for email query
        $sql="select * from pet where pet_id = '" . $pet_id . "';";

        //echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysql_error();
            die(json_encode($response));
        } else {
            $response['status'] = "ok";

            $pet = mysqli_fetch_row($result);
            
            $response['pet_id']   = $pet[0];
            $response['name']     = $pet[1];
            
            print json_encode($response);
        }
        
        
        $mysqli->close();
        
    }

?>