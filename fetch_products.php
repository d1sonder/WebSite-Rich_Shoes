<?php
// Подключение к базе данных и выполнение запроса по фильтру и сортировке

$category = $_GET['category'] ?? '';
$sort = $_GET['sort'] ?? 'name'; // Значение по умолчанию

$query = "SELECT * FROM products"; // начальный запрос
if (!empty($category)) {
    $query .= " WHERE category = :category";
    $params[':category'] = $category;
}
$query .= " ORDER BY " . $sort;


?>
