<?php

require_once("../models/Task.php");
class TaskController extends Task{

    public function getTasks(){

        $tasksJson = $this->userTasks();

        $tasks = json_decode($tasksJson, true);
        
        if ($tasks === null || !isset($tasks['data'])) {
            return json_encode([
                "status" => 500,
                "message" => "Invalid JSON response from userTasks()",
                "debug" => $tasksJson
            ]);
        }

        return json_encode($tasks);
    }
    public function addTask($title, $priority){
        
        $addTask = $this->taskAdd($title, $priority);
        return json_encode($addTask);
    }

    public function editTask($id, $title, $priority){
        $editTask = $this->taskEdit($id, $title, $priority);
        return json_encode($editTask);
    }

    public function deleteTask($id){
        $deleteTask = $this->taskDelete($id);
        return json_encode($deleteTask);
    }
    public function updateStatus($id, $status){
        $updateStatus = $this->statusUpdate($id, $status);
        return json_encode($updateStatus);
    }
}