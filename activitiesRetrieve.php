<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['pet_sitting_id'])){
        
        $pet_sitting_id = htmlspecialchars($_POST['pet_sitting_id']);
        
        $sql="select * from activity where pet_sitting_id = '" . $pet_sitting_id . "';";
        
        $result = mysqli_query($mysqli,$sql);

        //select pets owned
        
        if (!$result) {
            $response['message'] = "Query Failed" . mysql_error();
            die(json_encode($response));
        } else {
            
            if($result->num_rows >0){
                $counter = 0;
                while($row = mysqli_fetch_assoc($result)){
                        $response['status'] = 'ok';
                        $activities[$counter] = $activity;
                        $response['activities'] = $activities;
                        $counter++;
                }
            } else {
                $response['message'] = "Instance has no activities";
            }
            
        }
        
        
    $mysqli->close();
    print json_encode($response);
        
    } else {
        print "must set 'pet_sitting_id'";
    }

?>