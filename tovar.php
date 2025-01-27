<?php    
require 'db.php';      
session_start();      
$isLoggedIn = isset($_SESSION['user_id']);  

// Установка значений по умолчанию  
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name'; // Сортировка по умолчанию  
$category = isset($_GET['category']) ? $_GET['category'] : '';  

// Получение уникальных категорий
$categoryQuery = "SELECT DISTINCT category FROM pot";
$categoryStmt = $db->prepare($categoryQuery);
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);

// Формирование базового запроса  
$query = "SELECT id, name, price, photo, xar, stock, supplier_country, category FROM pot";  
$params = [];  

// Фильтрация по категориям  
if (!empty($category)) {  
    $query .= " WHERE category = :category";  
    $params[':category'] = $category;  
}  

// Добавление сортировки  
$query .= " ORDER BY " . $sort;  

// Подготовленный запрос  
$stmt = $db->prepare($query); 
if (!empty($params)) { 
    $stmt->execute($params); 
} else { 
    $stmt->execute(); 
}    
$pot = $stmt->fetchAll(PDO::FETCH_ASSOC);   
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon"> 
    <link rel="stylesheet" href="./css/bootstrap.min.css">
    <link rel="stylesheet" href="./css/style.css">
    <title>rich shoes</title>
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
              <a class="nav-link active" href="./tovar.php">Товары</a>
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
          <?php if ($isLoggedIn): ?>
                <a href="logout.php" class="nav-link" style="margin-top:1.3%">Выйти</a>
                <a href="cart.php" class="nav-link" style="margin-top:1.3%">Корзина</a>
                <?php if ($isAdmin): ?>
                    <a href="admin.php" class="nav-link" style="margin-top:1.3%">Панель администратора</a>
                <?php endif; ?>
            <?php else: ?>
                <a href="register.php" class="nav-link" style="margin-top:1.3%">Регистрация</a>
                <a href="login.php" class="nav-link" style="margin-top:1.3%">Войти</a>
            <?php endif; ?>
                <div class="icons" href="#">
                <a href="https://www.facebook.com/"><img src="./img/fb.png"></a>
                <a href="https://vk.com/"><img src="./img/vk.png"></a>
                <a href="https://www.instagram.com/"><img src="./img/inst.png"></a>
                <a href="https://ok.ru/"><img src="./img/ok.png"></a>
                </div>
          </article>
          <hr class="hr-basic">
    </header>
    <main>
    <div class="container-fluid ">      
    <div class="row mt-4 ml-1">  
        <div class="col-md-3">    
            <form method="get" action="">  
                <div class="form-group">  
                    <label for="category">Фильтровать по категории:</label>  
                    <select name="category" class="form-control" onchange="this.form.submit()">  
                        <option value="">Все</option>  
                        <?php foreach ($categories as $cat): ?>  
                            <option value="<?php echo htmlspecialchars($cat); ?>" <?php if($category == $cat) echo 'selected'; ?>><?php echo htmlspecialchars($cat); ?></option>  
                        <?php endforeach; ?>  
                    </select>  
                </div>  
            </form>  
        </div>  
        <div class="col-md-3">    
            <form method="get" action="">  
                <div class="form-group">  
                    <label for="sort">Сортировать по:</label>  
                    <select name="sort" class="form-control" onchange="this.form.submit()">  
                        <option value="name" <?php if($sort == 'name') echo 'selected'; ?>>Наименованию</option>  
                        <option value="price" <?php if($sort == 'price') echo 'selected'; ?>>Цене</option>  
                        <option value="supplier_country" <?php if($sort == 'supplier_country') echo 'selected'; ?>>Стране поставщика</option>  
                    </select>  
                </div>  
            </form>  
        </div>  
    </div>  
    <div class="container-fluid">
    <div id="products-container" class="row d-flex justify-content-between">
        <?php if (!empty($pot)): ?>
            <?php foreach($pot as $pots): ?>
                <div class="col-md-3 m-2 cvet">
                    <img class="img-fluid mt-4" src="<?php echo htmlspecialchars($pots['photo']); ?>" alt="<?php echo htmlspecialchars($pots['name']); ?>">
                    <div>
                        <?php echo htmlspecialchars($pots['name']); ?><br>
                        <?php echo htmlspecialchars($pots['xar']); ?><br>
                        Кол-во: <?php echo htmlspecialchars($pots['stock']); ?><br>
                        Страна поставщика: <?php echo htmlspecialchars($pots['supplier_country']); ?><br>
                        Цена: <?php echo htmlspecialchars($pots['price']); ?> руб.
                        <form class="add-to-cart-form">
    <input type="hidden" name="pot_id" value="<?php echo $pots['id']; ?>"> 
    <input type="number" class="form-control mt-4" name="quantity" min="1" max="<?php echo $pots['stock']; ?>" value="1"> 
    <button type="submit" class="btn btn-purple purple form-control mt-4 mb-4">В корзину</button>
</form>

                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Нет добавленных товаров.</p>
        <?php endif; ?>
    </div>
</div>
        </main>




    <footer class="footer c">
  <div class="d-flex justify-content-around">
    <div class="d-flex flex-column mb-3" style="margin-top: 5%;">
      <h3 class="d-flex justify-content-center" >Адрес:</h3>
      <div class="p-2" style="font-size: 150%;"><h4 class="h4">Ул. 3-я Предельная д.14, к.1</h4></div>
      </div>
      <div class="d-flex flex-column mb-3" style="margin-top: 5%;">
        <h3 class="d-flex justify-content-center" >Партнёрам:</h3>
        <div class="p-2" style="font-size: 150%;"><a href="https://assets.finuslugi.ru/mp-assets/user-agreement.pdf" class="h4 a">Партнерская информация</a></div>
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
    <script>
$(document).ready(function() {
    // Отправка AJAX-запроса при изменении фильтра или сортировки
    $('select[name="category"], select[name="sort"]').on('change', function() {
        // Получаем значения выбранной категории и сортировки
        var category = $('select[name="category"]').val();
        var sort = $('select[name="sort"]').val();

        $.ajax({
            url: 'fetch_products.php', // Путь к скрипту, обрабатывающему запрос
            method: 'GET',
            data: { category: category, sort: sort },
            success: function(data) {
                $('#products-container').html(data); // Обновляем содержимое блока с товарами
            }
        });
    });
});
$(document).ready(function() {
    
    // Отправка формы добавления в корзину при нажатии кнопки
    $('.add-to-cart-form').on('submit', function(e) {
        e.preventDefault(); // Предотвращаем стандартное поведение формы
        
        var form = $(this); // Получаем текущую форму
        $.ajax({
            url: 'add_to_cart.php', // Путь к скрипту добавления в корзину
            method: 'POST',
            data: form.serialize(), // Сериализуем данные формы для отправки
            success: function(response) {
                // Выводим сообщение о результате добавления
                $('#products-container').append('<p>' + response + '</p>');
                // Можно добавить логику для обновления состояния корзины, если требуется
            },
            error: function() {
                alert('Ошибка при добавлении товара в корзину.');
            }
        });
    });
});
</script>


</body>
</html>