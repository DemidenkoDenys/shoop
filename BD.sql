-- phpMyAdmin SQL Dump
-- version 3.5.1
-- http://www.phpmyadmin.net
--
-- Хост: 127.0.0.1
-- Время создания: Июн 07 2016 г., 18:43
-- Версия сервера: 5.5.25
-- Версия PHP: 5.3.13

SET SQL_MODE="NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- База данных: `shoop`
--

-- --------------------------------------------------------

--
-- Структура таблицы `admin`
--

CREATE TABLE IF NOT EXISTS `admin` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `login` char(100) NOT NULL,
  `pass` char(200) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=2 ;

--
-- Дамп данных таблицы `admin`
--

INSERT INTO `admin` (`id`, `login`, `pass`) VALUES
(1, 'admin', 'admin');

-- --------------------------------------------------------

--
-- Структура таблицы `categories`
--

CREATE TABLE IF NOT EXISTS `categories` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `image` char(200) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=4 ;

--
-- Дамп данных таблицы `categories`
--

INSERT INTO `categories` (`id`, `name`, `image`) VALUES
(1, 'Бокалы', 'бокалы.jpg'),
(2, 'Вазы', 'вазы.jpg'),
(3, 'Графины', 'графины.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `customers`
--

CREATE TABLE IF NOT EXISTS `customers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `adress` char(200) NOT NULL,
  `city` char(100) NOT NULL,
  `state` char(100) NOT NULL,
  `login` char(100) NOT NULL,
  `password` char(100) NOT NULL,
  `zip` int(9) NOT NULL,
  `country` char(100) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=3 ;

--
-- Дамп данных таблицы `customers`
--

INSERT INTO `customers` (`id`, `name`, `adress`, `city`, `state`, `login`, `password`, `zip`, `country`) VALUES
(2, 'Иванов Иван Иванович', 'ул. Ленина, 1-2', 'Суми', 'Сумская', 'ivan', 'ivan', 41009, 'Украина');

-- --------------------------------------------------------

--
-- Структура таблицы `equipments`
--

CREATE TABLE IF NOT EXISTS `equipments` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `name` char(100) NOT NULL,
  `idcategory` int(11) NOT NULL,
  `price` float(10,2) unsigned NOT NULL DEFAULT '0.00',
  `description` text,
  `image` char(100) DEFAULT NULL,
  PRIMARY KEY (`id`),
  KEY `idcategory` (`idcategory`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=8 ;

--
-- Дамп данных таблицы `equipments`
--

INSERT INTO `equipments` (`id`, `name`, `idcategory`, `price`, `description`, `image`) VALUES
(3, 'Квадратная стеклянная ваза', 2, 230.00, 'Стеклянные вазы квадратной и прямоугольной формы также могут служить основой для композиций из цветного песка, в качестве подсвечников или горшка для растений.\r\nВозможна доставка по Киеву и Украине.', '1131194.jpg'),
(4, 'NGD3VASE Ваза 30 см (max) Инфинити', 2, 373.00, 'Цветы наполняют дом свежестью, легкостью и нежностью. Вместе с вазой они создают художественную композицию и украшают комнату. Ваза Инфинити изготовлена из богемского стекла, которое отличается изысканностью, тонкостью и чистотой. Она имеет простой лаконичный дизайн и прекрасно впишется в интерьер гостиной, спальни  или кухни. Прозрачная ваза будет замечательно смотреться в помещении, выполненном в стиле минимализм. Она лишь подчеркнет естественную красоту цветов, которые преобразят вашу комнату. Ваза Инфинити станет полезным и стильным подарком для ваших близких.\r\nХарактеристики\r\n\r\nТорговая марка	Lora\r\nТип товара	Ваза\r\nКоличество в наборе	1 шт.\r\nМатериал	Богемское стекло\r\nАртикул	H50-010\r\nПодкатегория	Декоративные вазы\r\nВысота, h	30cm\r\n', '8f4c7623a565b5ff95ac3aac43f801b6.jpeg'),
(5, 'Ваза из стекла Flora', 2, 170.00, 'Ваза из стекла, стеклянная ваза серии Flora. В подарочной упаковке! Высота 300 мм, диаметр горла 125 мм, диаметр дна 125 мм. Ваза Флора замечательные вазы, что пользуются популярностью, так-как есть не просто хорошим украшением и дополнением помещения но и хорошим подарком на праздники.\r\n\r\nХарактеристики: Высота: 300 мм.	\r\n\r\n\r\n', '43856.jpg'),
(6, 'Ваза Boh.Globus 8KE64-99M87-255', 2, 309.00, 'Размер: 255 мм.\r\nМатериал: Стекло\r\nКоличество: 1 шт.', '255b.jpg');

-- --------------------------------------------------------

--
-- Структура таблицы `orderitem`
--

CREATE TABLE IF NOT EXISTS `orderitem` (
  `id` int(11) NOT NULL,
  `idequipment` int(11) NOT NULL,
  `amount` int(11) NOT NULL,
  UNIQUE KEY `uk_orderitem` (`id`,`idequipment`),
  KEY `idequipment` (`idequipment`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Дамп данных таблицы `orderitem`
--

INSERT INTO `orderitem` (`id`, `idequipment`, `amount`) VALUES
(8, 3, 4),
(8, 5, 1);

-- --------------------------------------------------------

--
-- Структура таблицы `orders`
--

CREATE TABLE IF NOT EXISTS `orders` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `idcustomer` int(11) NOT NULL,
  `date` datetime NOT NULL,
  `status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`),
  KEY `idcustomer` (`idcustomer`)
) ENGINE=InnoDB  DEFAULT CHARSET=utf8 AUTO_INCREMENT=9 ;

--
-- Дамп данных таблицы `orders`
--

INSERT INTO `orders` (`id`, `idcustomer`, `date`, `status`) VALUES
(8, 2, '2016-06-07 13:16:52', 0);

--
-- Ограничения внешнего ключа сохраненных таблиц
--

--
-- Ограничения внешнего ключа таблицы `equipments`
--
ALTER TABLE `equipments`
  ADD CONSTRAINT `equipments_ibfk_1` FOREIGN KEY (`idcategory`) REFERENCES `categories` (`id`);

--
-- Ограничения внешнего ключа таблицы `orderitem`
--
ALTER TABLE `orderitem`
  ADD CONSTRAINT `orderitem_ibfk_2` FOREIGN KEY (`id`) REFERENCES `orders` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
