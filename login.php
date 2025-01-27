<?php 
require 'db.php'; 
session_start(); 
 
if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $login = $_POST['login']; 
    $password = $_POST['password']; 
 
    $stmt = $db->prepare("SELECT * FROM users WHERE login = ?"); 
    $stmt->execute([$login]); 
    $user = $stmt->fetch(PDO::FETCH_ASSOC); 

    // Проверяем пользовательля
    if ($user && password_verify($password, $user['password'])) { 
        $_SESSION['user_id'] = $user['id']; 
        $_SESSION['rules'] = $user['rules']; // Сохраняем правила в сессии
        header('Location: index.php'); 
        exit(); 
    } else { 
        echo "Неверный логин или пароль!"; 
    } 
} 
?> 
 
<!DOCTYPE html> 
<html lang="ru"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="css/bootstrap.min.css"> 
    <link rel="stylesheet" href="css/style.css">  
    <title>Вход</title> 
</head> 
<body> 
 
<div class="container-fluid">     
    <div class="row d-flex justify-content-center">     
        <a href="index.php" class="color col-md-2 d-flex justify-content-center align-items-center">  
        <img src="./img/image 1.png" alt="Логотип" class="img-fluid"> 
        </a>      
    </div>     
</div> 
    <div class="container-fluid"> 

        <div class="row d-flex justify-content-center"> 
            <div class="col-md-6"> 
            <h2>Вход</h2> 
            <form method="POST" action=""> 
                <input type="text" class="form-control mb-3" name="login"  placeholder="Логин" required> 
                <input type="password" class="form-control mb-3" name="password" placeholder="Пароль" required> 
                <button type="submit" class="btn btn-purple purple">Войти</button> 
            </form> 
            </div> 
        </div> 
    </div> 
 
<script src="js/jquery-3.7.1.min.js"></script>     
<script src="js/bootstrap.min.js"></script>  
</body> 
</html>