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

    protected function userTasks() {
        try {
            $conn = $this->connect();
            
            $draw = $_GET['draw'] ?? 1;
            $start = $_GET['start'] ?? 0;
            $length = $_GET['length'] ?? 10;
            $searchValue = $_GET['search']['value'] ?? '';
            
            $stmt = $conn->prepare("SELECT COUNT(*) as count FROM tasks WHERE user_id = ?");
            $stmt->bind_param("i", $_SESSION['user_id']);
            $stmt->execute();
            $totalRecords = $stmt->get_result()->fetch_assoc()['count'];
            
            $query = "SELECT id, title, status, priority FROM tasks WHERE user_id = ?";
            $params = [$_SESSION['user_id']];
            $types = "i";
            
            if (!empty($searchValue)) {
                $query .= " AND (title LIKE ? OR priority LIKE ?)";
                $searchValue = "%$searchValue%";
                array_push($params, $searchValue, $searchValue);
                $types .= "ss";
            }
            
            $filterQuery = "SELECT COUNT(*) as count FROM tasks WHERE user_id = ?";
            if (!empty($searchValue)) {
                $filterQuery .= " AND (title LIKE ? OR priority LIKE ?)";
            }
    
            $stmt = $conn->prepare($filterQuery);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $recordsFiltered = $stmt->get_result()->fetch_assoc()['count'];
            
            $query .= " ORDER BY id DESC LIMIT ?, ?";
            array_push($params, (int)$start, (int)$length);
            $types .= "ii";
            
            $stmt = $conn->prepare($query);
            $stmt->bind_param($types, ...$params);
            $stmt->execute();
            $result = $stmt->get_result();
            
            $data = [];
            while ($row = $result->fetch_assoc()) {
                $data[] = $row;
            }
            
            return json_encode([
                "draw" => intval($draw),
                "recordsTotal" => $totalRecords,
                "recordsFiltered" => $recordsFiltered,
                "data" => $data
            ]);
    
        } catch (Exception $e) {
            return json_encode([
                "draw" => intval($draw),
                "recordsTotal" => 0,
                "recordsFiltered" => 0,
                "data" => [],
                "error" => $e->getMessage()
            ]);
        }
    }
    
    
    protected function taskAdd($title, $priority){
        
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

    protected function taskEdit($id, $title, $priority) {
        try {
            $conn = $this->connect();
            $conn->begin_transaction();
    
            $sql = "SELECT user_id FROM tasks WHERE id=?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $task = $result->fetch_assoc();
    
                if ($task['user_id'] == $this->userId) {
                    $sql = "UPDATE tasks SET title=?, priority=? WHERE id=?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("ssi", $title, $priority, $id);
    
                    if ($stmt->execute()) {
                        $conn->commit();
                        return ['status' => 200, 'message' => 'Task Updated Successfully'];
                    } else {
                        $conn->rollback();
                        return ["status" => 500, "message" => "Task Update Failed"];
                    }
                } else {
                    return ["status" => 403, "message" => "Unauthorized Access"];
                }
            } else {
                return ["status" => 404, "message" => "Task Not Found"];
            }
        } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            return ["status" => 500, "message" => "Database Error: " . $e->getMessage()];
        }
    }

    protected function taskDelete($id){
        try {
            $conn = $this->connect();
            $conn->begin_transaction();
    
            $sql = "SELECT user_id FROM tasks WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $task = $result->fetch_assoc();
    
                if ($task['user_id'] == $this->userId) {
                    $sql = 'DELETE FROM tasks WHERE id = ?';
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param('i', $id);
    
                    if ($stmt->execute()) {
                        $conn->commit();
                        return ['status' => 200, 'message' => 'Task Deleted Successfully'];
                    } else {
                        $conn->rollback();
                        return ["status" => 500, "message" => "Task Delete Failed"];
                    }
                } else {
                    return ["status" => 403, "message" => "Unauthorized Access"];
                }
            } else {
                return ["status" => 404, "message" => "Task Not Found"];
            }
        } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            return ["status" => 500, "message" => "Database Error: " . $e->getMessage()];
        }
    }

    protected function statusUpdate($id, $status) {
        try {
            $conn = $this->connect();
            $conn->begin_transaction();
    
            $sql = "SELECT user_id FROM tasks WHERE id = ?";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("i", $id);
            $stmt->execute();
            $result = $stmt->get_result();
    
            if ($result->num_rows > 0) {
                $task = $result->fetch_assoc();
    
                if ($task['user_id'] == $this->userId) {
                    $sql = "UPDATE tasks SET status = ? WHERE id = ?";
                    $stmt = $conn->prepare($sql);
                    $stmt->bind_param("si", $status, $id);
    
                    if ($stmt->execute()) {
                        $conn->commit();
                        return json_encode(['status' => 200, 'message' => 'Status Updated Successfully']);
                    } else {
                        $conn->rollback();
                        return json_encode(["status" => 500, "message" => "Status Update Failed"]);
                    }
                } else {
                    return json_encode(["status" => 403, "message" => "Unauthorized Access"]);
                }
            } else {
                return json_encode(["status" => 404, "message" => "Task Not Found"]);
            }
        } catch (mysqli_sql_exception $e) {
            $conn->rollback();
            return json_encode(["status" => 500, "message" => "Database Error: " . $e->getMessage()]);
        }
    }   
    
}
