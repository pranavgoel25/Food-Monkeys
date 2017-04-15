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

    echo '</body></html>';

    $id = $_POST['id'];

    $link = new mysqli('localhost', 'root', 'gotham', 'test_db');

    $sql1 = 'SELECT * FROM omitrausers WHERE phone ='. $id .'; ';
    $result1 = $link->query($sql1);
    $myrow = mysqli_fetch_assoc($result1);
    $uname = $myrow['name'];
    $email = $myrow['email'];
    $phone = $myrow['phone'];

    $sql = 'SELECT * FROM omitratravellertest where id ='.$_POST['traid'];

    $result = $link->query($sql);
    $r = mysqli_fetch_assoc($result);

    $ruserid = $r['userid'];
    $rtrain = $r['train'];


    $sql1 = 'SELECT * FROM omitrausers WHERE id ='. $ruserid.'; ';
    $result1 = $link->query($sql1);
    $myrow = mysqli_fetch_assoc($result1);
    $rname = $myrow['name'];
    $remail = $myrow['email'];

    mysqli_close($link);

    $image = 'https://image4.owler.com/logo/omitra_owler_20160228_133224_original.png';

    $to = $remail;
    $subject = 'A Request to be fullfilled in your train journey';

    $message = '
    <html>
    <head>
    <title>Request Accepted</title>
    </head>
    <body>
    <img src=' .$image.'>
    <p>Hello '.$rname.', Greetings from OMitra.</p>
    <h2>You in your train journey :</h2>
    <ul>
    <li>Train : '.$rtrain.'</li>
    </ul>
    <h2>Has been requested by a User :</h2>
    <ul>
    <li>Name :'.$uname.'</li>
    <li>Phone :'.$phone.'</li>
    <li>Email :'.$email.'</li>
    </ul>
    <p>Contact him by above details.</p>
    <p>Thank you for using OMitra .</p>
    </body>
    </html>
    ';

    // Always set content-type when sending HTML email
    $headers = 'MIME-Version: 1.0'."\r\n";
    $headers .= 'Content-type:text/html;charset=UTF-8'."\r\n";

    mail($to, $subject, $message, $headers);

    }
}

?>