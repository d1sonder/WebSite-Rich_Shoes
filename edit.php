<?php     
require 'db.php';    
session_start();    

if ($_SERVER['REQUEST_METHOD'] === 'POST') {    
    $id = $_POST['id'];   
    $stmt = $db->prepare("SELECT * FROM pot WHERE id = ?");  
    $stmt->execute([$id]);  
    $guitar = $stmt->fetch(PDO::FETCH_ASSOC);  
}  

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action']) && $_POST['action'] === 'edit') {  
    $name = $_POST['name'];    
    $price = $_POST['price'];    
    $photo = $_POST['photo'];    
    $xar = $_POST['xar'];    
    $id = $_POST['id'];  
    $stock = $_POST['stock'];    
    $supplier_country = $_POST['supplier_country']; 
    $category = $_POST['category']; // Получение значения категории 

    // SQL-запрос для обновления  
    $stmt = $db->prepare("UPDATE pot SET name = ?, price = ?, photo = ?, xar = ?, stock = ?, supplier_country = ?, category = ? WHERE id = ?");  
    $stmt->execute([$name, $price, $photo, $xar, $stock, $supplier_country, $category, $id]);  

    // Перенаправление на главную страницу после успешного редактирования  
    header("Location: index.php");  
    exit();  
}  
?>    

<!DOCTYPE html>  
<html lang="ru">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Редактировать товар</title>  
</head>  
<body>  
    <h1>Редактировать товар</h1>  
    <form method="post">  
        <input type="hidden" name="id" value="<?php echo htmlspecialchars($guitar['id']); ?>">  
        Название: <input type="text" name="name" value="<?php echo htmlspecialchars($guitar['name']); ?>" required><br>  
        Цена: <input type="number" step="0.01" name="price" value="<?php echo htmlspecialchars($guitar['price']); ?>" required><br>  
        Ссылка на изображение: <input type="text" name="photo" value="<?php echo htmlspecialchars($guitar['photo']); ?>" required><br>  
        Характеристика: <input type="text" name="xar" value="<?php echo htmlspecialchars($guitar['xar']); ?>" required><br>  
        Кол-во: <input type="text" name="stock" value="<?php echo htmlspecialchars($guitar['stock']); ?>" required><br>  
        Страна: <input type="text" name="supplier_country" value="<?php echo htmlspecialchars($guitar['supplier_country']); ?>" required><br> 
        Категория: <input type="text" name="category" value="<?php echo htmlspecialchars($guitar['category']); ?>" required><br> <!-- Новое поле для категории --> 
        <input type="hidden" name="action" value="edit">  
        <input type="submit" value="Сохранить изменения">  
    </form>  
</body>  
</html>