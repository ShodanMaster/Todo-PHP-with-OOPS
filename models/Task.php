<?php 
session_start();
require_once("../config/dbconfig.php");
class Task extends Dbconfig{

    private $userId;

    public function __construct(){
        if (isset($_SESSION['user_id'])) {
            $this->userId = $_SESSION['user_id'];
        } else {
            $this->userId = null;
        }
    }

    protected function taskAdd($title, $priority){
        // echo $title." asdfaqwertysdf ".$priority." ";
        try{
            $conn = $this->connect();
            $conn->begin_transaction();

            $sql = "INSERT INTO tasks(user_id, title, priority) VALUES (?,?,?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iss", $this->userId,$title, $priority);

            if ($stmt->execute()) {
                $conn->commit();
                return ["status" => 200, "message" => "Task Added successfully!"];
            } else {
                $conn->rollback();
                return ["status" => 500, "message" => "Task Add failed!"];
            }
        }catch (mysqli_sql_exception $e) {
            $conn->rollback();
            return ["status" => 500, "message" => "Database error: " . $e->getMessage()];
        }
    }
}
