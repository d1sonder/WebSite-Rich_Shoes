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
    header("Location: admin.php");  
    exit();  
}  
?>    

<!DOCTYPE html>  
<html lang="ru">  
<head>  
    <meta charset="UTF-8">  
    <meta name="viewport" content="width=device-width, initial-scale=1.0">  
    <title>Редактировать товар</title>  
        <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon"> 
    <link href="./css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="./css/style.css">
</head>  
<body>  
    <div class="container">
        <div class="edit-form">
            <h1 class="text-center mb-4">Редактировать товар</h1>  
            
            <form method="post">  
                <input type="hidden" name="id" value="<?php echo htmlspecialchars($guitar['id']); ?>">  
                
                <div class="row mb-3">
                    <div class="col-md-6">
                        <label for="name" class="form-label">Название</label>
                        <input type="text" class="form-control" id="name" name="name" 
                               value="<?php echo htmlspecialchars($guitar['name']); ?>" required>
                    </div>
                    <div class="col-md-6">
                        <label for="price" class="form-label">Цена</label>
                        <input type="number" step="0.01" class="form-control" id="price" name="price" 
                               value="<?php echo htmlspecialchars($guitar['price']); ?>" required>
                    </div>
                </div>
                
                <div class="mb-3">
                    <label for="photo" class="form-label">Ссылка на изображение</label>
                    <input type="text" class="form-control" id="photo" name="photo" 
                           value="<?php echo htmlspecialchars($guitar['photo']); ?>" required>
                </div>
                
                <div class="mb-3">
                    <label for="xar" class="form-label">Характеристика</label>
                    <textarea class="form-control" id="xar" name="xar" rows="3" required><?php echo htmlspecialchars($guitar['xar']); ?></textarea>
                </div>
                
                <div class="row mb-3">
                    <div class="col-md-4">
                        <label for="stock" class="form-label">Количество</label>
                        <input type="number" class="form-control" id="stock" name="stock" 
                               value="<?php echo htmlspecialchars($guitar['stock']); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="supplier_country" class="form-label">Страна</label>
                        <input type="text" class="form-control" id="supplier_country" name="supplier_country" 
                               value="<?php echo htmlspecialchars($guitar['supplier_country']); ?>" required>
                    </div>
                    <div class="col-md-4">
                        <label for="category" class="form-label">Категория</label>
                        <select class="form-select" id="category" name="category" required>
                            <option value="Текстиль" <?= ($guitar['category'] === 'Текстиль') ? 'selected' : '' ?>>Текстиль</option>
                            <option value="Кожа" <?= ($guitar['category'] === 'Кожа') ? 'selected' : '' ?>>Кожа</option>
                            <option value="Замша" <?= ($guitar['category'] === 'Замша') ? 'selected' : '' ?>>Замша</option>
                        </select>
                    </div>
                </div>
                
                <input type="hidden" name="action" value="edit">  
                
                <div class="d-grid gap-2 d-md-flex justify-content-md-end mt-4">
                    <a href="index.php" class="btn btn-outline-light me-md-2">Отмена</a>
                    <button type="submit" class="btn btn-dark">Сохранить изменения</button>
                </div>
            </form>  
        </div>
    </div>

    <!-- Bootstrap 5 JS Bundle with Popper -->
    <script src="./js/bootstrap.bundle.min.js"></script>
</body>  
</html>