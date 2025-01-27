<?php  
require 'db.php';  
session_start();  

if (!isset($_SESSION['user_id'])) {  
    header("Location: login.php");  
    exit();  
}  

if ($_SERVER['REQUEST_METHOD'] === 'POST') {  
    $potsId = $_POST['pot_id'];  
    $quantity = $_POST['quantity'];  
    $userId = $_SESSION['user_id'];  

    // Проверка наличия товара  
    $stmt = $db->prepare("SELECT stock FROM pot WHERE id = ?");  
    $stmt->execute([$potsId]);  
    $pot = $stmt->fetch(PDO::FETCH_ASSOC);  

         
        if ($pot && $pot['stock'] >= $quantity) {   
            // Добавление товара в корзину   
            $stmt = $db->prepare("INSERT INTO cart (user_id, pot_id, quantity) VALUES (?, ?, ?) ON DUPLICATE KEY UPDATE quantity = quantity + ?");   
            $stmt->execute([$userId, $potsId, $quantity, $quantity]);   
            
            echo "Товар добавлен в корзину!"; // Успешный ответ для AJAX
            exit(); // Не забывайте exit после echo
        } else {   
            echo "Недостаточно товара в наличии. Доступно: " . $pot['stock'];   
        }
        
}
?>