<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['owner_id'])){
        
        $owner_id = htmlspecialchars($_POST['owner_id']);
        
        //Find if any pets are owned
        
        $sql="select * from owner where owner_id = '" . $owner_id . "';";
        
        $result = mysqli_query($mysqli,$sql);

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
                        
                        $petArray     = $petResult->fetch_row();

                        $pet['pet_id']   = $petArray[0];
                        $pet['name']     = $petArray[1];
                        $pet['bio']      = $petArray[2];
                        $pet['bathroom'] = $petArray[3];
                        $pet['exercise'] = $petArray[4];
                        $st
                        $pets[$counter] = $pet;
                        $response['owned'] = $pets;
                    }
                }
            } else {
                $response['message'] = "User owns no pets";
            }
            
        }
        
        
        //Find if any pets are being sat on
        
        $sql="select * from pet_sitting where sitter_id = '" . $owner_id . "';";
        
        $result = mysqli_query($mysqli,$sql);

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
                        
                        $petArray     = $petResult->fetch_row();
                        $pet['pet_id']   = $petArray[2];
                        $response['status'] = 'ok';
                        $pets[$counter] = $pet;
                        $response['sitting'] = $pets;
                        $counter++;
                    }
                }
            } else {
                $response['message'] = "User is sitting no pets";
            }
            
        }
        
        
        
    print json_encode($output);
    $mysqli->close();

        
    } else {
        print "must set 'owner_id'";
    }

?>