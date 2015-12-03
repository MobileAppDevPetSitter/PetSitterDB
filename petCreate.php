<?php
    require '/home/robert/config/conn.php';

    if(isset($_POST['name']) && isset($_POST['bio']) && isset($_POST['bathroom']) && isset($_POST['exercise'])){
        
        $pet_name       = htmlspecialchars($_POST['name']);                
        $pet_bio        = htmlspecialchars($_POST['bio']);
        $pet_bathroom   = htmlspecialchars($_POST['bathroom']);
        $pet_exercise   = htmlspecialchars($_POST['exercise']);

        // Check for email query
        $sql="INSERT into pet (name,bio,bathroom_instructions,exercise_instructions) 
              VALUES ('" . $pet_name . "','" . $pet_bio . "','" . $pet_bathroom . "','" . $pet_exercise . "');";

        //echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            
            $response['message'] = "Pet created";
            print json_encode($response);
        }
        
    } else {
        
        print "Must set 'name', 'bio', 'bathroom', 'exercise'";
        
    }


    $mysqli->close();

?>