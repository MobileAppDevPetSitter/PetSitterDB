<?php
    $response['status'] = 'bad';
    if(isset($_POST['type']) && isset($_POST['id'])){
        header('Content-Type: application/json');
        // response from this script is going to be JSON

        // http://stackoverflow.com/questions/26335656/how-to-upload-images-to-a-server-in-ios-with-swift
        // http://www.w3schools.com/php/php_file_upload.asp

        // On the server you must be sure your script has the rights
        // to write a file into $destinationDirectory.


        if($_POST['type'] != 'pet' && $_POST['type'] != 'activity'){
            $response['message'] = "'type' must be set to 'pet' or 'activity'";
            die(json_encode($response));
        }

        $fileFormName = 'file';
        $destinationDirectory = "/home/robert/coolsite/test/" . $_POST['type'];

        // The rights you set when you create the directory determine
        // who can write to it and who can read from it.  Be sure you 
        // are setting the rights that are safe and meet your purpose.
        // What you can do depends on how your web server is set up.
        // Don't just copy my code!!!
//        echo $destinationDirectory;
//        echo file_exists($destinationDirectory);
        $response['directory'] = $destinationDirectory;
        $response['fileExists'] = file_exists($destinationDirectory);
        if (!file_exists($destinationDirectory)) {
            mkdir($destinationDirectory, 0755, true);
            echo "hey";
        }

        $tempSourceFilePath = $_FILES[$fileFormName]['tmp_name'];
        $fileName = $_POST['id'];
        $fileExtension = pathinfo($fileName, PATHINFO_EXTENSION);
        $destinationPath = $destinationDirectory . '/' . $fileName;

        // check if file is a real image
        $check = getimagesize($tempSourceFilePath);
        if ($check !== false) {
            // is a real image
            $fileMimeType = $check['mime'];
        } else {
            // is not a real image - send error and exit! - do not copy file
            print json_encode([
                'status' => 'ERROR',
                'message' => $fileName . ' is not an image!'
            ]);
            exit;
        }

        if (empty($_SERVER['HTTPS']) || $_SERVER['HTTPS'] === 'off') {
            $protocol = 'http://';
        } else {
            $protocol = 'https://';
        }
        $baseURL = $protocol . $_SERVER['SERVER_NAME'] . dirname($_SERVER['PHP_SELF']);

        if (move_uploaded_file($tempSourceFilePath, $destinationPath)) {
            print json_encode([
                'status' => 'OK',
                'message' => 'Uploaded ' . $fileName,
                'fileExtension' => $fileExtension,
                'fileMimeType' => $fileMimeType,
                'relativeURL' => $destinationDirectory . '/' . $fileName,
                'URL' => $baseURL . '/' . $destinationDirectory . '/' . $fileName
            ]);
        } else {
            $response['message'] = 'An error occurred uploading ' . $fileName;
            print json_encode($response);
        }
    } else {
        $response['message'] = "must set 'type','id'";
        print json_encode($response);
    }
?>