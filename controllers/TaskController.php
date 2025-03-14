<?php

require_once("../models/Task.php");
class TaskController extends Task{

    public function getTasks(){

        $tasksJson = $this->userTasks();

        $tasks = json_decode($tasksJson, true);

        // print_r($tasks);exit;
        if ($tasks === null || !isset($tasks['data'])) {
            return json_encode([
                "status" => 500,
                "message" => "Invalid JSON response from userTasks()",
                "debug" => $tasksJson
            ]);
        }

        return json_encode($tasks);

        // return json_encode($tasks);
    }
    public function addTask($title, $priority){
        // echo $title." asdfasdf ".$priority." ";
        $addTask = $this->taskAdd($title, $priority);
        return json_encode($addTask);
    }

    public function editTask($id, $title, $priority){
        $editTask = $this->taskEdit($id, $title, $priority);
        return json_encode($editTask);
    }
}