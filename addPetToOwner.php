<?php
    require '/home/robert/config/conn.php';

    if(isset($_POST['pet_id']) && isset($_POST['owner_id'])){
        
        $owner_id       = htmlspecialchars($_POST['pet_id']);                
        $pet_id         = htmlspecialchars($_POST['owner_id']);

        // Check for email query
        $sql="INSERT into owner (owner_id, pet_id)
              VALUES ('" . $pet_id . "','" . $owner_id . "');";

        echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            
            $response['message'] = "Pet Assigned to owner";
            print json_encode($response);
        }
        
    } else {
        
        print "Must set 'pet_id' and 'owner_id'";
        
    }


    $mysqli->close();

?>