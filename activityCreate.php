<?php
    require '/home/robert/config/conn.php';

    if(isset($_POST['pet_sitting_id']) && isset($_POST['description']) && isset($_POST['status']) && isset($_POST['photo_path'])){
        
        $sitting_id       = htmlspecialchars($_POST['pet_sitting_id']);                
        $description        = htmlspecialchars($_POST['description']);
        $status   = htmlspecialchars($_POST['status']);
        $photo   = htmlspecialchars($_POST['photo_path']);

        // Check for email query
        $sql="INSERT into activity (pet_sitting_id,description,status,photo_path) 
              VALUES ('" . $sitting_id . "','" . $description . "','" . $status . "','" . $photo . "');";

        //echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            $id = mysqli_insert_id($mysqli);
            
            $response['message'] = "Pet created";
            $response['id']      = $id;
            print json_encode($response);
            } 
        }
        
    } else {
        
        $response['message'] =  "Must set 'name', 'bio', 'bathroom', 'exercise', 'emergency_contact','veterinarian_info','other'";
        print json_encode($response);
        
    }

    $mysqli->close();
    

?>