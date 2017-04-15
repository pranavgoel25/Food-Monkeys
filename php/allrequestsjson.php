<?php

$link = mysqli_connect('localhost', 'root', 'baks123', 'test_db');

if ($link === false) {
    die('ERROR: Could not connect. '.mysqli_connect_error());
}

$sql = 'SELECT * FROM omitratest';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_REQUEST['tname'];
    if (strcmp($name, 'seeall') == 0) {
        $sql = 'SELECT * FROM omitratest';
    } else {
        $sql = "SELECT * FROM omitratest WHERE train ='$name'; ";
    }
}

$result = $link->query($sql);

$rows = array();
while ($r = mysqli_fetch_assoc($result)) {
    $sql1 = 'SELECT * FROM omitraresponse WHERE requestid ='.$r['id'].'; ';

    $result1 = $link->query($sql1);

    $num_rows1 = mysqli_num_rows($result1);

    $status = 'Ongoing';
    if ($num_rows1 == 0) {
        $status = 'Idle';
    }

    // $r += ("status" => "yes");
    // print json_encode($r);

    $r['status'] = $status;

    // print_r($r);

    $sql1 = 'SELECT * FROM omitrausers WHERE id ='.$r['userid'].'; ';
    $result1 = $link->query($sql1);
    $myrow = mysqli_fetch_assoc($result1);
    $r['name'] = $myrow['name'];
    $r['phone'] = $myrow['phone'];
    $r['email'] = $myrow['email'];
    // echo $r['userid'];
    $rows[] = $r;
}

echo json_encode($rows);
mysqli_close($link);

?>
