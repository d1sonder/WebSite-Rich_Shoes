<?php
   require 'db.php';
   session_start();

   if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['delete_order_id'])) {
       $orderId = $_POST['delete_order_id'];
       $userId = $_SESSION['user_id'];

       $stmt = $db->prepare("DELETE FROM orders WHERE id = ? AND user_id = ?");
       $stmt->execute([$orderId, $userId]);

       // Устанавливаем сессию сообщения
       $_SESSION['message'] = 'Заказ успешно удалён!';

       // Возвращаем список обновленных заказов
       $stmt = $db->prepare("SELECT orders.*, pot.name FROM orders JOIN pot ON orders.pot_id = pot.id WHERE orders.user_id = ? ORDER BY created_at DESC");
       $stmt->execute([$userId]);
       $orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
       
       // Генерируем HTML для обновленного списка заказов
       foreach ($orders as $order) {
           echo "<tr>";
           echo "<td>" . $order['id'] . "</td>";
           echo "<td>" . htmlspecialchars($order['name']) . "</td>";
           echo "<td>" . $order['quantity'] . "</td>";
           echo "<td>" . htmlspecialchars($order['status']) . "</td>";
           echo "<td>" . $order['created_at'] . "</td>";
           echo "<td><button class='delete-btn' data-id='" . $order['id'] . "'>Удалить</button></td>";
           echo "</tr>";
       }
   }
   ?>