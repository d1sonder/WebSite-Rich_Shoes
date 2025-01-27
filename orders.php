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
                <a class="nav-link active" href="./orders.php">Заказы</a>
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
    <div class="container">
       <h1>Ваши заказы</h1>
       <div id="message">
           <?php
           if (isset($_SESSION['message'])) {
               echo "<div class='alert alert-success'>" . $_SESSION['message'] . "</div>";
               unset($_SESSION['message']);
           }
           ?>
       </div>

       <div id="orders-list">
           <?php if (empty($orders)): ?>
               <p>У вас нет заказов.</p>
           <?php else: ?>
               <table class="table">
                   <thead>
                       <tr>
                           <th>ID заказа</th>
                           <th>Название товара</th>
                           <th>Количество</th>
                           <th>Статус</th>
                           <th>Дата заказа</th>
                           <th>Действия</th>
                       </tr>
                   </thead>
                   <tbody>
                       <?php foreach ($orders as $order): ?>
                           <tr>
                               <td><?php echo $order['id']; ?></td>
                               <td><?php echo htmlspecialchars($order['name']); ?></td>
                               <td><?php echo $order['quantity']; ?></td>
                               <td><?php echo htmlspecialchars($order['status']); ?></td>
                               <td><?php echo $order['created_at']; ?></td>
                               <td><button class='delete-btn' data-id="<?php echo $order['id']; ?>">Удалить</button></td>
                           </tr>
                       <?php endforeach; ?>
                   </tbody>
               </table>
           <?php endif; ?>
       </div>
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
