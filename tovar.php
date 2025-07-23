<?php    
require 'db.php';      
session_start();      
$isLoggedIn = isset($_SESSION['user_id']);  

// Установка значений по умолчанию  
$sort = isset($_GET['sort']) ? $_GET['sort'] : 'name'; // Сортировка по умолчанию  
$category = isset($_GET['category']) ? $_GET['category'] : '';  

// Получение уникальных категорий
$categoryQuery = "SELECT DISTINCT category FROM pot";
$categoryStmt = $db->prepare($categoryQuery);
$categoryStmt->execute();
$categories = $categoryStmt->fetchAll(PDO::FETCH_COLUMN);

// Формирование базового запроса  
$query = "SELECT id, name, price, photo, xar, stock, supplier_country, category FROM pot";  
$params = [];  

// Фильтрация по категориям  
if (!empty($category)) {  
    $query .= " WHERE category = :category";  
    $params[':category'] = $category;  
}  

// Добавление сортировки  
$query .= " ORDER BY " . $sort;  

// Подготовленный запрос  
$stmt = $db->prepare($query); 
if (!empty($params)) { 
    $stmt->execute($params); 
} else { 
    $stmt->execute(); 
}    
$pot = $stmt->fetchAll(PDO::FETCH_ASSOC);   
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
                            <a class="nav-link active" href="./tovar.php">Товары</a>
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
    <div class="container-fluid ">      
    <div class="row mt-4 ml-1">  
        <div class="col-md-3">    
            <form method="get" action="">  
                <div class="form-group">  
                    <label for="category">Фильтровать по категории:</label>  
                    <select name="category" class="form-control" onchange="this.form.submit()">  
                        <option value="">Все</option>  
                        <?php foreach ($categories as $cat): ?>  
                            <option value="<?php echo htmlspecialchars($cat); ?>" <?php if($category == $cat) echo 'selected'; ?>><?php echo htmlspecialchars($cat); ?></option>  
                        <?php endforeach; ?>  
                    </select>  
                </div>  
            </form>  
        </div>  
        <div class="col-md-3">    
            <form method="get" action="">  
                <div class="form-group">  
                    <label for="sort">Сортировать по:</label>  
                    <select name="sort" class="form-control" onchange="this.form.submit()">  
                        <option value="name" <?php if($sort == 'name') echo 'selected'; ?>>Наименованию</option>  
                        <option value="price" <?php if($sort == 'price') echo 'selected'; ?>>Цене</option>  
                        <option value="supplier_country" <?php if($sort == 'supplier_country') echo 'selected'; ?>>Стране поставщика</option>  
                    </select>  
                </div>  
            </form>  
        </div>  
    </div>  
     <!-- Блок с сообщениями -->
    <?php if (isset($_SESSION['message'])): ?>
        <div class="alert alert-success"><?= $_SESSION['message']; unset($_SESSION['message']); ?></div>
    <?php endif; ?>
    <?php if (isset($_SESSION['error'])): ?>
        <div class="alert alert-danger"><?= $_SESSION['error']; unset($_SESSION['error']); ?></div>
    <?php endif; ?>

    <div class="container-fluid">
    <div id="products-container" class="row d-flex justify-content-between">
        <?php if (!empty($pot)): ?>
            <?php foreach($pot as $abc): ?>
                <div class="col-md-3 m-2 cvet f" 
                     data-id="<?php echo $abc['id']; ?>" 
                     data-name="<?php echo htmlspecialchars($abc['name']); ?>" 
                     data-photo="<?php echo htmlspecialchars($abc['photo']); ?>" 
                     data-xar="<?php echo htmlspecialchars($abc['xar']); ?>" 
                     data-stock="<?php echo htmlspecialchars($abc['stock']); ?>" 
                     data-supplier_country="<?php echo htmlspecialchars($abc['supplier_country']); ?>" 
                     data-price="<?php echo htmlspecialchars($abc['price']); ?>">
                    <img class="img-fluid mt-4" src="<?php echo htmlspecialchars($abc['photo']); ?>" alt="<?php echo htmlspecialchars($abc['name']); ?>">
                    <div>
                        <?php echo htmlspecialchars($abc['name']); ?><br>
                        <?php echo htmlspecialchars($abc['xar']); ?><br>
                        Кол-во: <?php echo htmlspecialchars($abc['stock']); ?><br>
                        Страна поставщика: <?php echo htmlspecialchars($abc['supplier_country']); ?><br>
                        Цена: <?php echo htmlspecialchars($abc['price']); ?> руб.
                    </div>
                    <form method="post" action="add_to_cart.php">
                        <input type="hidden" name="product_id" value="<?php echo $abc['id']; ?>">
                        <div class="form-group">
                            <label for="quantity">Количество:</label>
                            <input type="number" class="form-control" name="quantity" value="1" min="1" max="<?php echo $abc['stock']; ?>">
                        </div>
                    </form>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p class="col-12">Нет товаров, соответствующих выбранным фильтрам.</p>
        <?php endif; ?>
    </div>
