<?php

function session_addTask($taskName) {
    $_SESSION['task'] = $taskName;
}

function session_resetPage() {
    unset($_SESSION['task']);
    unset($_SESSION['subtasks']);
    header('Location: index.php');   
}

function session_addSubTask() {
    $subTask = array(
        "id" => uniqid(),
        "name" => NULL,
        "hours" => NULL,
    );
    $_SESSION['subtasks'][$subTask['id']] = $subTask;
}

function session_saveSubTask($data) {
    if (isset($_POST['subTaskName'])) {
        $_SESSION['subtasks'][$_POST['subTaskId']]['name'] = $_POST['subTaskName'];
    }
    if (isset($_POST['subTaskHours'])) {
        $_SESSION['subtasks'][$_POST['subTaskId']]['hours'] = $_POST['subTaskHours'];
    }
}

function session_subTaskDelete($id) {
    unset($_SESSION['subtasks'][$id]);
}

function session_getSubTasks() {
    if($_SESSION['subtasks']) {
        $subTasks = "";
        foreach($_SESSION['subtasks'] as $value) {
            $subTask = getSubTaskTemplate($value);
            $subTasks .= $subTask;
        }
        return $subTasks;
    }
}


function session_saveTask() {
    if(isset($_SESSION['task'])) {
        localSave($_SESSION['task'], $_SESSION['subtasks']);
    } else {
        echo "<div class = 'container'>УКАЖИТЕ НАЗВАНИЕ ЗАДАЧИ<div>";
    }
}
