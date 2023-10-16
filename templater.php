<?php

function templater($template, $data) {
 $templateKeys = array_map(function($val) { return '{{'.$val.'}}';} ,
     array_keys($data));

 $processedData = array_combine($templateKeys, array_values($data));
 return strtr($template, $processedData);
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

function checkAuth() {
    if (!isset($_SESSION['user']['id'])) {
        return file_get_contents('auth.html');
    } else {
        return $_SESSION['user']['login'];
    }
}