<?php

function templater($template, $data) {
 $templateKeys = array_map(function($val) { return '{{'.$val.'}}';} ,
     array_keys($data));

 $processedData = array_combine($templateKeys, array_values($data));
 return strtr($template, $processedData);
}

function getAuthBlock() {
    if ($_SESSION['registration'] == 'reg') {
        return "
        <form class = 'regForm' action = '/' method = 'post'>
            Логин
            <input class = 'textField' type = 'text' name = 'username'>
            Пароль
            <input class = 'textField' type = 'password' name = 'password'>
            Пароль ещё раз
            <input class = 'textField' type = 'password' name = 'passwordRepeat'>
            <input class = 'regSubmit' type = 'submit' value = 'Зарегистрироваться' name = 'regButton'>
        </form>
        ";
    } elseif ($_SESSION['registration'] == 'auth') {
        return "
        <form class = 'regForm' action = '/' method = 'post'>
            Логин
            <input class = 'textField' type = 'text' name = 'username'>
            Пароль
            <input class = 'textField' type = 'password' name = 'password'>
            <input class = 'regSubmit' type = 'submit' value = 'Войти' name = 'loginButton'>
        </form>
        ";
    } else {
        $_SESSION['registration'] = 'reg';
        getAuthBlock();
    }
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
    if(isset($_SESSION['task'])) {
        $task = $_SESSION['task'];
    } else {
        $task = "";
    }
    return "
    <div class = 'task'>
        <div class = 'header'>Название задачи</div>
        <form action = '/'' method = 'post' name = 'task' onchange=document.forms['task'].submit();>
            <input type = 'text' name = 'task' value = '".$task."'>
        </form>
        <br>
    </div>
    ";
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