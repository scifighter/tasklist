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

function resetPage() {
    global $current_data_store;
    $func = getFuncName($current_data_store, 'resetPage');
    return $func();
}

function saveTask() {
    global $current_data_store;
    $func = getFuncName($current_data_store, 'saveTask');
    return $func();
}

