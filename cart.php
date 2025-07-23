<?php
require 'db.php';
session_start();
$isLoggedIn = isset($_SESSION['user_id']);

if (!$isLoggedIn) {
    header("Location: login.php"); 
    exit();
}

$userId = $_SESSION['user_id'];

// Обработка запросов на добавление, удаление или уменьшение товаров    
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'] ?? null;
    $pot_id = $_POST['pot_id'] ?? null; 

    if ($action && $pot_id) {
        if ($action === 'increase') {
            // Увеличить количество     
            $stmt = $db->prepare("UPDATE cart SET quantity = quantity + 1 WHERE user_id = ? AND pot_id = ?");       
            $stmt->execute([$userId, $pot_id]);
        } elseif ($action === 'decrease') {
            // Уменьшить количество     
            $stmt = $db->prepare("UPDATE cart SET quantity = GREATEST(quantity - 1, 0) WHERE user_id = ? AND pot_id = ?");       
            $stmt->execute([$userId, $pot_id]);
        } elseif ($action === 'delete') {
            // Удалить товар      
            $stmt = $db->prepare("DELETE FROM cart WHERE user_id = ? AND pot_id = ?");       
            $stmt->execute([$userId, $pot_id]);
        }
    }

    // Процесс оформления заказа при наличии пароля    
    if (isset($_POST['password']) && !empty($_POST['password'])) {
        $password = $_POST['password'];
        // Проверка пароля      
        $stmt = $db->prepare("SELECT password FROM users WHERE id = ?");     
        $stmt->execute([$userId]);
        $hashedPassword = $stmt->fetchColumn();

        if (password_verify($password, $hashedPassword)) {
            // Процесс  заказа     
            $stmt = $db->prepare("SELECT * FROM cart WHERE user_id = ?");     
            $stmt->execute([$userId]);     
            $cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach ($cartItems as $item) {
                if ($item['quantity'] > 0) {
                    $stmt = $db->prepare("INSERT INTO orders (user_id, pot_id, quantity, status, created_at) VALUES (?, ?, ?, 'pending', NOW())");
                    $stmt->execute([$userId, $item['pot_id'], $item['quantity']]);
                }
            }
            // Очистка корзины      
            $stmt = $db->prepare("DELETE FROM cart WHERE user_id = ?");
            $stmt->execute([$userId]);
            
            // успешный заказе     
            echo "<script>alert('Заказ успешно оформлен!'); window.location.href = 'orders.php';</script>";
        } else {
            // ошибка   
            echo "<script>alert('Неверный пароль!');</script>";
        }
    }
}

// Получаем товары     
$stmt = $db->prepare("SELECT cart.*, pot.name, pot.price FROM cart JOIN pot ON cart.pot_id = pot.id WHERE cart.user_id = ?");
$stmt->execute([$userId]);
$cartItems = $stmt->fetchAll(PDO::FETCH_ASSOC);
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
                            <a class="nav-link" href="./contacts.php">Контакты</a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" href="./orders.php">Заказы</a>
                        </li>
                    </ul>
                    <div class="d-flex align-items-center">
                        <?php if ($isLoggedIn): ?>
                            <a href="cart.php" class="nav-link me-3 active">Корзина</a>
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
    <div class="container py-5">
        <h1 class="mb-4">Корзина</h1>
        
        <?php if (empty($cartItems)): ?>
            <div class="alert alert-info" role="alert">
                Ваша корзина пуста.
            </div>
            <div class="card">
                <div class="card-body">
                    <form action="cart.php" method="post">
                        <div class="mb-3">
                            <label for="password" class="form-label">Пароль для подтверждения заказа</label>
                            <input type="password" class="form-control" id="password" name="password" required>
                        </div>
                        <button type="submit" class="btn btn-dark">Сформировать заказ</button>
                    </form>
                </div>
            </div>
        <?php else: ?>
            <div class="row">
                <div class="col-lg-8">
                    <div class="card mb-4">
                        <div class="card-body">
                            <div id="cart-items">
                                <?php foreach ($cartItems as $item): ?>
                                    <div class="cart-item border-bottom pb-3 mb-3">
                                        <div class="row">
                                            <div class="col-md-8">
                                                <h4 class="mb-1"><?php echo htmlspecialchars($item['name']); ?></h4>
                                                <p class="mb-1">Цена: <?php echo htmlspecialchars($item['price']); ?> ₽</p>
                                                <p class="mb-3">Количество: <?php echo htmlspecialchars($item['quantity']); ?></p>
                                            </div>
                                            <div class="col-md-4 d-flex align-items-center justify-content-end">
                                                <div class="btn-group" role="group">
                                                    <form method="post" class="ajax-form">
                                                        <input type="hidden" name="pot_id" value="<?php echo htmlspecialchars($item['pot_id']); ?>">
                                                        <input type="hidden" name="action" value="increase">
                                                        <button type="submit" class="btn btn-outline-secondary btn-sm">+</button>
                                                    </form>
                                                    
                                                    <form method="post" class="ajax-form">
                                                        <input type="hidden" name="pot_id" value="<?php echo htmlspecialchars($item['pot_id']); ?>">
                                                        <input type="hidden" name="action" value="decrease">
                                                        <button type="submit" class="btn btn-outline-secondary btn-sm" <?php if($item['quantity'] <= 0) echo 'disabled'; ?>>-</button>
                                                    </form>
                                                    
                                                    <form method="post" class="ajax-form">
                                                        <input type="hidden" name="pot_id" value="<?php echo htmlspecialchars($item['pot_id']); ?>">
                                                        <input type="hidden" name="action" value="delete">
                                                        <button type="submit" class="btn btn-outline-danger btn-sm" onclick="return confirm('Вы уверены, что хотите удалить этот товар?');">
                                                            <i class="bi bi-trash"></i> Удалить
                                                        </button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="col-lg-4">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Оформление заказа</h5>
                            <form action="cart.php" method="post">
                                <div class="mb-3">
                                    <label for="password" class="form-label">Подтвердите пароль</label>
                                    <input type="password" class="form-control" id="password" name="password" required>
                                </div>
                                <button type="submit" class="btn btn-dark w-100">Сформировать заказ</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>
</main>

    <footer class="footer a">
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