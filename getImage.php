<?php
    if(isset($_POST['type']) && isset($_POST['id'])){
        
        // This script returns an image that is requested using the photo
        // url parameter.  Example request to retrieve Photo30.jpg
        // getimage.php?photo=Photo30.jpg
        // If the image file isn't found, or specified, a default image
        // is returned that indicates the image was not found.

        // The script should check credentials sent in POST data to provide
        // protected access to the images.  I don't do that here.
        // This example is just to show how to return an image through a PHP script.

        // directory holding the images
        $sourceDirectory = '/home/robert/pics';
        // an image to send if requested one isn't available
        $defaultImagePath = 'imagenotfound.png';  

        $fileName = htmlspecialchars($_POST['id']);
        $dir = htmlspecialchars($_POST['type']);
        $sourceFilePath = $sourceDirectory . '/' . $dir . '/' . $fileName;

        // If the requested file doesn't exist, use the default image
        if (!file_exists($sourceFilePath)) {
            $sourceFilePath = $defaultImagePath;
        }

        $check = getimagesize($sourceFilePath);
        if ($check !== false) {
            // it is an image and it has a mime-type
            // get the mime type so it can be used to set the Content-type below
            $fileMimeType = $check['mime'];
        } else {
            // it is not an image, so use default image
                        die(json_encode("couldn't get image size"));
            $sourceFilePath = $defaultImagePath;
            $fileMimeType = 'image/png';  // I know this since I am providing the  default image
        }

        header('Content-Type: ' . $fileMimeType);

        $file = fopen($sourceFilePath, "r") or die("Unable to open file!");
        print fread($file,filesize($sourceFilePath));
        fclose($file);
    } else {
        $response['message'] = "must set 'type', and 'id'";
    }
?>
