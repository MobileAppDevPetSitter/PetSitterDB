<?php
    require '/home/robert/config/conn.php';
	$response["status"] = "bad";
    
    if(isset($_POST['user_id']) && isset($_POST['name']) && isset($_POST['bio']) && isset($_POST['medicine']) && isset($_POST['bathroom']) && isset($_POST['exercise']) && isset($_POST['emergency_contact']) && isset($_POST['veterinarian']) && isset($_POST['other'])){
        
	$pet_medicine   = htmlspecialchars($_POST['medicine']);
        $pet_name       = htmlspecialchars($_POST['name']);
        $pet_bio        = htmlspecialchars($_POST['bio']);
        $pet_bathroom   = htmlspecialchars($_POST['bathroom']);
        $pet_exercise   = htmlspecialchars($_POST['exercise']);
        $pet_veterinarian_info = htmlspecialchars($_POST['veterinarian']);
        $pet_emergency  = htmlspecialchars($_POST['emergency_contact']);
        $pet_other      = htmlspecialchars($_POST['other']);
        $owner_id       = htmlspecialchars($_POST['user_id']);

        // Check for email query
        $sql="INSERT into pet (name,bio,bathroom_instructions,medicine,exercise_instructions,veterinarian_info,emergency_contact,other) 
              VALUES ('" . $pet_name . "','" . $pet_bio . "','" . $pet_bathroom . "','" . $pet_medicine  . "','" . $pet_exercise . "','" . $pet_veterinarian_info . "','" . $pet_emergency . "','" . $pet_other . "');";

        //echo $sql;
        $result = mysqli_query($mysqli,$sql);

        $response["status"] = "bad";
        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            $response['id'] = mysqli_insert_id($mysqli);

            $owner_sql = "INSERT into  owner (owner_id, pet_id) VALUES ('" . $owner_id . "','" . $response['id']  . "');";

            $result = mysqli_query($mysqli,$owner_sql);
            
            if(!$result) {
                $response['message'] = "Query Failed" . mysqli_error();
                die(json_encode($response));
            } else {
                $response['status']  = "ok";
                $response['message'] = "Pet created";
                print json_encode($response);       
            }
        }    
    } else {    
        $response['message'] =  "Must set 'name', 'bio', 'bathroom', 'exercise', 'emergency_contact','veterinarian_info','other'";
        print json_encode($response);
    }

    $mysqli->close();
    

?>
