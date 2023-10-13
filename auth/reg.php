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

    global $pdo;

    $sql = 'SELECT username FROM users WHERE username = ?';
    $stmt = $pdo->prepare($sql);
    $stmt->execute([$username]);
    $data = $stmt->fetchAll();

    if ($data[0]['username'] == $username) {
        $_SESSION['error'][] = 'Пользователь с таким логином уже существует';
    }

    // Выполнение SQL, если нет ошибок в заполнении
    if (!isset($_SESSION['error'])) {
        
        // Добавление глобальной соли и хэширование пароля
        $str = file_get_contents("auth\salt.txt");
        $password = $str.$password.$str;
        for ($i = 1; $i <= 256; $i++) {
            $password = hash('sha512', $password);
        }

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