<?php  
require 'db.php';  
session_start();  
$isLoggedIn = isset($_SESSION['user_id']);  

if (!$isLoggedIn) {  
    header("Location: login.php");  
    exit();  
}  

$userId = $_SESSION['user_id'];  
$stmt = $db->prepare("SELECT orders.*, pot.name FROM orders JOIN pot ON orders.pot_id = pot.id WHERE orders.user_id = ? ORDER BY created_at DESC");  
$stmt->execute([$userId]);  
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);  

// Удаление заказа
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order_id'])) {  
    $orderId = $_POST['delete_order_id'];  
    $stmt = $db->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");  
    $stmt->execute([$orderId, $userId]);

    // Установка сообщения в сессии 
    $_SESSION['message'] = 'Заказ успешно удалён!'; 

    // Перенаправление на ту же страницу 
    header("Location: " . $_SERVER['PHP_SELF']); 
    exit();  
}  
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
    <script>
        function confirmDelete(message) {
            return confirm(message);
        }
    </script>
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
                            <a class="nav-link active" href="./orders.php">Заказы</a>
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
    <main class="py-4">
    <div class="container">
        <h1 class="mb-4">Ваши заказы</h1>
        <div id="message">
            <?php
            if (isset($_SESSION['message'])) {
                echo "<div class='alert alert-success alert-dismissible fade show'>" . 
                     $_SESSION['message'] . 
                     "<button type='button' class='btn-close' data-bs-dismiss='alert' aria-label='Close'></button></div>";
                unset($_SESSION['message']);
            }
            ?>
        </div>

        <div id="orders-list">
            <?php if (empty($orders)): ?>
                <div class="alert alert-info">У вас нет заказов.</div>
            <?php else: ?>
                <div class="table-responsive">
                    <table class="table table-light table-hover table-striped">
                        <thead class="table-dark">
                            <tr>
                                <th>ID заказа</th>
                                <th>Товар</th>
                                <th class="text-nowrap">Кол-во</th>
                                <th>Статус</th>
                                <th class="text-nowrap">Дата заказа</th>
                                <th>Действия</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php foreach ($orders as $order): ?>
                                <tr>
                                    <td><?php echo $order['id']; ?></td>
                                    <td><?php echo htmlspecialchars($order['name']); ?></td>
                                    <td><?php echo $order['quantity']; ?></td>
                                    <td>
                                        <span class="badge 
                                            <?php 
                                            switch($order['status']) {
                                                case 'В ожидании': echo 'bg-warning text-dark'; break;
                                                case 'Отправлен': echo 'bg-success'; break;
                                                default: echo 'bg-secondary';
                                            }
                                            ?>">
                                            <?php echo htmlspecialchars($order['status']); ?>
                                        </span>
                                    </td>
                                    <td class="text-nowrap"><?php echo date('d.m.Y H:i', strtotime($order['created_at'])); ?></td>
                                    <td>
                                        <button class='btn btn-sm btn-outline-danger delete-btn' data-id="<?php echo $order['id']; ?>">
                                            <i class="bi bi-trash"></i> Удалить
                                        </button>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            <?php endif; ?>
        </div>
    </div>
</main>
 <footer class="footer b">
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
    <script>
    $(document).on('click', '.delete-btn', function() {
    var orderId = $(this).data('id');
    if (confirm('Вы уверены, что хотите удалить этот заказ?')) {
        $.ajax({
            type: 'POST',
            url: 'delete_order.php',
data: { delete_order_id: orderId },
            success: function(response) {
                $('#orders-list tbody').html(response);
                $('#message').html("<div class='alert alert-success'>Заказ успешно удалён!</div>");
            }
        });
    }
});
</script>
    
</body>
</html>
