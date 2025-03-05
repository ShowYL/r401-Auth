<?php

function deliverResponse($status_code, $status_message, $data=null){

    http_response_code($status_code);
    header('Content-Type:application/json; charset=utf-8');
    header('Access-Control-Allow-Origin: *');
    header('Access-Control-Allow-Headers: Content-Type, Authorization');

    $response['status_code'] = $status_code;
    $response['status'] = $status_message;
    $response['data'] = $data;

    $json_response = json_encode($response);
    if ($json_response === false){
        die('json encode ERROR : '.json_last_error_msg());
    }

    echo $json_response;
}

?>