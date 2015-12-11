<?php
    require '/home/robert/config/conn.php';

    $response['status'] = "bad";

    if(isset($_POST['pet_id']) && isset($_POST['owner_id'])){
        
        $owner_id       = htmlspecialchars($_POST['owner_id']);                
        $pet_id         = htmlspecialchars($_POST['pet_id']);

        // Check for email query
        $sql="INSERT into owner (owner_id, pet_id)
              VALUES ('" . $owner_id . "','" . $pet_id . "');";

        echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            $response['status']  = "ok";
            $response['message'] = "Pet Assigned to owner";
            print json_encode($response);
        }
        
    } else {
        $response['message'] = "Must set 'pet_id' and 'owner_id'";
        echo json_encode($response);
    }

    $mysqli->close();

?>