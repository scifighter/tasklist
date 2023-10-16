<?php

function session_addTask($taskName) {
    $_SESSION['task'] = $taskName;
}

function session_resetPage() {
    unset($_SESSION['task']);
    header('Location: index.php');   
}

function session_saveTask() {
    bdSave($_SESSION['task']);
}
