<?php
require_once('bdConnect.php');
require_once('store.php');
require_once('templater.php');
require_once('task.php');
require_once('auth/login.php');

$templateFile = 'view.html';

if (isset($_POST['reset'])) {
    resetPage();
}

if (isset($_POST['saveTask'])) {
    saveTask();
}

if (isset($_POST['task'])) {
    addTask($_POST['task']);
}

if (isset($_POST['taskDelete'])) {
   taskDelete($_POST['taskId']); 
}

if (isset($_POST['taskStatusChange'])) {
    taskStatusChange($_POST['taskId'], $_POST['taskStatus']);
}

if(isset($_POST['loginButton'])){
    tryLogin();
}
if(isset($_POST['logout'])){
    unset($_SESSION['user']);
}
$html = file_get_contents($templateFile, true);
echo (templater($html, [
    'task' => getTask(),
    'errors' => getErrors(),
    'auth' => checkAuth(),
    'tasklist' => getTasklist(),
]));
// echo "<pre>";
// print_r($_SESSION);
// print_r($_POST);
// echo "</pre>";