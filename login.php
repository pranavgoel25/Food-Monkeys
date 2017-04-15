<!-- Main Login Page -->

<!DOCTYPE html>
<html>

<head>
    <title>Main</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/icon.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css">
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>

    <script>
        $(function() {
            $('#navbar').load('nav.php');
        });
    </script>

</head>

<body>

    <div id="navbar"></div>

<div class="container">
<?php 
session_start(); 
include("passwords.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST['ac'] == 'log')
	{

    $phone = $_POST['phone'];
    $pass = $_POST['password'];

    if (verify_user($phone,$pass))
    	$_SESSION['logged']=$phone;
    echo 'Got ' . $phone . ' and ' . $pass;
	}
	else if ($_POST['ac'] == 'logout')
	{
		unset($_SESSION['logged']);
		header("Location: home.html"); 
		echo "Logout Successful ! ";
	}
}


if (verify_username($_SESSION['logged']))
{	
	header("Location: home.html"); 
}
else
{
	echo "<script>
        $(function() {
            Materialize.toast('You are not logged in ! :P', 4000);
        });
    </script>";
	echo '<h1 class="center">Login</h1>
	<form method="post" action="login.php">
		<input type="hidden" name="ac" value="log">

	                <div class="row">
                    <div class="input-field col s12">
                    	<input type="tel" id="phone" name="phone"><br><br>
                        <label for="phone">Phone No. </label>
                    </div>
                </div>

                <div class="row">
                    <div class="input-field col s12">
						<input id="password" type="password" name="password"><br><br>
                        <label for="password">Password </label>
                    </div>
                </div>

	<input type="submit" class="waves-effect waves-light btn-large" value="Login"><br>
	</form>';
	echo '<br><h4>New User?</h4><a href="newuser.html">Register Here</a>';
}
?>
</div>

    <script>
        $(document).ready(function() {
            $('.slider').slider({
                full_width: true
            });
        });
    </script>
    <br>
    <br>
    <br>
    <br>
    <div id="footer"></div>

</body>
<script type="text/javascript">
    $(function() {
        $('#footer').load('foot.html');
    });
</script>

</html>