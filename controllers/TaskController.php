<?php

require_once("../models/Task.php");
class TaskController extends Task{

    public function addTask($title, $priority){
        // echo $title." asdfasdf ".$priority." ";
        $addTask = $this->taskAdd($title, $priority);
        return json_encode($addTask);
    }
}