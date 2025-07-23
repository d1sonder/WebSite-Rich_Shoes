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
                            <a class="nav-link" href="./sales.php">Акции</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link active" href="./contacts.php">Контакты</a>
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
    <main class="contacts-page">
    <div class="container">
        <h1 class="text-center my-4">Контакты</h1>
        <div class="text-center my-4">
            <hr class="title-divider">
        </div>
        
        <div class="container col-xxl-8 px-md-4 py-5">
            <div class="row flex-lg-row-reverse align-items-center g-5 py-5">
                <div class="col-10 col-sm-8 col-lg-6">
                    <div class="map-container">
                        <a href="https://yandex.ru/maps/org/rich_shoes/1184772542/" class="map-link">Rich Shoes</a>
                        <a href="https://yandex.ru/maps/43/kazan/category/shoe_store/184107941/" class="map-link">Магазин обуви в Казани</a>
                        <a href="https://yandex.ru/maps/43/kazan/category/bags_and_suitcases_store/184107955/" class="map-link">Магазин сумок и чемоданов в Казани</a>
                        <iframe src="https://yandex.ru/map-widget/v1/org/rich_shoes/1184772542/?ll=49.111408%2C55.790808&z=16" class="map-iframe"></iframe>
                    </div>
                </div>
                <div class="col-lg-6">
                    <h2 class="display-5 fw-bold mb-3">Адрес магазина Rich Shoes</h2>
                    <p class="lead">У нас всегда рады вас видеть! Если у вас есть вопросы или вы хотите получить дополнительную информацию, не стесняйтесь обращаться к нам в наших соц.сетях</p>
                </div>
            </div>
        </div>

        <div class="contact-sections">
            <div class="contact-section">
                <div class="contact-block">
                    <h3 class="text-center">Наши соц. сети:</h3>
                    <div class="social-icons d-flex justify-content-center gap-3">
                        <a href="https://www.facebook.com/"><img src="./img/fb.png" alt="Facebook"></a>
                        <a href="https://vk.com/"><img src="./img/vk.png" alt="VK"></a>
                        <a href="https://www.instagram.com/"><img src="./img/inst.png" alt="Instagram"></a>
                        <a href="https://ok.ru/"><img src="./img/ok.png" alt="Odnoklassniki"></a>
                    </div>
                </div>
                
                <div class="divider-vertical"></div>
                
                <div class="contact-block">
                    <h3 class="text-center">Часы работы:</h3>
                    <ul class="list-group list-group-flush mx-auto" style="max-width: 300px;">
                        <li class="list-group-item">Пн. - Пт.: 10:00 - 20:00</li>
                        <li class="list-group-item">Сб.: 10:00 - 18:00</li>
                        <li class="list-group-item">Вс.: Выходной</li>
                    </ul>
                </div>
            </div>
            
            <div class="contact-section">
                <div class="contact-block">
                    <h3 class="text-center">Телефон для связи:</h3>
                    <h4 class="text-center fw-bold">+7 (999) 899-89-50</h4>
                </div>
                
                <div class="divider-vertical"></div>
                
                <div class="contact-block">
                    <h3 class="text-center">Электронная почта:</h3>
                    <h4 class="text-center fw-bold">info@richshoes.ru</h4>
                </div>
            </div>
        </div>
        
        <hr class="hr-basic my-4">
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

    <script src="./js/bootstrap.min.js"></script>
    <script src="./js/jquery-3.7.1.min.js"></script>
</body>
</html>