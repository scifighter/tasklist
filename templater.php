<?php

function templater($template, $data) {
 $templateKeys = array_map(function($val) { return '{{'.$val.'}}';} ,
     array_keys($data));

 $processedData = array_combine($templateKeys, array_values($data));
 return strtr($template, $processedData);
}

function getSubTaskTemplate($subTask) {
    $id = $subTask['id'];
    $name = $subTask['name'];
    $hours = "subTaskHours".$subTask['hours'];
    return "
    <div class = 'subTaskForm'>
    <form action = '/' method='post' name = '".$id."' onchange=document.forms['".$id."'].submit();>

        <input value = '".$subTask['name']."' type='text' name='subTaskName'>

        <input value = '".$subTask['hours']."' type='number' name='subTaskHours'>
        
        <input type = 'submit' name='subTaskDelete' value = 'Remove'>

        <input type='hidden' name='subTaskId' value='".$id."'>
    </form>
    </div>
    ";
}

function getTask() {
    $task = "";
    if(isset($_SESSION['task'])) {
        $task = $_SESSION['task'];
        return $task;
    }
}
function getErrors() {
    if (isset($_SESSION['error'])) {
        $output;
        foreach ($_SESSION['error'] as &$value) {
            $output = $output."
            <div class = 'error'>
                ".$value."
            </div>
            ";    
        }
        $output = "<div class = 'errorBlock'>".$output."</div>";
        unset($_SESSION['error']);
        return $output;
    }
}