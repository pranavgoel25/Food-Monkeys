<?php
// error_reporting(E_ALL | E_STRICT);
// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);
$uname = $train = $phone = $sdes = $edes = $sdate =$edate = $correct = $email = '';
$unameErr = $trainErr = $phoneErr = $sdesErr = $edesErr = $sdateErr= $edateErr = $emailErr = $correctErr = '';
function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}
function valTrain()
{
    global $train, $trainErr;
    if (empty($_POST['train'])) {
        $trainErr = 'Please input train name';
    } else {
        $train = test_input($_POST['train']);
    }
}
function valSdate()
{
    global $sdate, $sdateErr;
    if (empty($_POST['sdate'])) {
        $sdateErr = 'Start date is required';
    } else {
        $sdate = test_input($_POST['sdate']);
        list($dd, $mm, $yyyy) = explode('-', $sdate);
        if (!checkdate($mm, $dd, $yyyy)) {
            $sdateErr = 'Please enter a valid start date';
        } else {
            $sdate = $yyyy.'-'.$mm.'-'.$dd;
        }
    }
}
function valEdate()
{
    global $edate, $edateErr, $sdate;
    if (empty($_POST['edate'])) {
        $edateErr = 'End date is required';
    } else {
        $edate = test_input($_POST['edate']);
        list($dd, $mm, $yyyy) = explode('-', $edate);
        if (!checkdate($mm, $dd, $yyyy)) {
            $edateErr = 'Please enter a valid end  date';
        } else {
            $edate = $yyyy.'-'.$mm.'-'.$dd;
            if ($edate <= $sdate) {
                $edateErr = 'Please enter a date later than start date';
            }
        }
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $which = $_POST['which'];
    if ($which == 'trainErr') {
        valTrain();
    } elseif ($which == 'sdateErr') {
        valSdate();
    } elseif ($which == 'edateErr') {
        valEdate();
    }
    echo $$which;
    if ($which == 'correct') {
        valSdate();
        valTrain();
        valEdate();
        $edes = test_input($_POST['edes']);
        $sdes = test_input($_POST['sdes']);

   $link = mysqli_connect('localhost', 'root', 'gotham', 'test_db');

    if ($link === false) {
        die('ERROR: Could not connect. '.mysqli_connect_error());
    }

    // $sql = "SELECT * FROM omitratest WHERE edes ='".$edes."'; ";
    
    $sql = "SELECT * FROM omitrausers WHERE phone ='".$_POST['id']."'; ";

    $result = $link->query($sql);

    $num_rows = mysqli_num_rows($result);

    mysqli_close($link);

    $row = mysqli_fetch_assoc($result);

    $userid = $row['id'];
    
       echo '<html>

            <head>
            <title>Main</title>

            <meta name="viewport" content="width=device-width, initial-scale=1">
            <link href="css/icon.css" rel="stylesheet">
            <link type="text/css" rel="stylesheet" href="css/materialize.min.css">
            <script type="text/javascript" src="js/jquery-2.1.1.min.js"></script>
            <script type="text/javascript" src="js/materialize.js"></script>

            </head>

            <body>

              <div class="preloader-wrapper big active center" style="top:46%;left:46%;">
                    <div class="spinner-layer spinner-blue-only">
                      <div class="circle-clipper left">
                        <div class="circle"></div>
                      </div><div class="gap-patch">
                        <div class="circle"></div>
                      </div><div class="circle-clipper right">
                        <div class="circle"></div>
                      </div>
                    </div>
                  </div>
                  ';        

        $link = new mysqli('localhost', 'root', 'gotham', 'test_db');

        if ($link->connect_error) {
            die('ERROR: Could not connect. '.$link->connect_error);
        }

        $stmt = $link->prepare('INSERT INTO omitratravellertest (userid , train, sdes, edes, sdate , edate) VALUES (?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('isssss', $userid, $train, $sdes, $edes, $sdate ,$edate);

        if ($stmt->execute()) {
            // echo '<h1>Records added successfully.</h1><br/>';
            // echo '<h2>Please wait you will be redirected to Main Home</h2><br/>';
        } else {
            echo 'ERROR: Unable to add ';
        }
        $stmt->close();
        $link->close();
        echo '</body></html>';
    }
}
