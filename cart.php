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
          <?php if ($isLoggedIn): ?>
                <a href="logout.php" class="nav-link" style="margin-top:1.3%">Выйти</a>
                <a href="cart.php" class="nav-link" style="margin-top:1.3%; border-bottom: 2px solid black"><strong>Корзина</strong></a>
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

    <div class="container-fluid"> 
    <h1 class="ml-2">Корзина</h1> 
    <?php if (empty($cartItems)): ?> 
        <p class="ml-2">Ваша корзина пуста.</p> 
        <form action="cart.php" class="ml-2" method="post"> 
            <input type="password" class="form" name="password" placeholder="Введите пароль для подтверждения заказа" required> 
            <input type="submit" value="Сформировать заказ"> 
        </form> 
    <?php else: ?> 
        <div id="cart-items">         
            <?php foreach ($cartItems as $item): ?>         
                <div class="cart-item">         
                    <h2><?php echo htmlspecialchars($item['name']); ?></h2>         
                    <p>Цена: <?php echo htmlspecialchars($item['price']); ?> ₽</p>         
                    <p>Количество: <?php echo htmlspecialchars($item['quantity']); ?></p>         
                    <div>         
                        <form method="post" class="ajax-form" style="display:inline;">         
                            <input type="hidden" name="pot_id" value="<?php echo htmlspecialchars($item['pot_id']); ?>">         
                            <input type="hidden" name="action" value="increase">         
                            <input type="submit" value="Увеличить">         
                        </form>
                        
                        <form method="post" class="ajax-form" style="display:inline;">         
                            <input type="hidden" name="pot_id" value="<?php echo htmlspecialchars($item['pot_id']); ?>">         
                            <input type="hidden" name="action" value="decrease">         
                            <input type="submit" value="Уменьшить" <?php if($item['quantity'] <= 0) echo 'disabled'; ?>>         
                        </form>         
                        
                        <form method="post" class="ajax-form" style="display:inline;">         
                            <input type="hidden" name="pot_id" value="<?php echo htmlspecialchars($item['pot_id']); ?>">         
                            <input type="hidden" name="action" value="delete">         
                            <input type="submit" value="Удалить" onclick="return confirm('Вы уверены, что хотите удалить этот товар?');">         
                        </form>         
                    </div>         
                </div>         
            <?php endforeach; ?>      
        </div>

        <form action="cart.php" class="ml-2" method="post"> 
            <input type="password" class="form" name="password" placeholder="Введите пароль для подтверждения заказа" required> 
            <input type="submit" value="Сформировать заказ"> 
        </form> 
        
    <?php endif; ?> 

</div>

<footer class="footer c">
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
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
$(document).ready(function() {
    $('.ajax-form').on('submit', function(event) {
        event.preventDefault(); // предотвратить стандартное поведение формы
        var form = $(this);
        $.ajax({
            url: '', // адрес обработчика формы (текущий URL)
            type: 'POST',
            data: form.serialize(), // сериализуем данные формы
            success: function(response) {
                $('#cart-items').html($(response).find('#cart-items').html());
            },
            error: function() {
                alert('Ошибка при обработке запроса');
            }
        });
    });
});
</script>

</body>
</html>