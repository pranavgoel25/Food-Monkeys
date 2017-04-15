<?php

$link = mysqli_connect('localhost', 'root', 'gotham', 'test_db');

if ($link === false) {
    die('ERROR: Could not connect. '.mysqli_connect_error());
}

$sql = 'SELECT * FROM omitratravellertest';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_REQUEST['tname'];
    if (strcmp($name, 'seeall') == 0) {
        $sql = 'SELECT * FROM omitratravellertest';
    } else {
        $sql = "SELECT * FROM omitratravellertest WHERE train ='$name'; ";
    }
}

$result = $link->query($sql);

$rows = array();
while ($r = mysqli_fetch_assoc($result)) {

        // print_r($r);
	$sql1 = 'SELECT * FROM omitrausers WHERE id ='.$r['userid'].'; ';
    $result1 = $link->query($sql1);
    $myrow = mysqli_fetch_assoc($result1);
    $r['name'] = $myrow['name'];
    $r['phone'] = $myrow['phone'];
    $r['email'] = $myrow['email'];

        $rows[] = $r;
}

echo json_encode($rows);

mysqli_close($link);

?>