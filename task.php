<?php
session_start();
require_once('bdConnect.php');

function bdSave($task) {
    
    $userId = $_SESSION['user']['id'];
    $date = date('Y-m-d');
    $status = 0;
    
    if (!isset($task)) {
        $_SESSION['error'][] = 'Введите описание задачи';
    }

    if (!isset($_SESSION['error'])) {

        global $pdo;

        $stmt = $pdo->prepare("INSERT INTO tasks (user_id, description, created_at, status) VALUES (:userId, :task, :date, :status)");

        $stmt->bindParam(':userId', $userId);
        $stmt->bindParam(':task', $task);
        $stmt->bindParam(':date', $date);
        $stmt->bindParam(':status', $status);

        $stmt->execute();

    } else {
        return;
    }
}

function taskDelete($id) {
    if (isset($id)) {
        global $pdo;

        $sql = "DELETE FROM tasks WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$id]);

    } else {
        $_SESSION['error'][] = 'Ошибка: задача не существует';
    }

}

function taskStatusChange($id, $status) {
    if (isset($id)) {
        global $pdo;

        if ($status == '1') {
            $status = '0';
        } else {
            $status = '1';
        }
        $sql = "UPDATE `Tasks` SET status = ? WHERE id = ?";
        $stmt = $pdo->prepare($sql);
        $stmt->execute([$status, $id]);

    } else {
        $_SESSION['error'][] = 'Ошибка: задача не существует';
    }
}