# Rich Shoes - Интернет-магазин обуви
[Открыть в Figma](https://www.figma.com/design/F4zgGY1TAQdfMXEPvVbDbJ/Untitled?node-id=0-1&t=7diMeXZCS7AnGp6V-1)

## 📋 Описание проекта

Rich Shoes - это современный интернет-магазин обуви с полным циклом работы:
- Каталог товаров с фильтрацией
- Система корзины и оформления заказов
- Личный кабинет пользователя
- Административная панель управления
- Система акций и скидок

## 🛠 Технологический стек

| Компонент       | Технологии                          |
|-----------------|-------------------------------------|
| **Frontend**    | HTML5, CSS3, JavaScript (ES6+)      |
| **Фреймворки**  | Bootstrap 5, jQuery                 |
| **Backend**     | PHP 7.4+                            |
| **База данных** | MySQL 5.7+                          |
| **Дополнительно** | AJAX, PDO, OpenServer            |

## 🚀 Установка и настройка

### Требования
- OpenServer (скачать [здесь](https://ospanel.io/download/))
- PHP 7.4+
- MySQL 5.7+
- Apache/Nginx

### Пошаговая установка
1. Установите OpenServer
2. Склонируйте репозиторий в `OpenServer/domains/`
3. Создайте БД `pots` через phpMyAdmin
4. Импортируйте дамп `pots.sql`
5. Настройте подключение в `db.php`:

```php
<?php
$db = new PDO("mysql:host=localhost;dbname=pots;charset=utf8", "root", "root");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
?>
```
## 📂 Полная структура проекта

```
richshoes/
├── css/                  # Стили
│   ├── bootstrap.min.css
│   ├── style.css         # Основные стили
│   └── sales.css         # Стили акций
├── js/                   # Скрипты
│   ├── bootstrap.bundle.min.js
│   ├── jquery.min.js
│   └── script.js         # Основные скрипты
├── img/                  # Изображения
├── includes/             # Включаемые PHP-файлы
├── add_to_cart.php       # Добавление в корзину (AJAX)
├── admin.php             # Админ-панель
├── cart.php              # Корзина (AJAX)
├── contacts.php          # Контакты
├── db.php                # Подключение к БД
├── delete_order.php      # Удаление заказов
├── edit.php              # Редактирование товаров
├── fetch_products.php    # Получение товаров (AJAX)
├── index.php             # Главная страница
├── login.php             # Авторизация
├── logout.php            # Выход
├── orders.php            # Заказы
├── pots.sql              # Дамп базы данных
├── register.php          # Регистрация
├── robots.txt            # Для поисковых систем
├── sales.php             # Акции
├── tovar.php             # Каталог товаров
└── update_cart.php       # Обновление корзины (AJAX)
```

## 🌟 Подробный функционал

### 👨‍💻 Пользовательская часть

| Функция               | Описание                                  | Реализация             |
|-----------------------|------------------------------------------|------------------------|
| Каталог товаров       | Фильтрация, сортировка, пагинация        | `tovar.php`, `fetch_products.php` |
| Корзина               | Добавление/удаление, изменение количества | `cart.php`, `update_cart.php` |
| Оформление заказа     | Форма заказа, подтверждение              | `orders.php`           |
| Личный кабинет        | История заказов, данные пользователя     | `orders.php`           |
| Авторизация           | Вход/регистрация, восстановление пароля  | `login.php`, `register.php` |

### 👨‍🔧 Административная часть

| Функция               | Описание                                  | Реализация             |
|-----------------------|------------------------------------------|------------------------|
| Управление товарами   | CRUD-операции с товарами                 | `admin.php`, `edit.php` |
| Управление заказами   | Просмотр, изменение статуса, удаление    | `admin.php`, `delete_order.php` |
| Статистика            | Графики продаж, аналитика                | `admin.php`            |

## 🔧 Технические особенности

### AJAX-реализации
```javascript
// Пример AJAX-запроса в cart.php
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
```

### Безопасность
- Подготовленные SQL-запросы через PDO
- Хеширование паролей (`password_hash`)
- CSRF-защита форм
- Валидация входных данных

## 📌 Важные настройки

Для production-режима:
1. Отключите отладку в `php.ini`:
   ```ini
   display_errors = Off
   error_reporting = E_ALL
   ```
2. Настройте `.htaccess`:
   ```apache
   RewriteEngine On
   RewriteCond %{HTTPS} off
   RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]
   ```

## 📞 Контакты

По вопросам работы проекта:
- Email: artyom17718@mail.ru
- Телеграм: @d1sonder
- Issues на GitHub

---

© 2025 Rich Shoes 
