<?php
// Выборка задач
$limit = 3; // Количество отдаваемых строк
$offset = $_POST['offset'] ? $_POST['offset'] : 0; // Отдаем строки начиная с offset
//  if (isset($_POST['order_name'])) // Сортировка всегда приходит (но можно снять ремарку)
$order = 'ORDER BY '.$_POST['order_name'].' '.$_POST['order_clause']; // Сортировка
$query = 'SELECT SQL_CALC_FOUND_ROWS * FROM tasks '.$order.' LIMIT '.$offset.','.$limit;
$sql = mysqli_query($mysqli, $query) OR DIE(json_encode(['Error message' => 'DB SELECT Error: '.$query,'Error' => mysqli_error($mysqli)]));
$result = mysqli_query($mysqli,'SELECT FOUND_ROWS()'); // Получаем общее количество задач в БД
$total = mysqli_fetch_row($result); // Заносим количество задач в БД в total
while ($foo = mysqli_fetch_array($sql)) {
    $tasks[] = [    
        'id' => $foo['id'],
        'user_name' => $foo['user_name'],
        'user_email' => $foo['user_email'],
        'user_text' => $foo['user_text'],
        'completed' => $foo['completed'],
        'action' => $foo['action']
    ]; // Наполняем массив задач
}
$return['success'] = 'success';
$return['tasks'] = $tasks; // Массив задач
$return['total'] = $total[0]; // Количество задач в БД
