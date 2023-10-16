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