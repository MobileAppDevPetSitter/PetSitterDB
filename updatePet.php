<?php
    require '/home/robert/config/conn.php';

    if(isset($_POST['pet_id']) && isset($_POST['name']) && isset($_POST['bio']) && isset($_POST['medicine']) && isset($_POST['bathroom']) && isset($_POST['exercise']) && isset($_POST['emergency_contact']) && isset($_POST['food']) && isset($_POST['veterinarian']) && isset($_POST['other'])){
        
        $pet_id         = htmlspecialchars($_POST['pet_id']);
	    $pet_medicine   = htmlspecialchars($_POST['medicine']);
        $pet_name       = htmlspecialchars($_POST['name']);
        $pet_bio        = htmlspecialchars($_POST['bio']);
        $pet_bathroom   = htmlspecialchars($_POST['bathroom']);
        $pet_exercise   = htmlspecialchars($_POST['exercise']);
        $pet_veterinarian_info = htmlspecialchars($_POST['veterinarian']);
        $pet_emergency  = htmlspecialchars($_POST['emergency_contact']);
        $pet_other      = htmlspecialchars($_POST['other']);
        $food           = htmlspecialchars($_POST['food']);

        // Check for email query
        $sql="UPDATE pet 
              SET name = '"     . $pet_name . 
              "', bio  = '"     . $pet_bio  .
              "', bathroom_instructions = '" . $pet_bathroom .
              "', exercise_instructions = '" . $pet_exercise . 
              "', medicine = '" . $pet_medicine .
              "', veterinarian_info = '" . $veterinarian .
              "', emergency_contact = '" . $pet_emergency .
              "', other = '" . $pet_other .
              "', food = '" . $food .
              "' WHERE pet_id = '" . $pet_id . "';";

//        echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            
            $response['message'] = "Pet updated";
            print json_encode($response);
        }
        
    } else {
        
        print "Must set all columns";
        
    }


    $mysqli->close();

?>