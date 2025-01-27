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

    <br>
                  <h1 class="d-flex justify-content-center">Дисконт</h1>
                  <div class="d-flex justify-content-center" style="height: 1vh;">
                    <hr class="centered-hr align-self-center" />
                </div>
                <br>
                <div class="container py-4">
    <div class="p-5 mb-4 bg-body-tertiary rounded-3">
      <div class="container-fluid py-5">
        <h1 class="display-5 fw-bold">Новогодняяя распродажа!</h1>
        <p class="col-md-8 fs-4">Приглашаем вас на нашу специальную новогоднюю распродажу, где вы найдете невероятные скидки на лучшие модели обуви!  </p>
        <p class="col-md-8 fs-4">Не упустите возможность обновить свой гардероб к праздникам в Rich Shoes!</p>
        <a href="./tovar.php" class="a-btn">
        <button class="btn btn-secondary btn-lg" type="button">Перейти к покупкам
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