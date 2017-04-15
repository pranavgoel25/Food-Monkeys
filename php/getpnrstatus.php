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
        $stations['status'] = $status;
       // echo $response;

        return json_encode($stations, JSON_PRETTY_PRINT);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $pnr_no = $_POST['pnr_no'];
    echo getpnrstatus($pnr_no);
} else {
    echo getpnrstatus(2703555439);
}

?>