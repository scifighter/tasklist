<?php
require_once('bdConnect.php');

function tryLogin() {

    // Передача данных полей из POST в переменные
    $login = $_POST['login'];
    $password = $_POST['password'];

    // Обработка ошибок
    if (!$login) {
        $_SESSION['error'][] = 'Введите логин';
    }
    if (!$password) {
        $_SESSION['error'][] = 'Введите пароль';
    }

    for($i=0;$i<strlen($login);$i++) {
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

        // Добавление глобальной соли и хэширование пароля
        $str = file_get_contents("auth\salt.txt");
        $password = $str.$password.$str;
        for ($i = 1; $i <= 256; $i++) {
            $password = hash('sha512', $password);
        }

        // Найти запись с совпадающим именем и паролем

        $sql = "SELECT id, login FROM users WHERE login = ? AND password = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$login, $password]);
        $data = $stmt->fetchAll();

        if (isset($data[0])) {

            // Установить текущего пользователя на найденный id
            $_SESSION['user']['id'] = $data[0]['id'];
            $_SESSION['user']['login'] = $data[0]['login'];

        } else {

            $date = date('Y-m-d');
            $stmt = $pdo->prepare("INSERT INTO users (login, password, created_at) VALUES (:login, :password, :date)");
            $stmt->bindParam(':login', $login);
            $stmt->bindParam(':password', $password);
            $stmt->bindParam(':date', $date);
            $stmt->execute();

            tryLogin();
        }
    }

    // Сброс данных и вывод ошибок
    else {
        unset($_POST['login']);
        unset($_POST['password']);
        unset($_POST['passwordRepeat']);
        return;
    }
}