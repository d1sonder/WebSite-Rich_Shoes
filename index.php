<?php
require 'db.php';
session_start();

$isLoggedIn = isset($_SESSION['user_id']);
$isAdmin = false;

if ($isLoggedIn) {
    $userId = $_SESSION['user_id'];
    $query = "SELECT rules FROM users WHERE id = :userId LIMIT 1";
    $stmt = $db->prepare($query);
    $stmt->execute([':userId' => $userId]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user && $user['rules'] == 1) {
        $isAdmin = true;
    }
} 

$query = "SELECT id, name, price, photo, xar, stock, supplier_country, category FROM pot";
$stmt = $db->prepare($query);
$stmt->execute();
$pot = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Rich Shoes - интернет-магазин качественной обуви от ведущих брендов. Широкий выбор мужской и женской с доставкой по всей России. Акции и специальные предложения.">
    <meta name="keywords" content="купить обувь, интернет магазин обуви, мужские кроссовки, женские ботинки, обувь с доставкой">
    <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon"> 
    <link href="./css/bootstrap.min.css" rel="stylesheet">
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
                            <a class="nav-link active" href="./index.php">Главная</a>
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
        <h1 class="text-center">Бренды</h1>
        <div class="d-flex justify-content-center align-items-center">
            <hr class="centered-hr">
        </div>
        <br>
        <div class="container">
            <div class="row justify-content-center brands-row">
                <div class="col-6 col-md-3 text-center mb-4">
                    <a href="./tovar.php"><img src="./img/image 2.png" alt="Brand 1" class="img-fluid"></a>
                </div>
                <div class="col-6 col-md-3 text-center mb-4">
                    <a href="./tovar.php"><img src="./img/image 3.png" alt="Brand 2" class="img-fluid"></a>
                </div>
                <div class="col-6 col-md-3 text-center mb-4">
                    <a href="./tovar.php"><img src="./img/image 4.png" alt="Brand 3" class="img-fluid"></a>
                </div>
                <div class="col-6 col-md-3 text-center mb-4">
                    <a href="./tovar.php"><img src="./img/image 5.png" alt="Brand 4" class="img-fluid"></a>
                </div>
                <div class="col-6 col-md-3 text-center mb-4">
                    <a href="./tovar.php"><img src="./img/image 6.png" alt="Brand 5" class="img-fluid"></a>
                </div>
                <div class="col-6 col-md-3 text-center mb-4">
                    <a href="./tovar.php"><img src="./img/image 7.png" alt="Brand 6" class="img-fluid"></a>
                </div>
                <div class="col-6 col-md-3 text-center mb-4">
                    <a href="./tovar.php"><img src="./img/image 10.png" alt="Brand 7" class="img-fluid"></a>
                </div>
                <div class="col-6 col-md-3 text-center mb-4">
                    <a href="./tovar.php"><img src="./img/image 9.png" alt="Brand 8" class="img-fluid"></a>
                </div>
            </div>
        </div>
        <br>
        <hr class="hr-basic">
        <br>
        <h1 class="text-center">Дисконт</h1>
        <div class="d-flex justify-content-center align-items-center">
            <hr class="centered-hr">
        </div>
        <br>
        <div class="container text-center">
            <img src="./img/image 11.png" alt="Discount" class="img-fluid discount-img">
        </div>
        <br>
        <div class="d-flex justify-content-center align-items-center">
            <hr class="centered-hr">
        </div>
        <br>
        <div class="container text-center">
            <p class="discount-text"><a href="./sales.php">Акция!<br>
                при покупке одной пары обуви на вторую действует
                скидка 10%, на третью – 20%.</a></p>
        </div>
        <br>
        <hr class="hr-basic">
        <br>
        <h1 class="text-center">Контакты</h1>
        <div class="d-flex justify-content-center align-items-center">
            <hr class="centered-hr">
        </div>
        <br>
        
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6 text-center mb-4 mb-md-0">
                    <h3>Наши соц. сети:</h3>
                    <div class="social-icons-large">
                        <a href="https://www.facebook.com/"><img src="./img/fb.png" alt="Facebook"></a>
                        <a href="https://vk.com/"><img src="./img/vk.png" alt="VK"></a>
                        <a href="https://www.instagram.com/"><img src="./img/inst.png" alt="Instagram"></a>
                        <a href="https://ok.ru/"><img src="./img/ok.png" alt="Odnoklassniki"></a>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="map-container">
                        <iframe src="https://yandex.ru/map-widget/v1/org/rich_shoes/1184772542/?ll=49.111408%2C55.790808&z=16" width="100%" height="400" frameborder="1" allowfullscreen="true"></iframe>
                    </div>
                </div>
            </div>
        </div>

        <br>
        <hr class="hr-basic">
        <br>
        <h1 class="text-center">Рецензии</h1>
        <div class="d-flex justify-content-center align-items-center">
            <hr class="centered-hr">
        </div>
        <br>

        <div class="container">
            <div id="reviewsCarousel" class="carousel slide" data-bs-ride="carousel">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="review-item">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2>Юлия</h2>
                                <div class="stars">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                </div>
                            </div>
                            <p class="review-text">Прекрасный магазин, с не менее 
                                прекрасными сотрудниками. Невероятно довольна 
                                покупкой!</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="review-item">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2>Армен</h2>
                                <div class="stars">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                </div>
                            </div>
                            <p class="review-text">Отличный сайт, мне очень понравилось)</p>
                        </div>
                    </div>
                    <div class="carousel-item">
                        <div class="review-item">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <h2>Анастасия</h2>
                                <div class="stars">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                    <img src="./img/star.png" alt="Star">
                                </div>
                            </div>
                            <p class="review-text">Средненький сайт и сервис</p>
                        </div>
                    </div>
                </div>
                <button class="carousel-control-prev" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="prev">
                    <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Previous</span>
                </button>
                <button class="carousel-control-next" type="button" data-bs-target="#reviewsCarousel" data-bs-slide="next">
                    <span class="carousel-control-next-icon" aria-hidden="true"></span>
                    <span class="visually-hidden">Next</span>
                </button>
            </div>
        </div>
        <br>
        <hr class="hr-basic">
        <br>
        <br>
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