-- phpMyAdmin SQL Dump
-- version 5.0.2
-- https://www.phpmyadmin.net/
--
-- Хост: 127.0.0.1:3306
-- Время создания: Дек 17 2024 г., 07:00
-- Версия сервера: 10.3.22-MariaDB
-- Версия PHP: 7.4.5

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
(26, 11, '2', 'Отправлен', 28, '2024-12-12 00:05:51'),
(30, 11, '3', 'pending', 29, '2024-12-17 03:56:38'),
(31, 11, '1', 'Отправлен', 26, '2024-12-17 03:56:38'),
(32, 11, '3', 'Отправлен', 29, '2024-12-17 03:56:38'),
(33, 11, '1', 'В ожидании', 26, '2024-12-17 03:56:38');

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
(26, 'Мужские ботинки Timberland Premium 6 Inch Lace Up Waterproof Boot', '22000', 'https://static.street-beat.ru/upload/iblock/97e/j96p0o5765gje0w20yqc2w0vbzwo2mgp.jpg', 'Коричневый', '5', 'Нидерланды', 'Кожа'),
(27, 'Кеды Vans Knu Skool\r\n', '9990', 'https://static.street-beat.ru/upload/iblock/23b/0nx5f3leb4w60zhkd3gwcs91eewvisju.JPG', 'Черный', '10', 'Китай', 'Замша'),
(28, 'Мужские кроссовки Nike Dunk Low Retro', '21000', 'https://static.street-beat.ru/upload/resize_cache/iblock/8f2/500_500_1/3f27b5r4jucsyn9zb3ds5s32y9ni638c.jpg', 'Серый', '8', 'Индонезия', 'Кожа'),
(29, 'Кроссовки adidas Samba', '7990', 'https://static.street-beat.ru/upload/resize_cache/iblock/4cd/500_500_1/tse7krujnklhk0v8ln4dlnjx8kab27so.jpg', 'Бело-зеленые', '20', 'Китай', 'Кожа'),
(30, 'Мужские кроссовки Nike Air Max 90', '5790', 'https://static.street-beat.ru/upload/resize_cache/iblock/6da/500_500_1/5m2jwuoiif4muqiydtod2qq4dn9r9295.jpg', 'Серый', '13', 'Германия', 'Текстиль'),
(32, 'Мужские кроссовки New Balance 574', '13990', 'https://static.street-beat.ru/upload/resize_cache/iblock/fea/500_500_1/upz3xh419oyxyyo0t8tuny550vf2jluw.jpg', 'Темно-синий', '4', 'Китай', 'Замша');

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
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=99;

--
-- AUTO_INCREMENT для таблицы `orders`
--
ALTER TABLE `orders`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

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
