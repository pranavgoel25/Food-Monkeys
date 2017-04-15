<?php

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    $name = $_REQUEST['tname'];
    $from = $_REQUEST['sdes'];
    $to = $_REQUEST['edes'];

    // getting route 
    
    $proxy = 'proxy.iiit.ac.in:8080';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.omitra.in/pnrjourney/gettrainroute',
       CURLOPT_PROXY => $proxy,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'p_name=test&train_no='.$name,
        CURLOPT_HTTPHEADER => array(
            'cache-control: no-cache',
            'content-type: application/x-www-form-urlencoded',
            'postman-token: dfb720f7-8ed1-d59e-28a1-66e8c89a21bc',
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo 'cURL Error #:'.$err;
    } else {
        $json_a = json_decode($response, true);

        $routes = $json_a['train_route']['train']['route'];

        // print json_encode($routes,true);

        $stationsinroute = array();
        $flag = 1;
        foreach ($routes as $route) {
            if ( strcmp($route['station']['name'],strtoupper($from)) == 0 )
            {
                array_push($stationsinroute,$route['station']['name']);
                $flag = 0;
                // echo $stations;
            }
            if ($flag == 1)
                array_push($stationsinroute,$route['station']['name']);
            if ( strcmp($route['station']['name'],strtoupper($to)) == 0 )
            {
                // echo $stations;
                array_push($stationsinroute,$route['station']['name']);
                $flag = 1;
            }
        }

        // echo json_encode($stationsinroute, JSON_PRETTY_PRINT);
    }

    // stationsinroute extracted

    $link = mysqli_connect('localhost', 'root', 'gotham', 'test_db');

        if ($link === false) {
            die('ERROR: Could not connect. '.mysqli_connect_error());
        }

        $sql = "SELECT * FROM omitratravellertest WHERE train ='".$name."'; ";

        // echo $sql;
        $result = $link->query($sql);

        $rows = array();
        while ($r = mysqli_fetch_assoc($result)) {

                // print_r($r);
                if (in_array($r['sdes'],$stationsinroute) AND in_array($r['edes'],$stationsinroute))
                {
                        $sql1 = 'SELECT * FROM omitrausers WHERE id ='.$r['userid'].'; ';
                        $result1 = $link->query($sql1);
                        $myrow = mysqli_fetch_assoc($result1);
                        $r['name'] = $myrow['name'];
                        $r['phone'] = $myrow['phone'];
                        $r['email'] = $myrow['email'];
                    $rows[] = $r;
                }
        }

        mysqli_close($link);

        echo json_encode($rows);


}

?>