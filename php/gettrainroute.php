<?php

function gettrainroute($train_no)
{
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
        CURLOPT_POSTFIELDS => 'p_name=test&train_no='.$train_no,
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

        $stations = array();

        foreach ($routes as $route) {
            $stations[$route['no']] = $route['station']['name'];
        }

        return json_encode($stations, JSON_PRETTY_PRINT);
    }
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $train_no = $_POST['train_no'];
    echo gettrainroute($train_no);
} else {
    echo gettrainroute(12345);
}

?>