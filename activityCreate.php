<?php
    require '/home/robert/config/conn.php';

    if(isset($_POST['name']) && isset($_POST['bio']) && isset($_POST['bathroom']) && isset($_POST['exercise']) && isset($_POST['emergency_contact']) && isset($_POST['veterinarian_info']) && isset($_POST['other'])){
        
        $pet_name       = htmlspecialchars($_POST['name']);                
        $pet_bio        = htmlspecialchars($_POST['bio']);
        $pet_bathroom   = htmlspecialchars($_POST['bathroom']);
        $pet_exercise   = htmlspecialchars($_POST['exercise']);
        $pet_veterinarian_info = htmlspecialchars($_POST['veterinarian_info']);
        $pet_emergency  = htmlspecialchars($_POST['emergency_contact']);
        $pet_other      = htmlspecialchars($_POST['other']);

        // Check for email query
        $sql="INSERT into pet (name,bio,bathroom_instructions,exercise_instructions,veterinarian_info,emergency_contact,other) 
              VALUES ('" . $pet_name . "','" . $pet_bio . "','" . $pet_bathroom . "','" . $pet_exercise . "','" . $pet_veterinarian_info . "','" . $pet_emergency . "','" . $pet_other . "');";

        //echo $sql;
        $result = mysqli_query($mysqli,$sql);

        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            $sql = "SELECT LAST_INSERT_ID();";
            $result = mysqli_query($mysqli,$sql);
            
            if(!$result){
                $response['message'] = "Select Failed" . mysqli_error();
                die(json_encode($response));
            } else {
                $id     = mysqli_fetch_row($result);
                
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