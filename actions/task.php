<?php

require_once("../controllers/TaskController.php");
$taskController = new TaskController();

// print_r($_REQUEST);exit;

$action = $_REQUEST['action'] ??'';
// echo $action;exit;
header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $title = $_POST["title"] ??"";
    $priority = $_POST["priority"] ??"";

    if($action === 'add'){
        // echo 'inside';exit;
        $response = $taskController->addTask($title, $priority);
        echo $response;
    }
}