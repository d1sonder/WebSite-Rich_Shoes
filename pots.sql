-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Июн 09 2025 г., 15:02
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.1.33

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- База данных: `pots`
--

-- --------------------------------------------------------

--
-- Структура таблицы `cart`
--

CREATE TABLE `cart` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `pot_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `cart`
--

INSERT INTO `cart` (`id`, `user_id`, `pot_id`, `quantity`) VALUES
(12, 4, 19, '1');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE `categories` (
  `id` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1',
  `name` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`) VALUES
('1', 'Кожа'),
('1', 'Текстиль'),
('1', 'Замша');

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE `orders` (
  `id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `quantity` varchar(255) NOT NULL,
  `status` varchar(255) NOT NULL DEFAULT 'В ожидании',
  `pot_id` int(11) NOT NULL,
  `created_at` timestamp NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `user_id`, `quantity`, `status`, `pot_id`, `created_at`) VALUES
(14, 11, '1', 'Отправлен', 26, '2024-12-11 20:28:43'),
(15, 11, '1', 'В ожидании', 32, '2024-12-11 21:19:31'),
(19, 11, '3', 'pending', 29, '2025-04-22 13:39:55');

-- --------------------------------------------------------

--
-- Структура таблицы `pot`
--

CREATE TABLE `pot` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `price` varchar(100) NOT NULL,
  `photo` varchar(255) NOT NULL,
  `xar` varchar(255) NOT NULL,
  `stock` varchar(255) NOT NULL,
  `supplier_country` varchar(255) NOT NULL,
  `category` varchar(100) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `pot`
--

INSERT INTO `pot` (`id`, `name`, `price`, `photo`, `xar`, `stock`, `supplier_country`, `category`) VALUES
(26, 'Мужские ботинки Timberland Premium 6 Inch Lace Up Waterproof Boot', '22000', 'img/timber.jpg', 'Коричневый', '5', 'Нидерланды', 'Кожа'),
(27, 'Кеды Vans Knu Skool\r\n', '9990', 'img/knu.jfif', 'Черный', '10', 'Китай', 'Замша'),
(28, 'Мужские кроссовки Nike Dunk Low Retro', '21000', 'img/dunk.jpg', 'Серый', '8', 'Индонезия', 'Кожа'),
(29, 'Кроссовки adidas Samba', '7990', 'img/samba.jpg', 'Бело-зеленые', '20', 'Китай', 'Кожа'),
(30, 'Мужские кроссовки Nike Air Max 90', '5790', 'img/air90.jpg', 'Серый', '13', 'Германия', 'Текстиль'),
(32, 'Мужские кроссовки New Balance 574', '13990', 'img/baklance.jpg', 'Темно-синий', '4', 'Китай', 'Замша');

-- --------------------------------------------------------

--
-- Структура таблицы `users`
--

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `name` varchar(100) NOT NULL,
  `surname` varchar(100) NOT NULL,
  `login` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `rules` varchar(50) NOT NULL DEFAULT 'user'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `users`
--

INSERT INTO `users` (`id`, `name`, `surname`, `login`, `email`, `password`, `rules`) VALUES
(9, 'aa', 'aa', 'aa', 'aa@mail.ru', '$2y$10$T0cxl2vWDA9ZGa96aNne0u8Nql2d/m1tOxHP3bZcbeT5Q5Gm1TdNC', 'admin'),
(11, 'admin', 'admin', 'admin', 'admin@mail.ru', '$2y$10$ZL9oGTzR49ZV3hqrCHzVPOHe4x3hW7AhZifRf.s6VqNugvIg78M8u', '1'),
(12, 'Артем', 'Артемович', 'qwerty', 'artyom17718@mail.ru', '$2y$10$KOBXAWhct6pfvCwzQx5IU.NPfWDpMlkVVVywU8qly4U3QKMTErDle', 'user');

--
-- Индексы сохранённых таблиц
--

--
-- Индексы таблицы `cart`
--
ALTER TABLE `cart`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `orders`
--
ALTER TABLE `orders`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `pot`
--
ALTER TABLE `pot`
  ADD PRIMARY KEY (`id`);

--
-- Индексы таблицы `users`
--
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT для сохранённых таблиц
--

--
-- AUTO_INCREMENT для таблицы `cart`
--
ALTER TABLE `cart`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=82;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;

--
-- AUTO_INCREMENT для таблицы `pot`
--
ALTER TABLE `pot`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=33;

--
-- AUTO_INCREMENT для таблицы `users`
--
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=13;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
