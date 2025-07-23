<?php 
require 'db.php'; 
session_start(); 

if ($_SERVER['REQUEST_METHOD'] == 'POST') { 
    $name = $_POST['name']; 
    $surname = $_POST['surname']; 
    $login = $_POST['login']; 
    $email = $_POST['email']; 
    $password = $_POST['password']; 
    $password_repeat = $_POST['password_repeat']; 

    if ($password !== $password_repeat) { 
        echo "Пароли не совпадают!"; 
    } else { 
        // Хешируем пароль 
        $hashedPassword = password_hash($password, PASSWORD_DEFAULT); 

        // Вставляем данные в базу данных 
        $stmt = $db->prepare("INSERT INTO users (name, surname, login, email, password) VALUES (?, ?, ?, ?, ?)"); 
        if ($stmt->execute([$name, $surname, $login, $email, $hashedPassword])) { 
            $_SESSION['user_id'] = $db->lastInsertId(); 
            header('Location: index.php'); 
            exit(); 
        } else { 
            echo "Ошибка регистрации!"; 
        } 
    } 
} 
?> 

<!DOCTYPE html> 
<html lang="ru"> 
<head> 
    <meta charset="UTF-8"> 
    <meta name="viewport" content="width=device-width, initial-scale=1.0"> 
    <link rel="stylesheet" href="./css/bootstrap.min.css"> 
    <link rel="stylesheet" href="./css/style.css">
        <link rel="shortcut icon" href="./img/logo1.png" type="image/x-icon"> 
    <title>Регистрация</title> 
</head> 
<body>
    <main> 
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
            <h2>Регистрация</h2> 
            <form method="POST"> 
                <div class="form-group"> 
                    <label>Имя</label> 
                    <input type="text" name="name" class="form-control" required> 
                </div> 
                <div class="form-group"> 
                    <label>Фамилия</label> 
                    <input type="text" name="surname" class="form-control" required> 
                </div> 
                <div class="form-group"> 
                    <label>Логин</label> 
                    <input type="text" name="login" class="form-control" required> 
                </div> 
                <div class="form-group"> 
                    <label>Email</label> 
                    <input type="email" name="email" class="form-control" required> 
                </div> 
                <div class="form-group"> 
                    <label>Пароль</label> 
                    <input type="password" name="password" class="form-control" required> 
                </div> 
                <div class="form-group"> 
                    <label>Повторите пароль</label> 
                    <input type="password" name="password_repeat" class="form-control" required> 
                </div> 
                <button type="submit" class="btn btn-dark purple mt-4">Зарегистрироваться</button> 
            </form> 
        <p class="mb-1 fs-5 mt-5">Есть аккаунт?
        <a href="./login.php" class="link-secondary">Войти</a>
        </p>
    </div>
        </div>
    </div>

</div>  
</main>
</body> 
</html>