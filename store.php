<?php
session_start();
$current_data_store = 'session'; // variants - cookie, session, db, txt

require_once('./storages/cookie.php');
require_once('./storages/session.php');

function getFuncName($store, $action) {
    return $store.'_'.$action;
}

function addTask($taskName) {
    global $current_data_store;
    $func = getFuncName($current_data_store, 'addTask');
    $func($taskName);
}

function addSubTask() {
    global $current_data_store;
    $func = getFuncName($current_data_store, 'addSubTask');
    return $func();
}

function getSubTasks() {
    global $current_data_store;
    $func = getFuncName($current_data_store, 'getSubTasks');
    return $func();
}

function resetPage() {
    global $current_data_store;
    $func = getFuncName($current_data_store, 'resetPage');
    return $func();
}

function saveSubTask($data) {
    global $current_data_store;
    $func = getFuncName($current_data_store, 'saveSubTask');
    return $func($data);
}
function subTaskDelete($data) {
    global $current_data_store;
    $func = getFuncName($current_data_store, 'subTaskDelete');
    return $func($data);
}

function saveTask() {
    global $current_data_store;
    $func = getFuncName($current_data_store, 'saveTask');
    return $func();
}

