<?php
require_once('bdConnect.php');

function login() {

    // Передача данных полей из POST в переменные
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Обработка ошибок
    if (!$username) {
        $_SESSION['error'][] = 'Введите логин';
    }
    if (!$password) {
        $_SESSION['error'][] = 'Введите пароль';
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

        // $salt = '$2a$12$'.substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(),mt_rand()))), 0, 22) . '$';
        // $hashed_password = crypt($password, $salt);

        //$sql = "SELECT id FROM users WHERE username = ? AND password = ?";
        $sql = "SELECT * FROM users";
        $stmt = $pdo->prepare($sql);
        //$stmt->execute([$username, $hashed_password]);
        $stmt->execute();
        $data = $stmt->fetchAll();

        $salt = '$2a$12$'.substr(str_replace('+', '.', base64_encode(pack('N4', mt_rand(), mt_rand(), mt_rand(),mt_rand()))), 0, 22) . '$';
        $hashed_password = crypt('privet', $salt);

        echo "<pre>";
        print_r($data);
        echo $hashed_password;
        echo "</pre>";


        // Изменить место хранения пароля на файлы конфигурации, по возможности зашифровать (нужно прочитать про это больше)

        // $stmt = $pdo->prepare("INSERT INTO users (username, password) VALUES (:username, :password)");

        // $stmt->bindParam(':username', $username);
        // $stmt->bindParam(':password', $password);
        // $stmt->execute();

    }

    // Сброс данных и вывод ошибок
    else {
        unset($_POST['username']);
        unset($_POST['password']);
        unset($_POST['passwordRepeat']);
        return;
    }
}