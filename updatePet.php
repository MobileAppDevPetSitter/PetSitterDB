<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['pet_id']) && isset($_POST['name']) && isset($_POST['bio']) && isset($_POST['bathroom']) && isset($_POST['exercise'])){
                            
        $pet_id         = htmlspecialchars($_POST['pet_id']);
        $pet_name       = htmlspecialchars($_POST['name']);                
        $pet_bio        = htmlspecialchars($_POST['bio']);
        $pet_bathroom   = htmlspecialchars($_POST['bathroom']);
        $pet_exercise   = htmlspecialchars($_POST['exercise']);

        // Check for email query
        $sql="UPDATE pet 
              SET name = '"     . $pet_name . 
              "', bio  = '"     . $pet_bio  .
              "', bathroom_instructions = '" . $pet_bathroom .
              "', exercise_instructions = '" . $pet_exercise . 
              "' WHERE pet_id = '" . $pet_id . "';";

//        echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            
            $response['message'] = "Pet updated";
            $response['status'] = 'ok';
            print json_encode($response);
        }
        
    } else {
        
        print "Must set 'pet_id','name','bio','bathroom', and 'exercise'";
        
    }


    $mysqli->close();

?>