<?php
    require '/home/robert/config/conn.php';

    if(isset($_POST['owner'])){
        
        $owner_id = htmlspecialchars($_POST['owner']);
        
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

                        $pets[$counter] = $pet;
                        $counter++;
                    }
                }
                print json_encode($pets);
            } else {
                $response['message'] = "User owns no pets";
                print json_encode($response);
            }
            
        }
        
        
    $mysqli->close();

        
    } else {
        print "must set 'owner'";
    }

?>