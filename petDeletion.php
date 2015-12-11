<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['pet_id'])){
        
        $pet_id       = htmlspecialchars($_POST['pet_id']);

        // Check for email query
        $sql="Delete from pet where pet_id = '" . $pet_id . "';";

//        echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            $response['status'] = 'ok';
            $response['message'] = "pet instance deleted";
            print json_encode($response);
        }
        
    } else {
        
        $response['message'] =  "Must set 'pet_id'";
        print json_encode($response);
        
    }

    $mysqli->close();
    

?>