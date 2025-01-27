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
    <link rel="stylesheet" href="css/bootstrap.min.css">     
    <link rel="stylesheet" href="css/style.css">        
    <title>Главная</title>            
</head>            
<body>   
<header>
        <article class="article1">
        <a href="./index.php" class="logo"><img src="./img/image 1.png"></a>
        <ul class="nav nav-underline">
            <li class="nav-item">
              <a class="nav-link" aria-current="page" href="./index.php">Главная</a>
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
                <div class="icons" href="#">
                <a href="https://www.facebook.com/"><img src="./img/fb.png"></a>
                <a href="https://vk.com/"><img src="./img/vk.png"></a>
                <a href="https://www.instagram.com/"><img src="./img/inst.png"></a>
                <a href="https://ok.ru/"><img src="./img/ok.png"></a>
                </div>
          </article>
          <hr class="hr-basic">
    </header>
    <a class="container-fluid " href="index.php"><button type="button" class="btn btn-secondary">На главную</button></a>       
    <form method="post" class="container-fluid" enctype="multipart/form-data">     
    <h1 class="container-fluid ">Добавить товар</h1>     
        <input type="hidden" name="action" value="add">       
        Название: <input type="text" name="name" required><br>         
        Цена: <input type="number" step="0.01" name="price" required><br>         
        Ссылка на изображение: <input type="file" name="photo" accept="image/*" required><br>         
        Характеристика: <input type="text" name="xar" required><br>         
        Кол-во: <input type="number" name="stock" required><br>       
        Страна поставщика: <input type="text" name="supplier_country" required><br>      
        Категория:       
        <select name="category" required>      
            <?php foreach ($categories as $category): ?>      
                <option value="<?php echo htmlspecialchars($category['name']); ?>"><?php echo htmlspecialchars($category['name']); ?></option>      
            <?php endforeach; ?>   
        </select><br>      
        <input type="submit" value="Добавить">         
    </form> 
    <!-- Форма добавления категории --> 
    <h2 class="container-fluid">Добавить категорию</h2> 
    <form method="post" class="container-fluid">         
        <input type="hidden" name="action" value="add_category">       
        Название категории: <input type="text" name="category_name" required><br>         
        <input type="submit" value="Добавить категорию">         
    </form> 

    <h2 class="container-fluid mt-4">Список категорий</h2> 
    <div class="container-fluid">     
        <div class="row">     
        <?php if (!empty($categories)): ?>        
        <?php foreach ($categories as $category): ?>        
            <div class="col-md-4 mt-5">        
                <div>        
                    <?php echo htmlspecialchars($category['name']); ?> 
                </div> 
                <form method="post">       
                    <input type="hidden" name="category_id" value="<?php echo htmlspecialchars($category['id']); ?>">       
                    <input type="hidden" name="action" value="delete_category">       
                    <button type="submit">Удалить категорию</button>       
                </form>       
            </div>        
        <?php endforeach; ?>        
        <?php else: ?>        
            <p>Нет категорий.</p>        
        <?php endif; ?>        
        </div>     
    </div>    
     
    <h2 class="mt-5 container-fluid">Добавленные товары</h2>     
    <div class="container-fluid d-flex">     
        <div class="row">     
        <?php if (!empty($pot)): ?>        
        <?php foreach ($pot as $pots): ?>        
            <div class="col-md-4 mt-5">        
                <img class="img-fluid" src="<?php echo htmlspecialchars($pots['photo']); ?>" alt="<?php echo htmlspecialchars($pots['name']); ?>">        
                <div>        
                    <?php echo htmlspecialchars($pots['name']); ?><br>        
                    <?php echo htmlspecialchars($pots['xar']); ?><br>        
                    Кол-во: <?php echo htmlspecialchars($pots['stock']); ?><br>       
                    Страна поставщика: <?php echo htmlspecialchars($pots['supplier_country']); ?><br>      
                    Категория: <?php echo htmlspecialchars($pots['category']); ?><br>      
                    Цена: <?php echo htmlspecialchars($pots['price']); ?> руб.  
                </div> 
                <form method="post">       
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pots['id']); ?>">       
                    <input type="hidden" name="action" value="delete">       
                    <button type="submit">Удалить</button>       
                </form>
                <form method="post" action="edit.php">       
                    <input type="hidden" name="id" value="<?php echo htmlspecialchars($pots['id']); ?>">       
                    <input type="hidden" name="action" value="edit_form">       
                    <button type="submit">Редактировать</button>       
                </form>       
            </div>        
        <?php endforeach; ?>        
        <?php else: ?>        
            <p>Нет добавленных товаров.</p>        
        <?php endif; ?>        
        </div>     
    </div>    
     
    <h2 class="mt-5 container-fluid">Заказы пользователей</h2>  
      
    <div class="container-fluid">  
        <form method="get" class="mb-3">  
            <label for="sort">Сортировать по:</label>  
            <select name="sort" id="sort">  
                <option value="date" <?php if($order_sort_column === 'created_at') echo 'selected'; ?>>Дате</option>  
                <option value="status" <?php if($order_sort_column === 'status') echo 'selected'; ?>>Статусу</option>  
            </select>  
            <select name="order">  
                <option value="asc" <?php if($order_sort_order ==='ASC') echo 'selected'; ?>>По возрастанию</option>  
                <option value="desc" <?php if($order_sort_order === 'DESC') echo 'selected'; ?>>По убыванию</option>  
            </select>  
            <input type="submit" value="Сортировать">  
        </form>  
    </div>  
  
    <div class="container-fluid mb-4">    
        <div class="row">      
        <?php if (!empty($orders)): ?>        
        <?php foreach ($orders as $order): ?>        
            <div class="col-md-4 mt-5">        
                <div>        
                    ID Заказа: <?php echo htmlspecialchars($order['id']); ?><br>        
                    Пользователь: <?php echo htmlspecialchars($order['user_name']) . ' ' . htmlspecialchars($order['user_surname']); ?><br>           
                    Количество: <?php echo htmlspecialchars($order['quantity']); ?><br>Статус: <?php echo htmlspecialchars($order['status']); ?><br>      
                    ID Товара: <?php echo htmlspecialchars($order['pot_id']); ?><br>      
                    Дата создания: <?php echo htmlspecialchars($order['created_at']); ?><br>     
                </div>       
      
                                <a href="?delete=<?php echo $order['id']; ?>"><button type="button" class="btn btn-outline-secondary">Удалить</button></a>
                                <a href="?approve=<?php echo $order['id']; ?>"><button type="button" class="btn btn-outline-secondary">В ожидании</button></a>
                                <a href="?reject=<?php echo $order['id']; ?>"><button type="button" class="btn btn-outline-secondary">Отправлен</button></a>    
            </div>        
        <?php endforeach; ?>        
        <?php else: ?>        
            <p>Нет заказов.</p>        
        <?php endif; ?>        
        </div>     
    </div>      
  
    <footer class="footer">
  <div class="d-flex justify-content-around">
    <div class="d-flex flex-column mb-3" style="margin-top: 5%;">
      <h3 class="d-flex justify-content-center" >Адрес:</h3>
      <div class="p-2" style="font-size: 150%;"><h4 class="h4">Ул. 3-я Предельная д.14, к.1</h4></div>
      </div>
      <div class="d-flex flex-column mb-3" style="margin-top: 5%;">
        <h3 class="d-flex justify-content-center" >Партнёрам:</h3>
        <div class="p-2" style="font-size: 150%;"><h4 class="h4">Партнерская информация</h4></div>
        </div>
        <div class="d-flex flex-column mb-3" style="margin-top: 5%;">
          <h3 class="d-flex justify-content-center" >Наши соц. сети:</h3>
          <div class="d-flex justify-content-center">
                  <a href="https://www.facebook.com/"><img src="./img/fb.png"></a>
                  <a href="https://vk.com/"><img src="./img/vk.png"></a>
                  <a href="https://www.instagram.com/"><img src="./img/inst.png"></a>
                  <a href="https://ok.ru/"><img src="./img/ok.png"></a></div>
                </div>
          </div>
  </div>
  <br>
  <hr class="hr-basic">
  <div class="d-flex justify-content-around">
    <p class="p">© Rich Shoes</p>
    <pre class="p">Пользовательское соглашение         Политика конфиденциальности          Карта сайта</pre>
  </div>
</footer>

    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.7.1.min.js"></script>
</body>
</html>