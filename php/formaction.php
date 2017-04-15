<?php
// error_reporting(E_ALL | E_STRICT);
// ini_set('display_startup_errors', 1);
// ini_set('display_errors', 1);

$train = $sdate = $edate = $reason = $sdes = $edes = $correct = '';
$trainErr = $sdateErr = $edateErr = $reasonErr = $sdesErr = $edesErr = $correctErr = '';
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
        $currdate = date("Y-m-d");
        if (!checkdate($mm, $dd, $yyyy)) {
            $sdateErr = 'Please enter a valid start date';
        } else {
            $sdate = $yyyy.'-'.$mm.'-'.$dd;
            if($sdate<=$currdate) {
                $sdateErr = "Please enter a date later than today's date";
            }
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
function valReason()
{
    global $reason, $reasonErr;
    if (empty($_POST['reason'])) {
        $reasonErr = 'Please give a reason';
    } else {
        $reason = test_input($_POST['reason']);
    }
}
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $which = $_POST['which'];
    if ($which == 'trainErr') {
        valTrain();
    } elseif ($which == 'sdateErr') {
        valSdate();
    } elseif ($which == 'edateErr') {
        valSdate();
        valEdate();
    } elseif ($which == 'reasonErr') {
        valReason();
    }
    echo $$which;
    if ($which == 'correct') {
        valTrain();
        valSdate();
        valEdate();
        valReason();
        $edes = test_input($_POST['edes']);
        $sdes = test_input($_POST['sdes']);
        $type = test_input($_POST['type']);
        $weight = test_input($_POST['weight']);

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

   $link = mysqli_connect('localhost', 'root', 'baks123', 'test_db');

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

        $link = new mysqli('localhost', 'root', 'baks123', 'test_db');

        if ($link->connect_error) {
            die('ERROR: Could not connect. '.$link->connect_error);
        }

        $stmt = $link->prepare('INSERT INTO omitratest (userid, train, sdate, edate, reason, sdes, edes, type, weight) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)');
        $stmt->bind_param('issssssss',$userid, $train, $sdate, $edate, $reason, $sdes, $edes, $type, $weight);

        if ($stmt->execute()) {
            // echo '<h1>Records added successfully.</h1><br/>';
            // echo '<h2>Please wait you will be redirected to Main Home</h2><br/>';
        } else {
            echo '<h3>ERROR: Please TRY Again Later</h3>';
        }
        $stmt->close();
        $link->close();

        echo '</body></html>';
    }
}

?>
