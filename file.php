<?php
function localSave($task, $subTasks) {
    $taskFileName = $task."_".uniqid();
    $fd = fopen("tasks/".$taskFileName.".txt", 'w') or die("Не удалось создать файл");
    $str = "+----+-------+----------------------------------------------------------------------+
|                                   ".$task."
+----+-------+----------------------------------------------------------------------+";
    fwrite($fd, $str);
    $counter = 0;

    foreach($subTasks as $value) {
        $counter++;
        if($value['name'] || $value['hours']) {
        $subTaskName = $value['name'];
        $subTaskHours = $value['hours'];
        $str = "
_№".$counter."| ".$subTaskHours." _часы|_".$subTaskName."
+----+-------+----------------------------------------------------------------------+";
        fwrite($fd, $str);
        } else {
            break;
        }
    }
    $taskFileName = "tasks/".$taskFileName.".txt";
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header("Cache-Control: no-cache, must-revalidate");
    header("Expires: 0");
    header('Content-Disposition: attachment; filename="'.basename($taskFileName).'"');
    header('Content-Length: ' . filesize($taskFileName));
    header('Pragma: public');
    flush();

    readfile($taskFileName);
}