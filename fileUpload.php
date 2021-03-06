<?php
    require '/home/robert/config/conn.php';
    $response['status'] = 'bad';
    if(isset($_POST['type']) && isset($_POST['id'])){
        header('Content-Type: text/plain');
        // response from this script is going to be JSON
        $type = htmlspecialchars($_POST['type']);

        if($type != 'pet' && $type != 'activity'){
            $response['message'] = "'type' must be set to 'pet' or 'activity'";
            die(json_encode($response));
        }

        $fileFormName = 'file';
        $destinationDirectory = "/home/robert/pics/" . $_POST['type'];
        
        if (!file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
        }

        $tempSourceFilePath = $_FILES[$fileFormName]['tmp_name'];
        $fileName = htmlspecialchars($_POST['id']);
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $destinationPath = $destinationDirectory . '/' . $fileName;

        // check if file is a real image
        $check = getimagesize($tempSourceFilePath);
        if ($check !== false) {
            // is a real image
            $fileMimeType = $check['mime'];
        } else {
            // is not a real image - send error and exit! - do not copy file
            $response['message'] = "Not an image!";
            die(json_encode($response));
        }

        if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
            $protocol = 'http://';
        } else {
            $protocol = 'https://';
        }
        $baseURL = $protocol . $_SERVER['SERVER_NAME'] . '/coolsite/test';
        
        if (move_uploaded_file($tempSourceFilePath, $destinationPath)) {
            $response['message'] = 'Uploaded ' . $fileName . $fileExtension;
            $response['destination'] = $destinationDirectory . '/' . $fileName;
            
            $sql = "Update " . $type . " set hasImage = 1 where " . $type . "_id = '" . $fileName ."';";
            
            $result = mysqli_query($mysqli,$sql);

            //echo mysql_error();
            if (!$result) {
                $response['message'] = "Query Failed" . mysqli_error();
                die(json_encode($response));
            } else {
                $response['status']  = 'ok';
            }
            
            echo $response['status'];
        } else {
            $response['message'] = 'An error occurred uploading ' . $fileName ;
            echo $response['status'];
        }
    } else {
        $response['message'] = "must set 'type','id'";
        echo $response['status'];
    }
?>
