<?php
require_once('bdConnect.php');
require_once('store.php');
require_once('templater.php');
require_once('file.php');
require_once('auth/reg.php');
require_once('auth/login.php');

$templateFile = 'view.html';

if (isset($_POST['addSubtask'])) {
    addSubTask();
}
if (isset($_POST['reset'])) {
    resetPage();
}
unset($_SESSION);
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

if (isset($_POST['registration'])) {
    $_SESSION['registration'] = 'reg';
} elseif (isset($_POST['authorization'])) {
    $_SESSION['registration'] = 'auth';
} else {
    $_SESSION['registration'] = 'reg';
}

if(isset($_POST['regButton'])){
    reg();
}

if(isset($_POST['loginButton'])){
    login();
}

$html = file_get_contents($templateFile, true);
echo (templater($html, [
    'subtasks' => getSubTasks(),
    'task' => getTask(),
    'auth' => getAuthBlock(), // Возвращает блок полей для логина/регистрации в зависимости от $_SESSION, для смены по нажатию кнопки
    'errors' => getErrors(),
]));
// print_r($_POST);
// echo "<pre>";
// print_r($_SESSION);
// echo "</pre>";