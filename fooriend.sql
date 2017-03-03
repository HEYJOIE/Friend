-- phpMyAdmin SQL Dump
-- version 4.6.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: 2017-03-03 11:57:03
-- 服务器版本： 5.7.14
-- PHP Version: 5.6.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `fooriend`
--

-- --------------------------------------------------------

--
-- 表的结构 `dish_category`
--

CREATE TABLE `dish_category` (
  `dish_category_id` int(11) NOT NULL,
  `dish_category_name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `dish_category`
--

INSERT INTO `dish_category` (`dish_category_id`, `dish_category_name`) VALUES
(1, 'Chinese'),
(2, 'Indian'),
(3, 'Italian'),
(4, 'Japanese'),
(5, 'Thai'),
(6, 'Malaysian'),
(7, 'Mexican'),
(8, 'Korean'),
(9, 'Pizza'),
(10, 'Mediterranean'),
(11, 'Burgers'),
(12, 'Vegetarian'),
(13, 'Dessert'),
(14, 'American'),
(15, 'European'),
(16, 'Other');

-- --------------------------------------------------------

--
-- 表的结构 `dish_list`
--

CREATE TABLE `dish_list` (
  `dish_id` int(11) NOT NULL,
  `invitation_id` int(11) NOT NULL,
  `user_id` int(11) NOT NULL,
  `dish_name` varchar(20) NOT NULL,
  `dish_description` text NOT NULL,
  `dish_category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `dish_list`
--

INSERT INTO `dish_list` (`dish_id`, `invitation_id`, `user_id`, `dish_name`, `dish_description`, `dish_category_id`) VALUES
(1, 1, 1, 'Japanese Sushi', 'Traditional Japanese main food, rice wrapped with seaweed and other ingredients like fish, corn, vegetables, etc.', 4),
(2, 2, 3, 'Pasta', 'Famous Italian food!', 3),
(3, 4, 11, 'Ribs', 'Fried ribs with black bean sauce.', 1),
(4, 6, 12, 'Lasagne', 'made with Italian meat sauce', 3),
(5, 7, 1, 'As you call!', 'I really hope someone who can make Japanese food could join. I love Sushi and Ramen so much, but I don\'t know how to cook them. I can make delicious home-made Chinese food for you,haha', 1),
(6, 8, 11, 'Grilled fish', 'Hope you will like grilled seabass.', 15),
(7, 6, 1, 'Taco', 'A taco is a traditional Mexican dish composed of a corn or wheat tortilla folded or rolled around a filling. ', 7),
(8, 6, 7, 'Kung Pao Chicken', 'A spicy stir-fry dish made with chicken, peanuts, vegetables, and chili peppers.', 1),
(17, 2, 7, 'Bibimbap', 'A bowl of warm white rice topped with namul (sautÃ©ed and seasoned vegetables) and gochujang (chili pepper paste), soy sauce, or doenjang (a fermented soybean paste).', 8),
(10, 2, 2, 'Khao khluk kapi', 'Rice stir fried with shrimp paste, served with sweetened pork and vegetables.', 5),
(11, 1, 2, 'Braised fish', 'Braised sea bass with onion and ginger.', 1),
(12, 1, 7, 'Kung Pao Chicken', 'Traditional chinese food', 1),
(13, 9, 2, 'Dumplings', 'Shall we make dumplings together?', 1),
(14, 12, 4, 'fish&chips', 'English food!', 15),
(15, 13, 10, 'Tiramisu', 'a popular coffee-flavoured Italian custard dessert. Could you please bring your favourite \r\ndessert to share?', 13);

-- --------------------------------------------------------

--
-- 表的结构 `invitation_category`
--

CREATE TABLE `invitation_category` (
  `invitation_category_id` int(11) NOT NULL,
  `invitation_category_name` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `invitation_category`
--

INSERT INTO `invitation_category` (`invitation_category_id`, `invitation_category_name`) VALUES
(1, 'Cook Together'),
(2, 'Share Food'),
(3, 'Restaurant Companion');

-- --------------------------------------------------------

--
-- 替换视图以便查看 `invitation_info`
-- (See below for the actual view)
--
CREATE TABLE `invitation_info` (
`invitation_id` int(11)
,`post_user_id` int(11)
,`title` varchar(50)
,`invitation_date` date
,`invitation_time` time
,`addressline` text
,`city` varchar(20)
,`country` varchar(20)
,`zip` varchar(20)
,`guests_number` int(11)
,`invitation_category_id` int(11)
,`post_date` date
,`pic_url` varchar(50)
,`guests_remaining` int(11)
,`is_available` tinyint(1)
,`user_id` int(11)
,`dish_name` varchar(20)
,`dish_description` text
,`dish_category_id` int(11)
,`restaurant_category_id` int(11)
);

-- --------------------------------------------------------

--
-- 表的结构 `invitation_list`
--

CREATE TABLE `invitation_list` (
  `invitation_id` int(11) NOT NULL,
  `post_user_id` int(11) NOT NULL,
  `title` varchar(50) NOT NULL,
  `invitation_date` date NOT NULL,
  `invitation_time` time NOT NULL,
  `addressline` text NOT NULL,
  `city` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `guests_number` int(11) NOT NULL,
  `invitation_category_id` int(11) NOT NULL,
  `post_date` date NOT NULL,
  `pic_url` varchar(50) NOT NULL,
  `guests_remaining` int(11) NOT NULL,
  `is_available` tinyint(1) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `invitation_list`
--

INSERT INTO `invitation_list` (`invitation_id`, `post_user_id`, `title`, `invitation_date`, `invitation_time`, `addressline`, `city`, `country`, `zip`, `guests_number`, `invitation_category_id`, `post_date`, `pic_url`, `guests_remaining`, `is_available`) VALUES
(1, 1, 'Large kitchen!', '2017-04-01', '18:00:00', 'Holyrood North Residence', 'Edinburgh', 'UK', 'EH8 8FQ', 3, 1, '2017-02-15', 'img/HolyroodNorth.jpg', 0, 0),
(2, 3, 'Come to join us!', '2017-04-08', '12:00:00', '17B Coates Gardens', 'Edinburgh', 'UK', 'EH12 5LG', 2, 1, '2017-02-22', 'img/pasta.jpg', 0, 0),
(3, 7, 'LOVAGE Restaurant', '2017-05-18', '19:00:00', '38 St Mary\'s Street', 'Edinburgh', 'UK', 'EH1 1SX', 1, 3, '2017-02-18', 'img/lovage.png', 0, 0),
(4, 11, 'Chinese cuisine to share', '2017-03-28', '17:00:00', '42 Annandale Street', 'Edinburgh', 'UK', 'EH7', 2, 2, '2017-02-16', 'img/ribs.jpg', 1, 1),
(5, 4, 'Burger & Lobster', '2017-03-31', '19:00:00', '52 Threadneedle Street', 'London', 'UK', 'EC2R 8AR', 2, 3, '2017-02-15', 'img/burger.png', 2, 1),
(6, 12, 'Mix cuisine together', '2017-03-24', '18:30:00', 'iQ Edinburgh Fountainbridge,114 Dundee Street', 'Edinburgh', 'UK', 'EH11 1AB', 4, 1, '2017-03-01', 'img/mix.png', 2, 1),
(7, 1, 'Have fun', '2017-04-02', '18:00:00', 'Holyrood North Residence', 'Edinburgh', 'UK', 'EH8 8FQ', 2, 1, '2017-02-15', 'img/cookfun.jpg', 2, 1),
(8, 11, 'Love fish', '2017-04-06', '17:00:00', '42 Annandale Street', 'Edinburgh', 'UK', 'EH7', 1, 2, '2017-02-20', 'img/fish.jpg', 0, 0),
(9, 2, 'dumplings', '2017-03-18', '16:00:00', 'No.149 Nan Qi Chang Road', 'Shanghai', 'China', '200240', 2, 2, '2017-02-28', 'img/dumpling.jpg', 1, 1),
(10, 2, 'Papilles', '2017-03-30', '18:30:00', 'FlughafenstraÃŸe 25', 'Berlin', 'Germany', '12053', 3, 3, '2017-02-28', 'img/papilles.png', 3, 1),
(11, 12, 'Weinstube am Stadtgraben', '2017-03-15', '20:00:00', 'Am Stadtgraben 6', 'Stuttgart', 'Germany', '70372', 1, 3, '2017-02-28', 'img/rfRfCrlCdMeDEblA.jpg', 1, 1),
(12, 4, 'fish&chips', '2017-03-16', '12:00:00', '221B Beck street', 'london', 'UK', 'E8 4RE', 1, 2, '2017-02-28', 'img/INTRO-FISH-CHIPS.jpg', 1, 1),
(13, 10, 'Dessert Gathering', '2017-03-12', '15:00:00', '6 Plas Y Parc', 'Cardiff', 'UK', 'CF10 3RS', 3, 1, '2017-03-01', 'img/Tiramisu.jpg', 3, 1),
(14, 10, 'Chongqing Huo Guo', '2017-04-08', '12:00:00', '8230 SE Harrison St ', 'Portland', 'USA', 'OR 97216', 2, 3, '2017-03-01', 'img/hotpot.png', 2, 1),
(22, 20, 'KFC', '2017-03-25', '12:00:00', '234 pricess street', 'Edinburgh', 'UK', 'EH1 5gh', 1, 3, '2017-03-02', 'img/KFC.jpg', 1, 1);

-- --------------------------------------------------------

--
-- 表的结构 `join_list`
--

CREATE TABLE `join_list` (
  `join_id` int(11) NOT NULL,
  `invitation_id` int(11) NOT NULL,
  `join_user_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `join_list`
--

INSERT INTO `join_list` (`join_id`, `invitation_id`, `join_user_id`) VALUES
(2, 6, 1),
(3, 6, 7),
(14, 2, 7),
(5, 2, 2),
(6, 1, 2),
(7, 3, 10),
(8, 8, 10),
(9, 1, 7),
(10, 4, 1),
(15, 9, 7);

-- --------------------------------------------------------

--
-- 表的结构 `restaurant_category`
--

CREATE TABLE `restaurant_category` (
  `invitation_id` int(11) NOT NULL,
  `restaurant_category_id` int(11) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `restaurant_category`
--

INSERT INTO `restaurant_category` (`invitation_id`, `restaurant_category_id`) VALUES
(3, 15),
(5, 14),
(10, 15),
(11, 15),
(14, 1),
(22, 14);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE `user` (
  `user_id` int(11) NOT NULL,
  `surname` varchar(20) NOT NULL,
  `givenname` varchar(20) NOT NULL,
  `username` varchar(30) NOT NULL,
  `password` varchar(30) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`user_id`, `surname`, `givenname`, `username`, `password`) VALUES
(1, 'Rawlinson', 'Julian', 'test@gmail.com', '123'),
(2, 'Shen', 'Yang', 'test2@gmail.com', '123'),
(4, 'Holmes', 'Sherlock', 'test4@111.com', '54321'),
(3, 'Walston', 'John', 'test3@yahoo.com', '12345'),
(7, 'Smith', 'Will', 'will@111.com', 'abcde'),
(10, 'bao', 'bao', 'baobao@111.com', '123'),
(11, 'Zhou', 'Zhou', 'zhou@gmail.com', 'zzz'),
(12, 'Spreen', 'David', 'ddss@123.com', '123456'),
(13, 'XINWEI', 'DU', 'Andrea', '123'),
(20, 'jj', 'kk', 'jk@yahoo.com', '123');

-- --------------------------------------------------------

--
-- 表的结构 `userdetail`
--

CREATE TABLE `userdetail` (
  `user_id` int(11) NOT NULL,
  `addressline` text NOT NULL,
  `city` varchar(20) NOT NULL,
  `zip` varchar(20) NOT NULL,
  `country` varchar(20) NOT NULL,
  `telephone` varchar(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `userdetail`
--

INSERT INTO `userdetail` (`user_id`, `addressline`, `city`, `zip`, `country`, `telephone`) VALUES
(1, '41 Holyrood Road', 'Edinburgh', 'EH8 8FF', 'UK', '07471110123'),
(4, '221B Beck street', 'London', 'E8 4RE', 'UK', '01234567899'),
(7, 'no.123 kings street', 'new york', 'es88', 'USA', '000111777'),
(20, '41 holyrood road', '', '', '', '');

-- --------------------------------------------------------

--
-- 视图结构 `invitation_info`
--
DROP TABLE IF EXISTS `invitation_info`;

CREATE ALGORITHM=UNDEFINED DEFINER=`s1534951`@`%` SQL SECURITY DEFINER VIEW `invitation_info`  AS  select `invitation_list`.`invitation_id` AS `invitation_id`,`invitation_list`.`post_user_id` AS `post_user_id`,`invitation_list`.`title` AS `title`,`invitation_list`.`invitation_date` AS `invitation_date`,`invitation_list`.`invitation_time` AS `invitation_time`,`invitation_list`.`addressline` AS `addressline`,`invitation_list`.`city` AS `city`,`invitation_list`.`country` AS `country`,`invitation_list`.`zip` AS `zip`,`invitation_list`.`guests_number` AS `guests_number`,`invitation_list`.`invitation_category_id` AS `invitation_category_id`,`invitation_list`.`post_date` AS `post_date`,`invitation_list`.`pic_url` AS `pic_url`,`invitation_list`.`guests_remaining` AS `guests_remaining`,`invitation_list`.`is_available` AS `is_available`,`dish_list`.`user_id` AS `user_id`,`dish_list`.`dish_name` AS `dish_name`,`dish_list`.`dish_description` AS `dish_description`,`dish_list`.`dish_category_id` AS `dish_category_id`,`restaurant_category`.`restaurant_category_id` AS `restaurant_category_id` from ((`invitation_list` left join `dish_list` on((`invitation_list`.`invitation_id` = `dish_list`.`invitation_id`))) left join `restaurant_category` on((`invitation_list`.`invitation_id` = `restaurant_category`.`invitation_id`))) ;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `dish_category`
--
ALTER TABLE `dish_category`
  ADD PRIMARY KEY (`dish_category_id`);

--
-- Indexes for table `dish_list`
--
ALTER TABLE `dish_list`
  ADD PRIMARY KEY (`dish_id`);

--
-- Indexes for table `invitation_category`
--
ALTER TABLE `invitation_category`
  ADD PRIMARY KEY (`invitation_category_id`);

--
-- Indexes for table `invitation_list`
--
ALTER TABLE `invitation_list`
  ADD PRIMARY KEY (`invitation_id`);

--
-- Indexes for table `join_list`
--
ALTER TABLE `join_list`
  ADD PRIMARY KEY (`join_id`);

--
-- Indexes for table `restaurant_category`
--
ALTER TABLE `restaurant_category`
  ADD PRIMARY KEY (`invitation_id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`user_id`);

--
-- Indexes for table `userdetail`
--
ALTER TABLE `userdetail`
  ADD PRIMARY KEY (`user_id`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dish_category`
--
ALTER TABLE `dish_category`
  MODIFY `dish_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=17;
--
-- 使用表AUTO_INCREMENT `dish_list`
--
ALTER TABLE `dish_list`
  MODIFY `dish_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=23;
--
-- 使用表AUTO_INCREMENT `invitation_category`
--
ALTER TABLE `invitation_category`
  MODIFY `invitation_category_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;
--
-- 使用表AUTO_INCREMENT `invitation_list`
--
ALTER TABLE `invitation_list`
  MODIFY `invitation_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=24;
--
-- 使用表AUTO_INCREMENT `join_list`
--
ALTER TABLE `join_list`
  MODIFY `join_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
--
-- 使用表AUTO_INCREMENT `user`
--
ALTER TABLE `user`
  MODIFY `user_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=21;
/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
