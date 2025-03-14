<?php

require_once("../controllers/LoginController.php");
$authenticate = new LoginController();

$action = $_REQUEST['action'] ??'';

// echo "Login Inside";exit;

header('Content-Type: application/json');


if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'] ?? '';
    $password = $_POST['password'] ?? '';
    $confirmPassword = $_POST['password_confirmation'] ?? '';
    
    if($action == 'login'){
        $response = $authenticate->authenticate($username, $password);
        echo $response;
        // print_r($response);
        // if($response['status'] === 200){
        //     header('location:'.$response['url']);
        // }
        // else{

        // }
    }
    
    if($action == 'signup'){
       $response = $authenticate->register($username, $password, $confirmPassword);
       echo $response;
    }
}