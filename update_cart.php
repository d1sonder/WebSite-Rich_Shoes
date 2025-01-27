<?php
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
        
        // После выполнения действия вернуть актуальные данные товара
        $stmt = $db->prepare("SELECT name, price, quantity FROM cart WHERE user_id = ? AND pot_id = ?");        
        $stmt->execute([$userId, $pot_id]); 
        $item = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($item) {
            echo '<div class="cart-item" id="cart-item-' . htmlspecialchars($pot_id) . '">
                    <h2>' . htmlspecialchars($item['name']) . '</h2>  
                    <p>Цена: ' . htmlspecialchars($item['price']) . ' ₽</p>  
                    <p>Количество: <span class="quantity">' . htmlspecialchars($item['quantity']) . '</span></p>  
                    <div>  
                        <button class="change-quantity" data-action="increase" data-pot-id="' . htmlspecialchars($pot_id) . '">Увеличить</button>  
                        <button class="change-quantity" data-action="decrease" data-pot-id="' . htmlspecialchars($pot_id) . '" ' . ($item['quantity'] <= 0 ? 'disabled' : '') . '>Уменьшить</button>  
                        <button class="remove-item" data-pot-id="' . htmlspecialchars($pot_id) . '" onclick="return confirm(\'Вы уверены, что хотите удалить этот товар?\');">Удалить</button>  
                    </div>  
                  </div>';
        } else {
            echo 'Товар удален или количество равно нулю.';
        }
        
        exit(); // Не забываем завершить выполнение скрипта
    }
?>