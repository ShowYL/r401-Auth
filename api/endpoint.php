<?php
require_once '../model/gestionAuth.php';
require_once '../model/utils.php';

const timeExpire = 60 ; # time in second for the JWT token to expire currently 1 minute

header('Content-Type:application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Headers: Content-Type, Authorization');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');

switch ($_SERVER["REQUEST_METHOD"]) {

    case "POST":
        $postedData = file_get_contents("php://input");
        $data = json_decode($postedData, true);
        if (isset($data["username"]) && isset($data["password"])) {
            $username = $data["username"];
            $password = $data["password"];
            if (getUser($username, $password)) {
                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                $payload = array('login' => $username, 'role' => getRole($username), 'exp' => time() + timeExpire);
                $jwt = generate_jwt($headers, $payload);
                deliverResponse(200, "User identified successfully", data: $jwt);
            } else {
                deliverResponse(400, "Error wrong credential");
            }
        } else {
            deliverResponse(400, "Invalid request");
        }
        break;

    case "PUT":
        $postedData = file_get_contents("php://input");
        $data = json_decode($postedData, true);
        if (isset($data["username"]) && isset($data["password"])) {
            $username = $data["username"];
            $password = $data["password"];
            if (createUser($username, $password)) {
                deliverResponse(201, "User created successfully");
            } else {
                deliverResponse(400, "Error while creating the user");
            }
        } else {
            deliverResponse(400, "Invalid request");
        }
        break;

    case "GET":
        if (get_bearer_token() && is_jwt_valid(get_bearer_token())) {
            deliverResponse(200, "Token is valid");
        } else {
            deliverResponse(400, "Invalid Token");
        }
        break;

}

?>