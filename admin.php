<?php          
require 'db.php';         
session_start();         
  
// Начисление переменных для сортировки  
$order_sort_column = 'created_at';  
$order_sort_order = 'DESC';  
  
// Обработка POST-запросов  
if ($_SERVER['REQUEST_METHOD'] === 'POST') {         
    // Обработка добавления товара  
    if (isset($_POST['action']) && $_POST['action'] === 'add') { 
        // Код для добавления товара
        $name = $_POST['name'];
        $price = $_POST['price'];
        $xar = $_POST['xar'];
        $stock = $_POST['stock'];
        $supplier_country = $_POST['supplier_country'];
        $category_name = $_POST['category'];

        // Загрузка изображения
        $photoPath = 'uploads/' . basename($_FILES['photo']['name']);
        move_uploaded_file($_FILES['photo']['tmp_name'], $photoPath);

        // Запись данных в базу данных 
        $stmt = $db->prepare("INSERT INTO pot (name, price, photo, xar, stock, supplier_country, category) VALUES (:name, :price, :photo, :xar, :stock, :supplier_country, :category)");
        $stmt->execute([':name' => $name, ':price' => $price, ':photo' => $photoPath, ':xar' => $xar, ':stock' => $stock, ':supplier_country' => $supplier_country, ':category' => $category_name]);
    } 
 
    // Обработка удаления товара  
    if (isset($_POST['action']) && $_POST['action'] === 'delete') { 
        $id = $_POST['id']; 
        $stmt = $db->prepare("DELETE FROM pot WHERE id = :id"); 
        $stmt->execute(['id' => $id]); 
    } 
 
    // Обработка добавления новой категории 
    if (isset($_POST['action']) && $_POST['action'] === 'add_category') { 
        $category_name = $_POST['category_name']; 
        $stmt = $db->prepare("INSERT INTO categories (name) VALUES (:name)"); 
        $stmt->execute(['name' => $category_name]); 
    } 
 
    // Обработка удаления категории 
    if (isset($_POST['action']) && $_POST['action'] === 'delete_category') { 
        $category_id = $_POST['category_id']; 
        $stmt = $db->prepare("DELETE FROM categories WHERE id = :id"); 
        $stmt->execute(['id' => $category_id]); 
    } 
} elseif ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['sort'])) {  
    // Обработка GET-запроса для сортировки  
    if ($_GET['sort'] === 'date') {  
        $order_sort_column = 'created_at';  
    } elseif ($_GET['sort'] === 'status') {  
        $order_sort_column = 'status';  
    }  
  
    // Поменять порядок сортировки  
    $order_sort_order = 'ASC';  
  
    if (isset($_GET['order']) && $_GET['order'] === 'desc') {  
        $order_sort_order = 'DESC';  
    }  
}  
  
// Получение всех товаров  
$stmt = $db->query("SELECT id, name, price, photo, xar, stock, supplier_country, category FROM pot");        
$pot = $stmt->fetchAll(PDO::FETCH_ASSOC);     
 
