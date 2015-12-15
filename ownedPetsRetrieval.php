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
                        $pet['hasImage'] = $petArray['hasImage'];
                        $response['status'] = 'ok';
                        $pets[$counter] = $pet;
                        $response['pets'] = $pets;
                        $counter++;
                    }
                }
            } else {
                $response['message'] = "User owns no pets";
            }
            
        }
        
        //selecting pet_sitting instances of pets owned
        
        $counter = 0;
        foreach($coolPets as $coolPetId){
           $sql="select * from pet_sitting where pet_id ='" . $coolPetId . "';";

    //        echo $sql;
            $result = mysqli_query($mysqli,$sql);

            //echo mysql_error();
            if (!$result) {
                $response['message'] = "Query Failed" . mysql_error();
                die(json_encode($response));
            } else {
                $response["status"] = "ok";

                $pet = mysqli_fetch_assoc($result);

                $response['sitter_id']   = $pet['sitter_id'];
                $response['pet_id']      = $pet['pet_id'];
                $response['currentStatus']      = $pet['status'];
                $response['start']       = $pet['start_date'];
                $response['end']         = $pet['end_date'];

                $currentDate = date("Y-m-d H:i:s");

                if($response['start'] < $currentDate && $response['end'] > $currentDate ) {
                    $response['currentStatus'] = 'current';
                } else if ($currentDate < $response['start']){
                    $response['currentStatus'] = 'upcoming';
                } else if ($currentDate > $response['end']){
                    $response['currentStatus'] = 'expired';
                }

                $sql="UPDATE pet_sitting
                  SET status = '"     . $response['currentStatus'] . 
                  "' WHERE pet_sitting_id = '" . $pet['pet_sitting_id'] . "';";

                if (!$result) {
                    $response['status'] = 'bad';
                    $response['message'] = "Status update failed" . mysqli_error();
                    die(json_encode($response));
                } else {
                    $response['status']  = 'ok';
                    $response['message'] = "Status updated";
                }


                print json_encode($response);
            }
//            $sql="select * from pet_sitting where pet_id = '" . $coolPetId . "';";
//
//            $result = mysqli_query($mysqli,$sql);
//
//            if (!$result) {
//                $response['message'] = "selecting from pet_sitting Failed" . mysql_error();
//                die(json_encode($response));
//            } else {
//
//                if($result->num_rows >0){
//                    while($row = mysqli_fetch_assoc($result)){
//
//                        $sql="select * from pet where pet_id = '" . $coolPetId . "';";
//
//                        $petResult = mysqli_query($mysqli,$sql);
//
//                        if (!$petResult) {
//                            $response['message'] = "query 5 didn't work" . mysql_error();
//                            die(json_encode($response));
//                        } else {
//
//                            $petArray     = mysqli_fetch_assoc($petResult);
//
//                            $pet['pet_id']   = $petArray['pet_id'];
//                            $pet['name']     = $petArray['name'];
//                            $pet['bio']      = $petArray['bio'];
//                            $pet['bathroom'] = $petArray['bathroom_instructions'];
//                            $pet['exercise'] = $petArray['exercise_instructions'];
//                            $pet['food']     = $petArray['food'];
//                            $pet['emergency'] = $petArray['emergency_contact'];
//                            $pet['other']    = $petArray['other'];
//                            $pet['medicine'] = $petArray['medicine'];
//                            $pet['vet']      = $petArray['veterinarian_info'];
//                            $pet['hasImage'] = $petArray['hasImage'];
//                            $response['status'] = 'ok';
//                            $sittingPets[$counter] = $pet;
//                            $response['mine_sitting'] = $sittingPets;
//                            $counter++;
//                        }
//                    }
//                } else {
//                    $response['message'] = "User's pets aren't being sit";
//                }
            
        }
        
        
    $mysqli->close();
    print json_encode($response);
        
    } else {
        print "must set 'owner_id'";
    }

?>