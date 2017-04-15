<?php
    $edes = "Pune";
    function getbystation($sdes,$edes)
    {

    $link = mysqli_connect('localhost', 'root', 'gotham', 'test_db');

    if ($link === false) {
        die('ERROR: Could not connect. '.mysqli_connect_error());
    }

    // $sql = "SELECT * FROM omitratest WHERE edes ='".$edes."'; ";
    
    $sql = "SELECT * FROM omitratest WHERE edes ='".$edes."'; ";


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
        
            $sql1 = 'SELECT * FROM omitrausers WHERE id ='.$r['userid'].'; ';
            $result1 = $link->query($sql1);
            $myrow = mysqli_fetch_assoc($result1);
            $r['name'] = $myrow['name'];
            $r['phone'] = $myrow['phone'];
            $r['email'] = $myrow['email'];

            // print_r($r);

            $rows[] = $r;
    }

    mysqli_close($link);

    echo json_encode($rows);


    }

    if ($_SERVER['REQUEST_METHOD'] == 'POST')
    {
        $edes = $_POST['edes'];
        $sdes = $_POST['sdes'];
        echo getbystation($sdes,$edes);
    } else {
        echo getbystation("Pune","Pune");
    }


?>