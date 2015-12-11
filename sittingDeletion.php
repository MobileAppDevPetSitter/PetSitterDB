<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['pet_sitting_id'])){
        
        $sitting_id       = htmlspecialchars($_POST['pet_sitting_id']);

        // Check for email query
        $sql="Delete from pet_sitting where pet_sitting_id = '" . $sitting_id . "');";

        echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            $response['status'] = 'ok';
            $response['message'] = "sitting instance deleted";
            print json_encode($response);
        }
        
    } else {
        
        $response['message'] =  "Must set 'pet_sitting_id','description','status','photo_path'";
        print json_encode($response);
        
    }

    $mysqli->close();
    

?>