<?php
    require '/home/robert/config/conn.php';

    if(isset($_POST['sitter_id']) && isset($_POST['pet_id']) && isset($_POST['start_date']) && isset($_POST['end_date'])){
        
        $sitter      = htmlspecialchars($_POST['sitter_id']);                
        $pet         = htmlspecialchars($_POST['pet_id']);
        $start       = htmlspecialchars($_POST['start_date']);
        $end         = htmlspecialchars($_POST['end_date']);

        // Check for email query
        $sql="INSERT into pet_sitting (sitter_id,pet_id,status,start_date,end_date) 
              VALUES ('" . $sitter . "','" . $pet . "','open','" . $start . "','" . $end . "');";

        echo $sql;
        $result = mysqli_query($mysqli,$sql);
        $response['status'] = "bad";
        //echo mysql_error();
        if (!$result) {
            $response['message'] = "Query Failed" . mysqli_error();
            die(json_encode($response));
        } else {
            
            $response['message'] = "Sitting instance created";
            $response['status']  = "ok";
            print json_encode($response);
        }
        
    } else {
        
        print "Must set 'sitter_id','pet_id','start_date','end_date'";
        
    }


    $mysqli->close();

?>