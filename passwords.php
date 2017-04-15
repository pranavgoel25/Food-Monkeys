<!-- PHP api manaegs passwords -->

<?php 

function verify_user($phone,$pass)
{
   $link = mysqli_connect('localhost', 'root', 'gotham', 'test_db');

    if ($link === false) {
        die('ERROR: Could not connect. '.mysqli_connect_error());
    }

    $password = md5($pass);

   
    $sql = "SELECT * FROM omitrausers WHERE phone ='".$phone."' AND password ='" .$password ."'; ";

    $result = $link->query($sql);

    $num_rows = mysqli_num_rows($result);

    mysqli_close($link);

    return $num_rows;
}

function verify_username($phone)
{
   $link = mysqli_connect('localhost', 'root', 'gotham', 'test_db');

    if ($link === false) {
        die('ERROR: Could not connect. '.mysqli_connect_error());
    }

    $password = md5($pass);

    
    $sql = "SELECT * FROM omitrausers WHERE phone ='".$phone."'; ";

    $result = $link->query($sql);

    $num_rows = mysqli_num_rows($result);

    mysqli_close($link);

    return $num_rows;
}

function check_logged(){ 
     global $_SESSION, $USERS; 
	if (!verify_username($_SESSION['logged']))
 	{
          header("Location: login.php"); 
    }; 
};

?>