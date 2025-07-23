<?php    
require 'db.php';    
session_start();    

$isLoggedIn = isset($_SESSION['user_id']);     
$userRules = isset($_SESSION['user_rules']) ? $_SESSION['user_rules'] : ''; // Получаем права пользователя

 
// Формирование базового запроса 
$query = "SELECT id, name, price, photo, xar, stock, supplier_country, category FROM pot"; 
$params = []; 
 

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
    <link rel="stylesheet" href="./css/sales.css">
    <title>rich shoes</title>
</head>
<body>
    <header>
        <nav class="navbar navbar-expand-lg">
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
                            <a class="nav-link active" href="./sales.php">Акции</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./contacts.php">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./orders.php">Заказы</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <?php if ($isLoggedIn): ?>
                            <a href="cart.php" class="nav-link me-3">Корзина</a>
                            <?php if ($isAdmin): ?>
                                <a href="admin.php" class="nav-link me-3">Админ</a>
                            <?php endif; ?>
                            <a href="logout.php" class="nav-link me-3">Выйти</a>
                        <?php else: ?>
                            <a href="register.php" class="nav-link me-3">Регистрация</a>
                            <a href="login.php" class="nav-link me-3">Войти</a>
                        <?php endif; ?>
                        <div class="social-icons">
                            <a href="https://www.facebook.com/"><img src="./img/fb.png" alt="Facebook"></a>
                            <a href="https://vk.com/"><img src="./img/vk.png" alt="VK"></a>
                            <a href="https://www.instagram.com/"><img src="./img/inst.png" alt="Instagram"></a>
                            <a href="https://ok.ru/"><img src="./img/ok.png" alt="Odnoklassniki"></a>
                        </div>
                    </div>
                </div>
            </div>
        </nav>
        <hr class="hr-basic">
    </header>
    <main>

    <br>
                  <h1 class="d-flex justify-content-center">Дисконт</h1>
                <br>
                <div class="container py-4">
    <div class="p-5 mb-4 bg-secondary rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Новогодняяя распродажа!</h1>
        <p class="col-md-8 fs-4">Приглашаем вас на нашу специальную новогоднюю распродажу, где вы найдете невероятные скидки на лучшие модели обуви!  </p>
        <p class="col-md-8 fs-4">Не упустите возможность обновить свой гардероб к праздникам в Rich Shoes!</p>
        <a href="./tovar.php" class="a-btn">
        <button class="btn btn-dark btn-lg" type="button">Перейти к покупкам
            </a>
      </button>
      </div>
    </div>

    <div class="row align-items-md-stretch">
      <div class="col-md-6">
        <div class="h-100 p-5 text-bg-dark rounded-3">
          <h2>Акция в честь конца семестра!</h2>
          <p>При покупке одной пары обуви на вторую действует
          скидка 10%, на третью – 20%.</p>
          <a href="./tovar.php">
          <button class="btn btn-outline-light" type="button">Перейти к покупкам</button>
            </a>
        </div>
      </div>
      <div class="col-md-6">
        <div class="h-100 p-5 bg-body-tertiary border rounded-3">
          <h2>Вступайте в ряды пользователей!</h2>
          <p>Зарегестрируйтесь на нашем сайте, чтобы стать частью нашей дружной семьи!</p>
          <a href="./tovar.php">
          <button class="btn btn-outline-secondary" type="button">Перейти к покупкам</button>
            </a>
        </div>
      </div>
    </div>
  </div>
  <div class="row mb-2">
    <div class="col-md-6">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-3 d-flex flex-column position-static">
          <h3 class="mb-0">Новые поставки</h3>
          <p class="card-text mb-auto">У нас в продаже появились легендарные Timberland Premium 6 Inch Lace Up Waterproof Boot!</p>
          <a href="./tovar.php">
          <button class="btn btn-outline-secondary" type="button">Перейти к покупкам</button>
            </a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <img src="./img/1.jpg" alt="" width="110%">
        </div>
      </div>
    </div>
    <div class="col-md-6">
      <div class="row g-0 border rounded overflow-hidden flex-md-row mb-4 shadow-sm h-md-250 position-relative">
        <div class="col p-3 d-flex flex-column position-static">
          <h3 class="mb-0">Новости в соц.сетях!</h3>
          <p class="card-text mb-auto">В наших социальных сетях появляются новости о жизни магазина, переходите на наши соц.сети и подписывайтесь!</p>
          <a href="./contacts.php">
          <button class="btn btn-outline-secondary" type="button">К контактам!</button>
            </a>
        </div>
        <div class="col-auto d-none d-lg-block">
          <img src="./img/2.jpg" alt="" width="105%">
        </div>
      </div>
    </div>
  </div>




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

    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.7.1.min.js"></script>
</body>
</html>