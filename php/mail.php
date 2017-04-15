<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $temail = $_POST['semail'];
    $tphone = $_POST['sphone'];
    $tname = $_POST['sname'];
    $reqid = $_POST['reqid'];

    $link = new mysqli('localhost', 'root', 'gotham', 'test_db');

    $sql = 'SELECT * FROM omitratest where id ='.$reqid . ';';

    $result = $link->query($sql);
    $r = mysqli_fetch_assoc($result);
    $ruserid = $r['userid'];

    $rtrain = $r['train'];
    $reason = $r['reason'];

    $sql1 = 'SELECT * FROM omitrausers WHERE id ='. $ruserid.'; ';
    $result1 = $link->query($sql1);
    $myrow = mysqli_fetch_assoc($result1);
    $rname = $myrow['name'];
    $rphone = $myrow['phone'];
    $remail = $myrow['email'];


    mysqli_close($link);

    $image = 'https://image4.owler.com/logo/omitra_owler_20160228_133224_original.png';

    $to = $remail;
    $subject = 'A fellow Traveller is interested in your request';

    $message = '
    <html>
    <head>
    <title>Request Accepted</title>
    </head>
    <body>
    <img src=' .$image.'>
    <p>Hello '.$rname.', Greetings from OMitra.</p>
    <h2>Your Request Details :</h2>
    <ul>
    <li> Reason : '.$reason.'</li>
    <li>Train : '.$rtrain.'</li>
    </ul>
    <h2>Has been accepted by a Traveller :</h2>
    <ul>
    <li>Name :'.$tname.'</li>
    <li>Phone :'.$tphone.'</li>
    <li>Email :'.$temail.'</li>
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

?>