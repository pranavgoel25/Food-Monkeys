<?php

function getpnrstatus($pnr_no)
{
    $proxy = 'proxy.iiit.ac.in:8080';

    $curl = curl_init();

    curl_setopt_array($curl, array(
        CURLOPT_URL => 'http://api.omitra.in/pnrjourney/pnrstatus',
       CURLOPT_PROXY => $proxy,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_ENCODING => '',
        CURLOPT_MAXREDIRS => 10,
        CURLOPT_TIMEOUT => 30,
        CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
        CURLOPT_CUSTOMREQUEST => 'POST',
        CURLOPT_POSTFIELDS => 'p_name=test&pnr_no='.$pnr_no,
        CURLOPT_HTTPHEADER => array(
            'cache-control: no-cache',
            'content-type: application/x-www-form-urlencoded',
            'postman-token: 8880d3d5-2df9-9a8b-926c-cc36e41f562c',
        ),
    ));

    $response = curl_exec($curl);
    $err = curl_error($curl);

    curl_close($curl);

    if ($err) {
        echo 'cURL Error #:'.$err;
    } else {
        $json_a = json_decode($response, true);

        $train = $json_a['pnr_status']['train_num'];
        $from = $json_a['pnr_status']['from_station']['name'];
        $to = $json_a['pnr_status']['to_station']['name'];

        $status = $json_a['status_code'];

        $stations = array();

        $stations['train'] = $train;
        $stations['from'] = $from;
        $stations['to'] = $to;
        // echo $response;

        // echo json_encode($stations, JSON_PRETTY_PRINT);
    }

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
        CURLOPT_POSTFIELDS => 'p_name=test&train_no='.$stations['train'],
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
        $flag = 0;
        foreach ($routes as $route) {
            if ( strcmp($route['station']['name'],strtoupper($stations['from'])) == 0 )
            {
                $flag = 1;
                // echo $stations;
            }
            if ($flag == 1)
                array_push($stationsinroute,$route['station']['name']);
            if ( strcmp($route['station']['name'],strtoupper($stations['to'])) == 0 )
            {
                // echo $stations;
                break;
            }
        }

        // echo json_encode($stationsinroute, JSON_PRETTY_PRINT);
    }

    // Here we have , stations => train , from , to
    // stationsinroute extracted

        $link = mysqli_connect('localhost', 'root', 'gotham', 'test_db');

        if ($link === false) {
            die('ERROR: Could not connect. '.mysqli_connect_error());
        }

        $sql = "SELECT * FROM omitratest WHERE train ='".$stations['train']."'; ";

        // echo $sql;
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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pnr_no = $_POST['pnr_no'];
    getpnrstatus($pnr_no);
} else {
    getpnrstatus(2703555439);
}

?>