// Получение всех категорий 
try {
    $stmt_categories = $db->query("SELECT id, name FROM categories");
    $categories = $stmt_categories->fetchAll(PDO::FETCH_ASSOC);
} catch (PDOException $e) {
    echo "Ошибка: " . $e->getMessage();
}
// Получение всех заказов с информацией о пользователях   
$stmt_orders = $db->prepare("  
    SELECT o.id, o.user_id, o.quantity, o.status, o.pot_id, o.created_at,    
           u.name AS user_name, u.surname AS user_surname    
    FROM orders o    
    JOIN users u ON o.user_id = u.id   
    ORDER BY $order_sort_column $order_sort_order  
");     

// Обработка изменения статуса заявления
if (!empty($_GET['approve'])) {
    $order_id = intval($_GET['approve']);
    $stmt = $db->prepare("UPDATE orders SET status = 'В ожидании' WHERE id = ?");
    $stmt->execute([$order_id]);
    header("Location: admin.php"); // Перенаправляем после выполнения запроса
    exit;
}

if (!empty($_GET['reject'])) {
    $order_id = intval($_GET['reject']);
    $stmt = $db->prepare("UPDATE orders SET status = 'Отправлен' WHERE id = ?");
    $stmt->execute([$order_id]);
    header("Location: admin.php"); // Перенаправляем после выполнения запроса
    exit;
}

if (!empty($_GET['delete'])) {
    $order_id = intval($_GET['delete']);
    $stmt = $db->prepare("DELETE FROM orders WHERE id = ?");
    $stmt->execute([$order_id]);
    header("Location: admin.php"); // Перенаправляем после выполнения запроса
    exit;
}

$stmt_orders->execute();  
$orders = $stmt_orders->fetchAll(PDO::FETCH_ASSOC);        
?>         

<!DOCTYPE html>            
<html lang="ru">   
<head>            
    <meta charset="UTF-8">            
    <meta name="viewport" content="width=device-width, initial-scale=1.0">    
    <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon">         
    <link href="./css/bootstrap.min.css" rel="stylesheet">     
    <link rel="stylesheet" href="css/style.css">        
    <title>Админ панель</title>            
</head>            
<body class="bg-light">   
    <header>
        <nav class="navbar navbar-expand-lg navbar-dark">
            <div class="container-fluid">
                <a class="navbar-brand" href="./index.php">
                    <img src="./img/image 1.png" alt="Logo" class="logo">
                </a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon"></span>
                </button>
                <div class="collapse navbar-collapse" id="navbarNav">
                    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="./index.php">Главная</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./tovar.php">Товары</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./sales.php">Акции</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./contacts.php">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./orders.php">Заказы</a>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
                <hr class="hr-basic">
    </header>

    <main class="container py-4">
        <div class="mb-4">
            <a href="index.php" class="btn btn-secondary">На главную</a>
        </div>

        <!-- Форма добавления товара -->
        <div class="card mb-5 shadow">
            <div class="card-header bg-dark text-white">
                <h2 class="h4 mb-0">Добавить товар</h2>
            </div>
            <div class="card-body">
                <form method="post" enctype="multipart/form-data" class="row g-3">
                    <input type="hidden" name="action" value="add">
                    
                    <div class="col-md-6">
                        <label class="form-label">Название</label>
                        <input type="text" name="name" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Цена</label>
                        <input type="number" step="0.01" name="price" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Изображение</label>
                        <input type="file" name="photo" accept="image/*" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Характеристика</label>
                        <input type="text" name="xar" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Количество</label>
                        <input type="number" name="stock" class="form-control" required>
                    </div>
                    
                    <div class="col-md-6">
                        <label class="form-label">Страна поставщика</label>
                        <input type="text" name="supplier_country" class="form-control" required>
                    </div>
                    
                    <div class="col-md-12">
                        <label class="form-label">Категория</label>
                        <select name="category" class="form-select" required>
                            <?php foreach ($categories as $category): ?>
                                <option value="<?php echo htmlspecialchars($category['name']); ?>">
                                    <?php echo htmlspecialchars($category['name']); ?>
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    
                    <div class="col-12">
                        <button type="submit" class="btn btn-dark">Добавить товар</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Форма добавления категории -->
        <div class="card mb-5 shadow">
            <div class="card-header bg-dark text-white">
                <h2 class="h4 mb-0">Добавить категорию</h2>
            </div>
            <div class="card-body">
                <form method="post" class="row g-3">
                    <input type="hidden" name="action" value="add_category">
                    
                    <div class="col-md-8">
                        <label class="form-label">Название категории</label>
                        <input type="text" name="category_name" class="form-control" required>
                    </div>
                    
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-dark">Добавить категорию</button>
                    </div>
                </form>
            </div>
        </div>

        <!-- Список категорий -->
        <div class="card mb-5 shadow">
            <div class="card-header bg-dark text-white">
                <h2 class="h4 mb-0">Список категорий</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($categories)): ?>
                    <div class="row">
                        <?php foreach ($categories as $category): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body d-flex flex-column">
                                        <h5 class="card-title"><?php echo htmlspecialchars($category['name']); ?></h5>
                                        <form method="post" class="mt-auto">
                                            <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['id']); ?>">
                                            <input type="hidden" name="action" value="delete_category">
                                            <button type="submit" class="btn btn-danger btn-sm">Удалить категорию</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">Нет категорий.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Добавленные товары -->
        <div class="card mb-5 shadow">
            <div class="card-header bg-dark text-dark">
                <h2 class="h4 mb-0">Добавленные товары</h2>
            </div>
            <div class="card-body">
                <?php if (!empty($pot)): ?>
                    <div class="row">
                        <?php foreach ($pot as $pots): ?>
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <img src="<?php echo htmlspecialchars($pots['photo']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($pots['name']); ?>" style="height: 200px; object-fit: contain;">
                                    <div class="card-body">
                                        <h5 class="card-title"><?php echo htmlspecialchars($pots['name']); ?></h5>
                                        <p class="card-text">
                                            <?php echo htmlspecialchars($pots['xar']); ?><br>
                                            <strong>Кол-во:</strong> <?php echo htmlspecialchars($pots['stock']); ?><br>
                                            <strong>Страна поставщика:</strong> <?php echo htmlspecialchars($pots['supplier_country']); ?><br>
                                            <strong>Категория:</strong> <?php echo htmlspecialchars($pots['category']); ?><br>
                                            <strong>Цена:</strong> <?php echo htmlspecialchars($pots['price']); ?> руб.
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="d-flex justify-content-between">
                                            <form method="post" class="me-2">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pots['id']); ?>">
                                                <input type="hidden" name="action" value="delete">
                                                <button type="submit" class="btn btn-danger btn-sm">Удалить</button>
                                            </form>
                                            <form method="post" action="edit.php">
                                                <input type="hidden" name="id" value="<?php echo htmlspecialchars($pots['id']); ?>">
                                                <input type="hidden" name="action" value="edit_form">
                                                <button type="submit" class="btn btn-dark btn-sm">Редактировать</button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">Нет добавленных товаров.</div>
                <?php endif; ?>
            </div>
        </div>

        <!-- Заказы пользователей -->
        <div class="card shadow">
            <div class="card-header bg-dark text-white">
                <h2 class="h4 mb-0">Заказы пользователей</h2>
            </div>
            <div class="card-body">
                <form method="get" class="row g-3 mb-4">
                    <div class="col-md-4">
                        <label for="sort" class="form-label">Сортировать по:</label>
                        <select name="sort" id="sort" class="form-select">
                            <option value="date" <?php if($order_sort_column === 'created_at') echo 'selected'; ?>>Дате</option>
                            <option value="status" <?php if($order_sort_column === 'status') echo 'selected'; ?>>Статусу</option>
                        </select>
                    </div>
                    <div class="col-md-4">
                        <label class="form-label">Порядок:</label>
                        <select name="order" class="form-select">
                            <option value="asc" <?php if($order_sort_order ==='ASC') echo 'selected'; ?>>По возрастанию</option>
                            <option value="desc" <?php if($order_sort_order === 'DESC') echo 'selected'; ?>>По убыванию</option>
                        </select>
                    </div>
                    <div class="col-md-4 d-flex align-items-end">
                        <button type="submit" class="btn btn-secondary">Сортировать</button>
                    </div>
                </form>

                <?php if (!empty($orders)): ?>
                    <div class="row">
                        <?php foreach ($orders as $order): ?>
                            <div class="col-md-6 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <h5 class="card-title">Заказ #<?php echo htmlspecialchars($order['id']); ?></h5>
                                        <p class="card-text">
                                            <strong>Пользователь:</strong> <?php echo htmlspecialchars($order['user_name']) . ' ' . htmlspecialchars($order['user_surname']); ?><br>
                                            <strong>Количество:</strong> <?php echo htmlspecialchars($order['quantity']); ?><br>
                                            <strong>Статус:</strong> 
                                            <span class="badge bg-<?php 
                                                switch($order['status']) {
                                                    case 'Отправлен': echo 'success'; break;
                                                    case 'В ожидании': echo 'warning'; break;
                                                    default: echo 'secondary';
                                                }
                                            ?>">
                                                <?php echo htmlspecialchars($order['status']); ?>
                                            </span><br>
                                            <strong>ID Товара:</strong> <?php echo htmlspecialchars($order['pot_id']); ?><br>
                                            <strong>Дата создания:</strong> <?php echo htmlspecialchars($order['created_at']); ?>
                                        </p>
                                    </div>
                                    <div class="card-footer bg-transparent">
                                        <div class="btn-group" role="group">
                                            <a href="?delete=<?php echo $order['id']; ?>" class="btn btn-outline-danger">Удалить</a>
                                            <a href="?approve=<?php echo $order['id']; ?>" class="btn btn-outline-warning">В ожидании</a>
                                            <a href="?reject=<?php echo $order['id']; ?>" class="btn btn-outline-success">Отправлен</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    </div>
                <?php else: ?>
                    <div class="alert alert-warning">Нет заказов.</div>
                <?php endif; ?>
            </div>
        </div>
    </main>

    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4 mb-md-0">
                    <h3 class="text-center">Адрес:</h3>
                    <p class="text-center">Ул. 3-я Предельная д.14, к.1</p>
                </div>
                <div class="col-md-4 mb-4 mb-md-0">
                    <h3 class="text-center">Партнёрам:</h3>
                    <p class="text-center"><a href="https://assets.finuslugi.ru/mp-assets/user-agreement.pdf">Партнерская информация</a></p>
                </div>
                <div class="col-md-4">
                    <h3 class="text-center">Наши соц. сети:</h3>
                    <div class="social-icons-footer text-center">
                        <a href="https://www.facebook.com/"><img src="./img/fb.png" alt="Facebook"></a>
                        <a href="https://vk.com/"><img src="./img/vk.png" alt="VK"></a>
                        <a href="https://www.instagram.com/"><img src="./img/inst.png" alt="Instagram"></a>
                        <a href="https://ok.ru/"><img src="./img/ok.png" alt="Odnoklassniki"></a>
                    </div>
                </div>
            </div>
        </div>
        <br>
        <hr class="hr-basic">
        <div class="container">
            <div class="row">
                <div class="col-md-6 text-center text-md-start">
                    <p>© Rich Shoes</p>
                </div>
                <div class="col-md-6 text-center text-md-end">
                    <a href="https://assets.finuslugi.ru/mp-assets/user-agreement.pdf">Пользовательское соглашение &nbsp; Политика конфиденциальности &nbsp; Карта сайта</a>
                </div>
            </div>
        </div>
    </footer>

    <script src="./js/bootstrap.bundle.min.js"></script>
    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/script.js"></script>
    <script src="./js/jquery-3.7.1.min.js"></script>
</body>
</html>