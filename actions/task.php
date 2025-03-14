<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

error_log("Request method: " . $_SERVER["REQUEST_METHOD"]);

require_once("../controllers/TaskController.php");

$taskController = new TaskController();

header('Content-Type: application/json');

$action = $_REQUEST['action'] ?? '';

if ($_SERVER["REQUEST_METHOD"] == "GET") {
    $response = $taskController->getTasks();

    if (!json_decode($response, true)) {
        echo json_encode(["status" => 500, "message" => "Invalid JSON response", "debug" => $response]);
        exit;
    }

    echo $response;
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $title = $_POST["title"] ?? "";
    $priority = $_POST["priority"] ?? "";

    if ($action === 'add') {
        $response = $taskController->addTask($title, $priority);
        echo $response;
        exit;
    }
}

echo json_encode(["status" => 405, "message" => "Method Not Allowed"]);
exit;
