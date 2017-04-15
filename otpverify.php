<!-- OTP verification Page -->

<?php 
session_start(); /// initialize session 
/// function checks if visitor is logged. 
// If user is not logged the user is redirected to login.php page  
?>


<?php


$start = '<!DOCTYPE html>
<html>

<head>
    <title>New User</title>

    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="css/icon.css" rel="stylesheet">
    <link type="text/css" rel="stylesheet" href="css/materialize.min.css">
    <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
    <script type="text/javascript" src="js/materialize.js"></script>

    <script>
        $(function() {
            $("#navbar").load("nav.php");
        });
    </script>

</head>

<body>

    <div id="navbar"></div>
    <div class="container">';

$end = '
</div>
    <br>
    <div id="footer"></div>

</body>
<script type="text/javascript">
    $(function() {
        $("#footer").load("foot.html");
    });
</script>

</html>
';

include("otpgen.php"); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    if ($_POST['ac'] == 'phonein')
    {
            $phone = $_POST['phone'];

    $dig1 = rand(1,9);
    $dig2 = rand(1,9);
    $dig3 = rand(1,9);
    $dig4 = rand(1,9);

    $OTPgen = $dig1 . $dig2 . $dig3 . $dig4 ;


    echo $start;
    $message = "Hello OMitra User, Your OTP generated  is - " . $OTPgen . ".";

    $out = exec("python sms.py 91$phone '$message' /tmp/ 2>&1");

    $_SESSION['otpgen'] = 1 ;
    $_SESSION['otpgenerated'] = $OTPgen;

        $_SESSION['verifed'] = 0;

        echo "<h2>An OTP has been sent to your mobile</h2>";
        echo "<h2>Enter the OTP received:</h2>";
        echo "<form method='post' action='otpverify.php'>";
        echo '<input type="hidden" name="ac" value="OTPin">';
        echo "<input type='text' name='OTP'>";
        echo "<input type='submit' class='btn btn-large'>
        </form>";

        echo "<form method='post' action='otpverify.php'>";
        echo '<input type="hidden" name="ac" value="retry"><br>';
        echo "<input type='submit' class='btn btn-large' value='Retry'>
        </form>";
        echo $end;
    }

    else if ($_POST['ac'] == 'OTPin')
    {
        $OTPrev = $_POST['OTP'];

        if ($OTPrev == $_SESSION['otpgenerated'])
        {
                echo $start;

            echo "Successfully Verified!";
            $_SESSION['verifed'] = 1;
                    echo $end;

        }
        else
        {
                echo $start;

            echo "<h1>Wrong OTP Entered , Retry.";
            echo "<h2>An OTP has been sent to your mobile</h2>";
            echo "<h2>Enter the OTP received:</h2>";
            echo "<form method='post' action='otpverify.php'>";
            echo '<input type="hidden" name="ac" value="OTPin">';
            echo "<input type='text' name='OTP'>";
            echo "<input type='submit' class='btn btn-large'>
            </form>";

        echo "<form method='post' action='otpverify.php'>";
        echo '<input type="hidden" name="ac" value="retry"><br>';
        echo "<input type='submit' class='btn btn-large' value='Retry'>
        </form>";
        echo $end;

        }
    }

    else if ($_POST['ac'] == 'retry')
    {
        unset($_SESSION['otpgen']);
        unset($_SESSION['verifed']);
        unset($_SESSION['otpgenerated']);
        header("Location: otpverify.php"); 
    }


}

else
{

    if (!$_SESSION['otpgen'])
    {

                echo $start;

        echo "<h2>Enter your phone number:</h2>";
        echo "<form method='post' action='otpverify.php'>";
        echo '<input type="hidden" name="ac" value="phonein">';
        echo "<input type='tel' name='phone'>";
        echo "<input type='submit' class='btn btn-large'>
        </form>";
                echo $end;

    }
    else
    {
        if (!$_SESSION['verifed'])
        {
                            echo $start;

        echo "<h2>An OTP has been sent to your mobile</h2>";
        echo "<h2>Enter the OTP received:</h2>";
        echo "<form method='post' action='otpverify.php'>";
        echo '<input type="hidden" name="ac" value="OTPin">';
        echo "<input type='text' name='OTP'>";
        echo "<input type='submit' class='btn btn-large'>
        </form>";


        echo "<form method='post' action='otpverify.php'>";
        echo '<input type="hidden" name="ac" value="retry"><br>';
        echo "<input type='submit' class='btn btn-large' value='Retry'>
        </form>";
                echo $end;

        }
        else
        {
                            echo $start;

            echo "Already Verified!";
                    echo "<form method='post' action='otpverify.php'>";
        echo '<input type="hidden" name="ac" value="retry"><br>';
        echo "<input type='submit' class='btn btn-large' value='Retry'>
        </form>";
                echo $end;

        }
    }

}


?>