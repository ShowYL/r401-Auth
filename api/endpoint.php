<?php
require_once '../model/gestionAuth.php';
require_once '../model/utils.php';

switch($_SERVER["REQUEST_METHOD"]){

    case "POST":
        $postedData = file_get_contents("php://input");
        $data = json_decode($postedData, true);
        if(isset($data["username"]) && isset($data["password"])){
            $username = $data["username"];
            $password = $data["password"];
            if(getUser($username, $password)) {
                $headers = array('alg' => 'HS256', 'typ' => 'JWT');
                $payload = array('login' => $username, 'role' => getRole($username), 'exp' => time() + 60);
                $jwt = generate_jwt($headers, $payload);
                deliverResponse(200, "User identified successfully",data:$jwt);
            }else{
                deliverResponse(400, "Error wrong credential");
            }
        }else{
            deliverResponse(400, "Invalid request");
        }
        break;

    case "PUT":
        $postedData = file_get_contents("php://input");
        $data = json_decode($postedData, true);
        if(isset($data["username"]) && isset($data["password"])){
            $username = $data["username"];
            $password = $data["password"];
            if(createUser($username, $password)) {
                deliverResponse(201, "User created successfully");
            }else{
                deliverResponse(400, "Error while creating the user");
            }
        }else{
            deliverResponse(400, "Invalid request");
        }
        break;

}

?>