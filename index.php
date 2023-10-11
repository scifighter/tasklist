<?php
require_once('bdConnect.php');
require_once('store.php');
require_once('templater.php');
require_once('file.php');
require_once('auth/reg.php');

$templateFile = 'view.html';

if (isset($_POST['addSubtask'])) {
    addSubTask();
}
if (isset($_POST['reset'])) {
    resetPage();
}
//unset($_SESSION['error']);
if (isset($_POST['subTaskName'])) {
    saveSubTask($_POST['subTaskName']);
}

if (isset($_POST['subTaskHours'])) {
    saveSubTask($_POST['subTaskHours']);
}

if (isset($_POST['subTaskDelete'])) {
    subTaskDelete($_POST['subTaskId']);
}

if (isset($_POST['saveTask'])) {
    saveTask();
    resetPage();
}

if (isset($_POST['task'])) {
    addTask($_POST['task']);
}

if($_SESSION['subtasks'] == NULL || !$_SESSION['subtasks']){
    addSubTask();
}

if(isset($_POST['regButton'])){
    reg();
}
$html = file_get_contents($templateFile, true);
echo (templater($html, [
    'subtasks' => getSubTasks(),
    'task' => getTask(),
    'auth' => getAuthBlock(),
    'errors' => getErrors(),
]));