<?php    
require 'db.php';    
session_start();    

$isLoggedIn = isset($_SESSION['user_id']);     
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
              <a class="nav-link" href="./sales.php">Акции</a>
            </li>
            <li class="nav-item">
                <a class="nav-link active" href="./contacts.php">Контакты</a>
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
                <h1 class="d-flex justify-content-center">Контакты</h1>
                <div class="d-flex justify-content-center" style="height: 1vh;">
                  <hr class="centered-hr align-self-center" />
              </div>
              <br>
              
              <div class="container col-xxl-8 px-4 py-5">
    <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
      <div class="col-10 col-sm-8 col-lg-6">
      <div style="position:relative;overflow:hidden;">
                <a href="https://yandex.ru/maps/org/rich_shoes/1184772542/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:0px;">Rich Shoes</a>
                <a href="https://yandex.ru/maps/43/kazan/category/shoe_store/184107941/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:14px;">Магазин обуви в Казани</a>
                <a href="https://yandex.ru/maps/43/kazan/category/bags_and_suitcases_store/184107955/?utm_medium=mapframe&utm_source=maps" style="color:#eee;font-size:12px;position:absolute;top:28px;">Магазин сумок и чемоданов в Казани</a>
                <iframe src="https://yandex.ru/map-widget/v1/org/rich_shoes/1184772542/?ll=49.111408%2C55.790808&z=16" width="560" height="400" frameborder="1" allowfullscreen="true" style="position:relative;"></iframe>
                </div>
      </div>
      <div class="col-lg-6">
        <h1 class="display-5 fw-bold text-body-emphasis lh-1 mb-3">Адрес магазина Rich Shoes</h1>
        <p class="lead">У нас всегда рады вас видеть! Если у вас есть вопросы или вы хотите получить дополнительную информацию, не стесняйтесь обращаться к нам в наших соц.сетях  
        </p>
      </div>
    </div>
  </div>



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
                <div class="d-flex flex-column mb-5" style="margin-top: 5%;">
                <h3 class="d-flex justify-content-center" >Часы работы:     </h3>
                <p class="d-flex justify-content-center" ><ul class="list-group list-group-flush">
  <li class="list-group-item">Пн. - Пт.: 10:00 - 20:00  </li>
  <li class="list-group-item">Сб.: 10:00 - 18:00  </li>
  <li class="list-group-item">Вс.: Выходной  </li>
</ul></p>
                </div>
              </div>


              <div class="d-flex justify-content-center">
              <div class="d-flex flex-column mb-5" style="margin-top: 7.5%;">
                <h3 class="d-flex justify-content-center" >Телефон для связи: </h3>
                <h4 class="d-flex justify-content-center" ><strong>+7 (999) 899-89-50</strong></h4>
                </div>

                <div class="d-flex justify-content-center align-items-center" style="height: 15vh; margin-left: 5%; margin-right: 5%; margin-top: 5%;">
                  <div class="vertical-hr"></div>
              </div>
              <div class="d-flex flex-column mb-5" style="margin-top: 7.5%;">
                <h3 class="d-flex justify-content-center" >Электронная почта:   </h3>
                <h4 class="d-flex justify-content-center" ><strong>info@richshoes.ru  </strong></h4>
                </div>
              </div>

              <br>
              <hr class="hr-basic">
              <br>

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