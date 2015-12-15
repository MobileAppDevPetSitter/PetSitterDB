<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['owner_id'])){
        
        $owner_id = htmlspecialchars($_POST['owner_id']);
        
        $sql="select * from owner where owner_id = '" . $owner_id . "';";
        
        $result = mysqli_query($mysqli,$sql);

        //select pets owned
        
        if (!$result) {
            $response['message'] = "Query Failed" . mysql_error();
            die(json_encode($response));
        } else {
            
            if($result->num_rows >0){
                $counter = 0;
                while($row = mysqli_fetch_assoc($result)){
                    
                    $sql="select * from pet where pet_id = '" . $row["pet_id"] . "';";
                    
                    $petResult = mysqli_query($mysqli,$sql);
                    
                    if (!$petResult) {
                        $response['message'] = "Query Failed" . mysql_error();
                        die(json_encode($response));
                    } else {
                        
                        $petArray     = mysqli_fetch_assoc($petResult);

                        $pet['pet_id']   = $petArray['pet_id'];
                        $coolPets[$counter] = $petArray['pet_id'];
                        $pet['name']     = $petArray['name'];
                        $pet['bio']      = $petArray['bio'];
                        $pet['bathroom'] = $petArray['bathroom_instructions'];
                        $pet['exercise'] = $petArray['exercise_instructions'];
                        $pet['food']     = $petArray['food'];
                        $pet['emergency'] = $petArray['emergency_contact'];
                        $pet['other']    = $petArray['other'];
                        $pet['medicine'] = $petArray['medicine'];
                        $pet['vet']      = $petArray['veterinarian_info'];
                        $response['status'] = 'ok';
                        $pets[$counter] = $pet;
                        $response['pets'] = $pets;
                        $counter++;
                    }
                }
                print json_encode($response);
            } else {
                $response['message'] = "User owns no pets";
            }
            
        }
        
        //selecting pet instances of pets owned
        
        foreach($coolPets as $coolPetId){
        
            $sql="select * from pet_sitting where pet_id = '" . $coolPetId . "';";

            $result = mysqli_query($mysqli,$sql);

            if (!$result) {
                $response['message'] = "selecting from pet_sitting Failed" . mysql_error();
                die(json_encode($response));
            } else {

                if($result->num_rows >0){
                    $counter = 0;
                    while($row = mysqli_fetch_assoc($result)){

                        $sql="select * from pet where pet_id = '" . $coolPetId . "';";

                        $petResult = mysqli_query($mysqli,$sql);

                        if (!$petResult) {
                            $response['message'] = "query 5 didn't work" . mysql_error();
                            die(json_encode($response));
                        } else {

                            $petArray     = mysqli_fetch_assoc($petResult);

                            $pet['pet_id']   = $petArray['pet_id'];
                            $pet['name']     = $petArray['name'];
                            $pet['bio']      = $petArray['bio'];
                            $pet['bathroom'] = $petArray['bathroom_instructions'];
                            $pet['exercise'] = $petArray['exercise_instructions'];
                            $pet['food']     = $petArray['food'];
                            $pet['emergency'] = $petArray['emergency_contact'];
                            $pet['other']    = $petArray['other'];
                            $pet['medicine'] = $petArray['medicine'];
                            $pet['vet']      = $petArray['veterinarian_info'];
                            $response['status'] = 'ok';
                            $sittingPets[$counter] = $pet;
                            $response['mine_sitting'] = $sittingPets;
                            $counter++;
                        }
                    }
                    print json_encode($response);
                } else {
                    $response['message'] = "User's pets aren't being sit";
                }
            
        }
    }
        
        
    $mysqli->close();
    print json_encode($response);
        
    } else {
        print "must set 'owner_id'";
    }

?>