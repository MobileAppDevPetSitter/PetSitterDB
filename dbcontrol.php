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
        <input type='submit' class="btn" name='deleteUser' value='Delete' />
    </form>
    
    <form action="<?= $_SERVER['PHP_SELF'] ?>" method='post'>
        <label for='email' >Email to show: </label>
        <input type='text' class="form-control" name='email' id='email' required/> 
        <input type='submit' class="btn" name='selectUser' value='Show' />
    </form>
    
</body>
    
    <?php
    
        require '/home/robert/config/conn.php';
        ini_set('display_errors', 1);
        ini_set('display_startup_errors', 1);
        error_reporting(E_ALL);
    

        if(isset($_POST['deleteUser'])){
            $email = htmlspecialchars($_POST['email']);
    
            $sql="DELETE FROM user WHERE email = '" . $email . "';";

            //echo $sql;
            $result = mysqli_query($mysqli,$sql);

            //echo mysql_error();
            if (!$result) {
                $response['message'] = "SQL Failed";
                die(json_encode($response));
            }
        }

        if(isset($_POST['showUser'])){
            $email = htmlspecialchars($_POST['email']);
            
            $sql="SELECT * FROM user WHERE email = '" . $email . "';";

            //echo $sql;
            $result = mysqli_query($mysqli,$sql);

            //echo mysql_error();
            if (!$result) {
                $response['message'] = "SQL Failed";
            } else {
                $row = mysql_fetch_row($result); // get the single row.
                echo $row['email'];
            }
                
        }


    ?>
    
    

</html>