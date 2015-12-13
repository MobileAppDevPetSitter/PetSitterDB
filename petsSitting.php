<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';

    if(isset($_POST['owner_id'])){
        
        $owner_id = htmlspecialchars($_POST['owner_id']);
        
        $sql="select pet_id from pet_sitting where sitter_id = '" . $owner_id."';";
        
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
                        $response['status'] = 'ok';
                        $pets[$counter] = $pet;
                        $response['pets'] = $pets;
                        $counter++;
                    }
                }
                print json_encode($response);
            } else {
                $response['message'] = "User is sitting no pets";
                print json_encode($response);
            }
            
        }
        
        
    $mysqli->close();
        
    } else {
        print "must set 'owner_id'";
    }
?>