<?php
require_once('bdConnect.php');
function reg() {
    // Передача данных полей из POST в переменные

    $username = $_POST['username'];
    $password = $_POST['password'];
    $passwordRepeat = $_POST['passwordRepeat'];

    // Обработка ошибок
    if (!$username) {
        $_SESSION['error'][] = 'Введите логин';
    }
    if (!$password) {
        $_SESSION['error'][] = 'Введите пароль';
    }
    if (!$passwordRepeat) {
        $_SESSION['error'][] = 'Введите пароль повторно';
    } elseif ($password !== $passwordRepeat) {
        $_SESSION['error'][] = 'Пароли не совпадают';
    }

    for($i=0;$i<strlen($username);$i++) {
        if($username[$i]== " ") {
            $_SESSION['error'][] = 'Логин не должен содержать пробелов';
        } 
    }
    for($i=0;$i<strlen($password);$i++) {
        if($password[$i]== " ") {
            $_SESSION['error'][] = 'Пароль не должен содержать пробелов';
        } 
    }


    // Выполнение SQL, если нет ошибок в заполнении
    if (!isset($_SESSION['error'])) {
        global $pdo;

        $stmt = $pdo->query('SELECT username FROM users');
        $data = $stmt->fetchAll();

        foreach ($data[0] as &$value) {
            if ($value == $username) {
                $_SESSION['error'][] = 'Пользователь с таким логином уже существует';
                reg();
            }
        }

        // Изменить место хранения пароля на файлы конфигурации, по возможности зашифровать (нужно прочитать про это больше)

        $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");

        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password', $password);
        $stmt->execute();

    } 
    // Сброс данных и вывод ошибок
    else {
        unset($_POST['username']);
        unset($_POST['password']);
        unset($_POST['passwordRepeat']);
        return;
    }
}