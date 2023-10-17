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
        $output = '';
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

function getTasklist() {
    if (isset($_SESSION['user']['id'])) {

        global $pdo;

        $sql = "SELECT id, description, status FROM tasks WHERE user_id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$_SESSION['user']['id']]);
        $data = $stmt->fetchAll();

        $output = '';

        foreach ($data as $value) {
            $description = $value['description'];
            $id = $value['id'];
            if ($value['status'] == 0) {
                $status = 'READY';
                $taskStatusPic = 'redcircle';
            } else {
                $status = 'UNREADY';
                $taskStatusPic = 'greencircle';
            }
            $output = $output."
            <div class = 'task'>
                <div class = 'taskDescription'>
                    <div class = 'taskText'>".$description."</div>
                    <img class = 'status' src = 'images/".$taskStatusPic.".png'><!--REDCIRCLE-->
                </div>

                <div class = 'taskControls'>
                    <form action = '/' method = 'post'>
                        <input type = 'submit' value = '".$status."' name = 'taskStatusChange'>
                        <input type = 'hidden' name = 'taskId' value = '".$id."'>
                        <input type = 'hidden' name = 'taskStatus' value = '".$value['status']."'>
                    </form>
                    <form action = '/' method = 'post'>
                        <input type = 'submit' value = 'DELETE' name = 'taskDelete'>
                        <input type = 'hidden' name = 'taskId' value = '".$id."'>
                    </form>
                </div>
            </div>
            ";
        }
        return $output;
    } else {
        return;
    }
}