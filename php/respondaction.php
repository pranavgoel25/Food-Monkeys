<?php

error_reporting(E_ALL);
ini_set('display_errors', 1);

function test_input($data)
{
    $data = trim($data);
    $data = stripslashes($data);
    $data = htmlspecialchars($data);

    return $data;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {

    $link = new mysqli('localhost', 'root', 'gotham', 'test_db');

    $id = $_POST['id'];
    $requestid = test_input($_POST['requestid']);

    $sql1 = 'SELECT * FROM omitrausers WHERE phone ='. $id .'; ';
    $result1 = $link->query($sql1);
    $myrow = mysqli_fetch_assoc($result1);
    $useridfromid = $myrow['id'];
    $uname = $myrow['name'];
    $email = $myrow['email'];
    $phone = $myrow['phone'];

    echo "<h1>Here is".$uname ;
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

        $url = './mail.php';

        $data = array('semail' => $email, 'sphone' => $phone, 'sname' => $uname, 'reqid' => $requestid, 'Submit' => '1');

        $postData = '';
        foreach ($data as $key => $val) {
            $postData .= $key.'='.$val.'&';
        }
        $postData = rtrim($postData, '&');

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_COOKIEJAR, 'FileHere');
        curl_setopt($ch, CURLOPT_COOKIEFILE, 'FileHere');
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_PROTOCOLS, CURLPROTO_HTTP);
        $data = curl_exec($ch);

        curl_close($ch);

        $link = new mysqli('localhost', 'root', 'gotham', 'test_db');

        if ($link->connect_error) {
            die('ERROR: Could not connect. '.$link->connect_error);
        }

        $stmt = $link->prepare('INSERT INTO omitraresponse (userid,requestid) VALUES (?,?)');
        $stmt->bind_param('ii', $useridfromid, $requestid);

        if ($stmt->execute()) {
            // echo '<h1>Records added successfully.</h1><br/>';
            // echo '<h2>Please wait you will be redirected to Main Home</h2><br/>';
            //header('Refresh: 5;url=home.html');
        } else {
            echo '<h3>ERROR: Please TRY Again Later</h3>';
            // die(mysqli_error());
            echo $stmt->error;
        }

        $stmt->close();
        $link->close();

        echo '</body></html>';
        
}
?>