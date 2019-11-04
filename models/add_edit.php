<?php
// Добавление или изменение задачи
$set = '';
$return = [];
foreach ($_POST AS $var => $val) {
    //$val = strip_tags($val); //Если надо очистить от тегов
    $val = htmlspecialchars($val);
    $set .= $var.'="'.$val.'",';
    $return[$var] = $val;               
}
$set = rtrim($set, ',');        
$query = 'REPLACE tasks SET '.$set; // Использовал Replace вместо insert - update, так дешевле
mysqli_query($mysqli, $query) OR DIE(json_encode(['Error message' => 'DB REPLACE Error: '.$query,'Error' => mysqli_error($mysqli)]));

$return['success'] = 'success';
