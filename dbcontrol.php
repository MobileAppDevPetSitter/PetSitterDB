<html>
<head>
    <title>DB Interface</title>
</head>
<script>
    
</script>
<body>
    
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
        <label for='email' >Email to delete: </label>
        <input type='text' class="form-control" name='email' id='email' required/> 
        <input type='submit' class="btn" name='action' value='Delete' />
    </form>
    
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
        <label for='email' >Email to show: </label>
        <input type='text' class="form-control" name='email' id='email' required/> 
        <input type='submit' class="btn" name='action' value='Show' />
    </form>

    
</body>
    
    <?php
    
        require '/home/robert/config/conn.php';
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    

        if(isset($_POST['action'])){
            
            $action = isset($_POST['action']) ? $_POST['action'] : null;
            
            switch($action){
                case 'Delete':
                    $email = htmlspecialchars($_POST['email']);

                    $sql="DELETE FROM user WHERE email = '" . $email . "';";

                    //echo $sql;
                    $result = mysqli_query($mysqli,$sql);

                    //echo mysql_error();
                    if (!$result) {
                        $response['message'] = "SQL Failed";
                        die(json_encode($response));
                    } 
                    break;
                case 'Show':
                    $email = htmlspecialchars($_POST['email']);
            
                    $sql="SELECT * FROM user WHERE email = '" . $email . "';";

                    //echo $sql;
                    $result = mysqli_query($mysqli,$sql);

                    //echo mysql_error();
                    if (!$result) {
                        $response['message'] = "SQL Failed";
                    } else {
                        while($row = $result->fetch_array())
                          {
                          echo "User ID: " . $row['user_id'] . "<br />Email: " . $row['email'] . "<br />Status: " . $row['status'] . "<br />Verification Code: " . $row['verification_code'];
                          echo "<br />";
                          }
                    }
                    break;
                default:
                    //action not found
                    break;
            }
            
            
        }



    ?>
    
    

</html>