</div>

</div>

    <!-- Модальное окно для детальной карточки товара -->
    <div class="modal fade" id="productModal" tabindex="-1" aria-labelledby="productModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <!-- Заголовок модального окна -->
                <div class="modal-header">
                    <h5 class="modal-title" id="productModalLabel"></h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Закрыть"></button>
                </div>
                <!-- Тело модального окна -->
                <div class="modal-body">
                    <img src="" id="modalProductImage" class="img-fluid mb-3" alt="">
                    <p id="modalProductXar"></p>
                    <p><strong>Кол-во:</strong> <span id="modalProductStock"></span></p>
                    <p><strong>Страна поставщика:</strong> <span id="modalProductCountry"></span></p>
                    <p><strong>Цена:</strong> <span id="modalProductPrice"></span> руб.</p>
                    <form id="modalOrderForm">
                        <input type="hidden" name="pot_id" id="modalProductId">
                        <div class="form-group">
                            <label for="orderQuantity">Количество</label>
                            <input type="number" class="form-control" id="orderQuantity" name="quantity" min="1" value="1">
                        </div>
                        <button type="submit" class="btn btn-purple purple form-control mt-4 mb-4">В корзину</button> 
                    </form>
                </div>
            </div>
        </div>
    </div>
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
    <script src="./js/jquery-3.7.1.min.js"></script>
    <script>
$(document).ready(function(){
    // При клике на карточку товара (блок с классом "cvet")
    $('.cvet').on('click', function(){
        // Получаем данные из data-атрибутов
        let productId = $(this).data('id');
        let productName = $(this).data('name');
        let productPhoto = $(this).data('photo');
        let productXar = $(this).data('xar');
        let productStock = $(this).data('stock');
        let supplierCountry = $(this).data('supplier_country');
        let productPrice = $(this).data('price');
        // Заполняем модальное окно полученными данными
        $('#productModalLabel').text(productName);
        $('#modalProductImage').attr('src', productPhoto);
        $('#modalProductImage').attr('alt', productName);
        $('#modalProductXar').text(productXar);
        $('#modalProductStock').text(productStock);
        $('#modalProductCountry').text(supplierCountry);
        $('#modalProductPrice').text(productPrice);
        $('#modalProductId').val(productId);
        $('#orderQuantity').attr('max', productStock);
        // Показываем модальное окно
        $('#productModal').modal('show');
    });

    $('#modalOrderForm').on('submit', function(event){
        event.preventDefault();
        let formData = $(this).serialize();
        $.ajax({
            url: 'add_to_cart.php', // обработчик заказа
            method: 'POST',
            data: formData,
            success: function(response) {
                alert('Товар добавлен в корзину!');
                // Закрыть модальное окно
                $('#productModal').modal('hide');
            },
            error: function() {
                alert('Ошибка оформления заказа!');
            }
        });
    });
});
</script>


</body>
</html>