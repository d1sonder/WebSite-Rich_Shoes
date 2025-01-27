<?php
require 'db.php';
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = false;

// Проверка, является ли пользователь администратором
if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];

    // Получение информации о пользователе из базы данных
    $query = "SELECT rules FROM users WHERE id = :userId LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute([':userId' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    // Проверка роли пользователя
    if ($user && $user['rules'] == 1) {
        $isAdmin = true; // Пользователь - администратор
    }
} 

//  данных горшков
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
              <a class="nav-link active" aria-current="page" href="./index.php">Главная</a>
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
        <h1 class="d-flex justify-content-center">Бренды</h1>
        <div class="d-flex justify-content-center" style="height: 1vh;">
          <hr class="centered-hr align-self-center" />
      </div>
      <br>
      <br>
      <div class="d-flex flex-row mb-3 justify-content-center">
        <a href="./tovar.php" class="p-2"><img src="./img/image 2.png" alt=""></a>
        <a href="./tovar.php" class="p-2"><img src="./img/image 3.png" alt=""></a>
          <a href="./tovar.php" class="p-2"><img src="./img/image 4.png" alt=""></a>
            <a href="./tovar.php" class="p-2"><img src="./img/image 5.png" alt=""></a>
            </div>
            <div class="d-flex flex-row mb-3 justify-content-center">
              <a href="./tovar.php" class="p-2"><img src="./img/image 6.png" alt=""></a>
                <a href="./tovar.php" class="p-2"><img src="./img/image 7.png" alt=""></a>
                  <a href="./tovar.php" class="p-2"><img src="./img/image 8.png" alt=""></a>
                    <a href="./tovar.php" class="p-2"><img src="./img/image 9.png" alt=""></a>
                      <a href="./tovar.php" class="p-2"><img src="./img/image 10.png" alt=""></a>
                  </div>
                  <br>
                  <hr class="hr-basic">
                  <br>
                  <h1 class="d-flex justify-content-center">Дисконт</h1>
                  <div class="d-flex justify-content-center" style="height: 1vh;">
                    <hr class="centered-hr align-self-center" />
                </div>
                <br>
                <div class="d-flex justify-content-center">
                  <img src="./img/image 11.png">
                </div>
                <br>
                <div class="d-flex justify-content-center" style="height: 1vh;">
                    <hr class="centered-hr align-self-center" />
                </div>
                <br>
                <div class="d-flex justify-content-center">
                  <p class="p"><a href="./sales.php">Акция!<br>
                    при покупке одной пары обуви на вторую действует
                    скидка 10%, на третью – 20%.</a></p>
                </div>
                <br>
                <hr class="hr-basic">
                <br>
                <h1 class="d-flex justify-content-center">Контакты</h1>
                <div class="d-flex justify-content-center" style="height: 1vh;">
                  <hr class="centered-hr align-self-center" />
              </div>
              <br>
              
              <div class="d-flex justify-content-center">
                <div class="d-flex flex-column mb-5" style="margin-top: 7.5%;">
                <h3 class="d-flex justify-content-center" >Наши соц. сети:</h3>
                <div class="d-flex justify-content-center">
                  <a href="https://www.facebook.com/"><img src="./img/fb.png"></a>
                  <a href="https://vk.com/"><img src="./img/vk.png"></a>
                  <a href="https://www.instagram.com/"><img src="./img/inst.png"></a>
                  <a href="https://ok.ru/"><img src="./img/ok.png"></a></div>
                </div>
                <div class="d-flex justify-content-center align-items-center" style="height: 15vh; margin-left: 5%; margin-right: 5%; margin-top: 5%;">
                  <div class="vertical-hr"></div>
              </div>
              <div style="position:relative;overflow:hidden;">
                <a href="https://yandex.ru/maps/org/rich_shoes/1184772542/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Rich Shoes</a>
                <a href="https://yandex.ru/maps/43/kazan/category/shoe_store/184107941/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Магазин обуви в Казани</a>
                <a href="https://yandex.ru/maps/43/kazan/category/bags_and_suitcases_store/184107955/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:28px;">Магазин сумок и чемоданов в Казани</a>
                <iframe src="https://yandex.ru/map-widget/v1/org/rich_shoes/1184772542/?ll=49.111408%2C55.790808&z=16" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
              </div>
              </div>

              <br>
              <hr class="hr-basic">
              <br>
              <h1 class="d-flex justify-content-center">Рецензии</h1>
              <div class="d-flex justify-content-center" style="height: 1vh;">
                <hr class="centered-hr align-self-center" />
            </div>
            <br>



<br>
<br>
            <div id="carouselExampleAutoplaying" class="carousel slide" data-bs-ride="carousel">
              <div class="carousel-inner">
                <div class="carousel-item active">
                  <div class="d-block w-100">
                    <div class="d-flex justify-content-around">
                      <h2>Юлия</h2>
                      <div class="d-flex justify-content-right">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      </div>
                    </div>
                    <br>
                    <br>
                    <div class="d-flex justify-content-center">
                    <h5 class="h5">Прекрасный магазин, с не менее 
                      прекрасными сотрудниками. Невероятно довольна 
                      покупкой!</h5>
                    </div>
                  </div>
                </div>
                <div class="carousel-item">
                  <div class="d-flex justify-content-around">
                    <h2>Армен</h2>
                    <div class="d-flex justify-content-right">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      </div>
                  </div>
                  <br>
                  <br>
                  <div class="d-flex justify-content-center">
                    <h5 class="h5">Отличный сайт, мне очень понравилось)</h5>
                    </div>
                </div>
                <div class="carousel-item">
                  <div class="d-flex justify-content-around">
                    <h2>Анастасия</h2>
                    <div class="d-flex justify-content-right">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      <img src="./img/star.png">
                      </div>
                  </div>
                  <br>
                  <br>
                  <div class="d-flex justify-content-center">
                    <h5 class="h5">Средненький сайт и сервис</h5>
                    </div>
                </div>
              </div>
              <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
                <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Previous</span>
              </button>
              <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
                <span class="carousel-control-next-icon" aria-hidden="true"></span>
                <span class="visually-hidden">Next</span>
              </button>
            </div>
            <br>
            <hr class="hr-basic">
            <br>
            <br>
    </main>
<footer class="footer">
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
</body>
</html>