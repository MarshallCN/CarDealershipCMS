-- phpMyAdmin SQL Dump
-- version 4.3.11
-- http://www.phpmyadmin.net
--
-- Host: 127.0.0.1
-- Generation Time: 2017-03-16 18:09:26
-- 服务器版本： 5.6.24
-- PHP Version: 5.6.8

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8 */;

--
-- Database: `ferrari`
--

-- --------------------------------------------------------

--
-- 表的结构 `access`
--

CREATE TABLE IF NOT EXISTS `access` (
  `id` int(11) NOT NULL,
  `role_id` int(11) DEFAULT NULL,
  `menu_id` int(11) DEFAULT NULL,
  `access` tinyint(1) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=46 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `access`
--

INSERT INTO `access` (`id`, `role_id`, `menu_id`, `access`) VALUES
(1, 2, 8, 0),
(2, 3, 8, 0),
(3, 2, 9, 0),
(4, 3, 9, 0),
(5, 2, 11, 0),
(6, 3, 11, 0),
(7, 3, 6, 0),
(8, 3, 3, 0),
(9, 2, 2, 1),
(10, 2, 3, 1),
(11, 2, 4, 1),
(12, 2, 5, 0),
(13, 2, 6, 1),
(14, 2, 7, 1),
(15, 2, 10, 0),
(16, 2, 13, 1),
(17, 2, 14, 1),
(18, 2, 15, 1),
(19, 3, 2, 1),
(20, 3, 4, 1),
(21, 3, 5, 0),
(22, 3, 14, 1),
(23, 3, 7, 1),
(24, 3, 10, 0),
(25, 3, 13, 1),
(26, 3, 15, 1),
(27, 1, 2, 1),
(28, 1, 3, 1),
(29, 1, 4, 1),
(30, 1, 5, 1),
(31, 1, 6, 1),
(32, 1, 7, 1),
(33, 1, 8, 1),
(34, 1, 9, 1),
(35, 1, 10, 1),
(36, 1, 11, 1),
(37, 1, 13, 1),
(38, 1, 14, 1),
(39, 1, 15, 1),
(40, 1, 16, 1),
(41, 2, 16, 1),
(42, 3, 16, 1),
(43, 4, 13, 1),
(44, 4, 14, 1),
(45, 4, 15, 1);

-- --------------------------------------------------------

--
-- 表的结构 `admin_menu`
--

CREATE TABLE IF NOT EXISTS `admin_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=17 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `admin_menu`
--

INSERT INTO `admin_menu` (`id`, `name`, `url`, `hide`, `pid`) VALUES
(2, 'Content', 'index.php?page=content', 0, 0),
(3, 'Car', 'index.php?page=car', 0, 0),
(4, 'Customer', 'index.php?page=customer', 0, 0),
(5, 'System', 'index.php?page=system', 0, 0),
(6, 'Site Menu', 'index.php?page=content&action=menu', 0, 2),
(7, 'Articles', 'index.php?page=content&action=article', 0, 2),
(8, 'System Users', 'index.php?page=system&action=user', 0, 5),
(9, 'User Roles', 'index.php?page=system&action=role', 0, 5),
(10, 'System Menu', 'index.php?page=system&action=menu', 0, 5),
(11, 'Login Log', 'index.php?page=system&action=log', 0, 5),
(13, 'My Admin', 'index.php', 0, 0),
(14, 'Dashboard', 'index.php?page=dashboard', 0, 13),
(15, 'Log Out', 'index.php?exit', 0, 13),
(16, 'Contact', 'index.php?page=contact', 0, 2);

-- --------------------------------------------------------

--
-- 表的结构 `article`
--

CREATE TABLE IF NOT EXISTS `article` (
  `id` int(11) NOT NULL,
  `smenu_id` int(11) DEFAULT NULL,
  `name` varchar(300) DEFAULT NULL,
  `user_id` int(11) DEFAULT NULL,
  `author` varchar(50) DEFAULT NULL,
  `cretime` datetime DEFAULT NULL,
  `updtime` datetime DEFAULT NULL,
  `coverimg` varchar(250) NOT NULL,
  `orders` int(11) NOT NULL,
  `flag` tinyint(4) NOT NULL DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `article`
--

INSERT INTO `article` (`id`, `smenu_id`, `name`, `user_id`, `author`, `cretime`, `updtime`, `coverimg`, `orders`, `flag`) VALUES
(1, 5, 'The Ferrari GTC4Lusso Wins the &quot;Most Beautiful Supercar&quot; of the Year Grand Prize', 4, 'Ferrari.com', '2017-02-10 10:28:00', '2017-02-28 00:51:14', '1 (1).jpg', 1, 1),
(2, 5, 'California T &amp; 488 Spider Exclusive Test Drive in Hatyai Thailand', 4, 'Ferrari.com', '2017-02-10 13:00:00', '2017-02-28 00:25:08', '1 (4).jpg', 2, 1),
(3, 5, 'The F12berlinetta is the most powerful high performance Ferrari ever built', 1, 'Ferrari.com', '2017-02-13 06:14:13', NULL, '1 (6).jpg', 3, 1),
(4, 5, 'Ferrari LaFerrari Review''', 2, 'Ferrari', '2017-02-13 11:00:00', '2017-03-09 23:32:37', '1 (8).jpg', 4, 0),
(5, 6, 'This is the title of a article', 1, 'Marshall', '2017-02-15 00:37:03', '2017-02-17 01:47:17', 'file2017_02_14_05_37_03.jpg', 5, 0),
(15, 8, 'test', 2, 'test', '2017-02-18 07:17:49', '2017-03-08 17:16:03', '1 (4).jpg', 6, 0);

-- --------------------------------------------------------

--
-- 表的结构 `article_data`
--

CREATE TABLE IF NOT EXISTS `article_data` (
  `id` int(11) NOT NULL,
  `htmls` mediumtext,
  `view` int(11) NOT NULL DEFAULT '0',
  `article_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `article_data`
--

INSERT INTO `article_data` (`id`, `htmls`, `view`, `article_id`) VALUES
(1, 'The&amp;nbsp;Jury&amp;nbsp;of&amp;nbsp;the&amp;nbsp;International&amp;nbsp;Automobile&amp;nbsp;Festival,&amp;nbsp;chaired&amp;nbsp;by&amp;nbsp;internationally&amp;nbsp;renowned&amp;nbsp;architect,&amp;nbsp;Jean&amp;nbsp;Michel&amp;nbsp;Wilmotte,&amp;nbsp;awarded&amp;nbsp;the&amp;nbsp;Ferrari&amp;nbsp;GTC4Lussohe&amp;nbsp;Most&amp;nbsp;Beautiful&amp;nbsp;Supercar&amp;nbsp;of&amp;nbsp;the&amp;nbsp;Year??amp;nbsp;Grand&amp;nbsp;Prize.&amp;nbsp;This&amp;nbsp;represents&amp;nbsp;the&amp;nbsp;first&amp;nbsp;European&amp;nbsp;award&amp;nbsp;of&amp;nbsp;the&amp;nbsp;year&amp;nbsp;for&amp;nbsp;this&amp;nbsp;car.&lt;br/&gt;&lt;br/&gt;During&amp;nbsp;the&amp;nbsp;opening&amp;nbsp;ceremony&amp;nbsp;of&amp;nbsp;the&amp;nbsp;Festival&amp;nbsp;in&amp;nbsp;the&amp;nbsp;prestigious&amp;nbsp;site&amp;nbsp;of&amp;nbsp;les&amp;nbsp;Invalides&amp;nbsp;at&amp;nbsp;Paris,&amp;nbsp;Flavio&amp;nbsp;Manzoni,&amp;nbsp;Senior&amp;nbsp;Vice&amp;nbsp;President,&amp;nbsp;Ferrari&amp;nbsp;Design,&amp;nbsp;received&amp;nbsp;the&amp;nbsp;award&amp;nbsp;in&amp;nbsp;front&amp;nbsp;of&amp;nbsp;600&amp;nbsp;guests.&amp;nbsp;Flavio&amp;nbsp;Manzoni&amp;nbsp;declared:&amp;nbsp;&quot;&lt;i&gt;I&amp;nbsp;very&amp;nbsp;proud&amp;nbsp;and&amp;nbsp;honored&amp;nbsp;to&amp;nbsp;accept&amp;nbsp;this&amp;nbsp;very&amp;nbsp;prestigious&amp;nbsp;award&amp;nbsp;on&amp;nbsp;behalf&amp;nbsp;of&amp;nbsp;Ferrari&amp;nbsp;and&amp;nbsp;the&amp;nbsp;team&amp;nbsp;at&amp;nbsp;the&amp;nbsp;Ferrari&amp;nbsp;Styling&amp;nbsp;Centre.&amp;nbsp;The&amp;nbsp;Ville&amp;nbsp;Lumire&amp;nbsp;is&amp;nbsp;a&amp;nbsp;symbol&amp;nbsp;of&amp;nbsp;elegance&amp;nbsp;and&amp;nbsp;beauty&amp;nbsp;which&amp;nbsp;encapsulates&amp;nbsp;the&amp;nbsp;very&amp;nbsp;essence&amp;nbsp;of&amp;nbsp;the&amp;nbsp;Ferrari&amp;nbsp;GTC4Lusso.&lt;/i&gt;&quot;&lt;br/&gt;&lt;br/&gt;', 70, 1),
(2, 'A&amp;nbsp;lifestyle&amp;nbsp;driving&amp;nbsp;experience&amp;nbsp;for&amp;nbsp;VIPs&amp;nbsp;was&amp;nbsp;organized&amp;nbsp;by&amp;nbsp;Cavallino&amp;nbsp;Motors&amp;nbsp;in&amp;nbsp;Hatyai,&amp;nbsp;the&amp;nbsp;largest&amp;nbsp;city&amp;nbsp;of&amp;nbsp;Songkhla&amp;nbsp;Province.&amp;nbsp;This&amp;nbsp;exclusive&amp;nbsp;drive&amp;nbsp;was&amp;nbsp;an&amp;nbsp;opportunity&amp;nbsp;to&amp;nbsp;enhance&amp;nbsp;ownership&amp;nbsp;experiences&amp;nbsp;in&amp;nbsp;a&amp;nbsp;fun&amp;nbsp;and&amp;nbsp;relaxing&amp;nbsp;atmosphere&amp;nbsp;and&amp;nbsp;for&amp;nbsp;them&amp;nbsp;to&amp;nbsp;test&amp;nbsp;drive&amp;nbsp;the&amp;nbsp;California&amp;nbsp;T&amp;nbsp;and&amp;nbsp;488&amp;nbsp;Spider.&amp;nbsp;These&amp;nbsp;Ferrari&amp;nbsp;cars&amp;nbsp;explored&amp;nbsp;some&amp;nbsp;of&amp;nbsp;the&amp;nbsp;most&amp;nbsp;beautiful&amp;nbsp;roads&amp;nbsp;in&amp;nbsp;Hatyai.&amp;nbsp;The&amp;nbsp;Ferraris&amp;nbsp;travelled&amp;nbsp;along&amp;nbsp;the&amp;nbsp;scenic&amp;nbsp;route&amp;nbsp;from&amp;nbsp;Hatyai&amp;nbsp;Airport&amp;nbsp;to&amp;nbsp;Maison&amp;nbsp;De&amp;nbsp;Monet&amp;nbsp;restaurant,&amp;nbsp;through&amp;nbsp;Hatyai??&amp;nbsp;Phra&amp;nbsp;Phutthamongkol&amp;nbsp;Maharat,&amp;nbsp;stopping&amp;nbsp;at&amp;nbsp;Premium&amp;nbsp;House,&amp;nbsp;before&amp;nbsp;driving&amp;nbsp;onto&amp;nbsp;Ratana&amp;nbsp;Uthit&amp;nbsp;Road.', 20, 2),
(3, '&lt;p class=''text-center''&gt;&lt;b&gt;Hello?World&lt;/b&gt;&lt;/p&gt;&lt;br/&gt;tlksa?fjlkdsa?f&lt;br/&gt;?f?dsalkfj?dl?faf?d&lt;br/&gt;f?dsajflkjds?&lt;br/&gt;f?sa213211', 18, 3),
(4, '&lt;p class=''text-center''&gt;&lt;b&gt;Hello World&lt;/b&gt;&lt;/p&gt;\r\n&lt;p class=''text-center''&gt;This is center text\r\nfasfdsaffd\r\ndsfdsafdsaf\r\ndsfafdsafddsa&lt;/p&gt;\r\n&lt;p class=''text-right''&gt;this is right text\r\nfdsafdsfad\r\nfdsafdsafdsafdsa&lt;/p&gt;alert(1) ''\r\n&lt;p class=''text-justify''&gt;this is justify text fjslkfjsd flkds jfdslk fjds lkfjds lkfjd jflkds fs&lt;/p&gt;\r\nthis is&lt;b&gt; bold &lt;/b&gt;and &lt;i&gt;italic &lt;/i&gt;and &lt;u&gt;under line&lt;/u&gt;', 71, 4),
(5, '&lt;p class=''text-center''&gt;&lt;b&gt;Hello&amp;nbsp;World1&lt;/b&gt;&lt;/p&gt;&lt;br/&gt;tlksa?fjlkdsa?f&lt;br/&gt;?f?dsalkfj?dl?faf?d&lt;br/&gt;f?dsajflkjds?&lt;br/&gt;f?sa213211&lt;i&gt;&lt;p class=''text-right''&gt;WTF&lt;/p&gt;&lt;/i&gt;', 15, 5),
(15, '&lt;p class=''text-center''&gt;&lt;b&gt;He&lt;u&gt;&lt;i&gt;llo&amp;nbsp;World&lt;/b&gt;&lt;/p&gt;&lt;/i&gt;&lt;/u&gt;1', 0, 15);

-- --------------------------------------------------------

--
-- 表的结构 `car`
--

CREATE TABLE IF NOT EXISTS `car` (
  `id` int(11) NOT NULL,
  `name` varchar(150) DEFAULT NULL,
  `displacement` float DEFAULT NULL COMMENT 'Litre',
  `ttm` year(4) DEFAULT NULL,
  `price` double DEFAULT NULL COMMENT 'RMB',
  `engine` varchar(150) DEFAULT NULL,
  `maxpower` smallint(5) unsigned DEFAULT NULL COMMENT 'kw',
  `maxtorque` smallint(5) unsigned DEFAULT NULL COMMENT 'Nm',
  `maxrevs` int(10) unsigned DEFAULT NULL COMMENT 'rpm',
  `maxspeed` smallint(5) unsigned DEFAULT NULL COMMENT 'Km/H',
  `acce0_100` float DEFAULT NULL COMMENT 's',
  `fulecap` smallint(5) unsigned DEFAULT NULL COMMENT 'Litre',
  `comsumption` float unsigned DEFAULT NULL COMMENT 'L/Km',
  `co2` smallint(5) unsigned DEFAULT NULL COMMENT 'gr/Km',
  `gearbox` varchar(150) DEFAULT NULL,
  `length` smallint(5) unsigned DEFAULT NULL COMMENT 'mm',
  `width` smallint(5) unsigned DEFAULT NULL COMMENT 'mm',
  `height` smallint(5) unsigned DEFAULT NULL COMMENT 'mm',
  `wheelbase` smallint(5) unsigned DEFAULT NULL COMMENT 'mm',
  `weight` smallint(5) unsigned DEFAULT NULL COMMENT 'Kg',
  `thumb` varchar(100) NOT NULL DEFAULT 'noimg.jpg',
  `flag` tinyint(4) DEFAULT '0',
  `orders` int(11) DEFAULT NULL,
  `hide` tinyint(4) DEFAULT '0'
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `car`
--

INSERT INTO `car` (`id`, `name`, `displacement`, `ttm`, `price`, `engine`, `maxpower`, `maxtorque`, `maxrevs`, `maxspeed`, `acce0_100`, `fulecap`, `comsumption`, `co2`, `gearbox`, `length`, `width`, `height`, `wheelbase`, `weight`, `thumb`, `flag`, `orders`, `hide`) VALUES
(1, 'LaFerrari', 6.3, 2014, 22500000, '65-deg.V12', 588, 664, 9250, 350, 3, 93, 15, 340, '7-speed F1 Dual-Clutch', 4702, 1992, 1116, 2650, 1420, 'laferrari.jpg', 1, 1, 0),
(2, 'F12 Berlinetta', 6.3, 2013, 5308000, '65-deg.V12', 545, 690, 8700, 340, 3.1, 92, 15, 350, '7-speed F1 Dual-Clutch', 4618, 1942, 1273, 2720, 1525, 'f12berlinetta.jpg', 1, 2, 0),
(3, '488 Spider', 3.9, 2016, 3888000, '90-deg.V8 Turbo', 492, 760, 8000, 325, 3, 78, 11.4, 160, '7-speed F1 Dual-Clutch Transmission', 4568, 1952, 1211, 2650, 1420, '488spider.jpg', 0, 3, 0),
(4, '488 GTB', 3.9, 2015, 3388000, '90-deg.V8 Turbo', 492, 760, 8000, 330, 3, 78, 11.4, 260, '7-speed F1 Dual-Clutch', 4568, 1952, 1213, 2650, 1370, '488gtb.jpg', 0, 4, 0),
(5, 'GTC4 Lusso', 6.3, 2017, 5388000, '65-deg.V12', 507, 697, 8250, 335, 3.4, 91, 15.3, 350, '7-speed F1 DCT', 4922, 1980, 1383, 2990, 1790, 'gtc4lusso.jpg', 1, 5, 0),
(6, 'GTC4 Lusso T', 3.9, 2017, 3588000, '90-deg.V8 Turbo', 448, 760, 7500, 320, 3.5, 91, 11.6, 265, '7-speed F1 DCT', 4922, 1980, 1383, 2990, 1740, 'gtc4lussot.jpg', 0, 6, 0),
(7, 'California T', 3.9, 2015, 3088000, '90-deg.V8', 412, 755, 7500, 316, 3.6, 78, 10.5, 250, '7-speed F1 Dual-Clutch Reverse', 4570, 1910, 1322, 2670, 1730, 'californiat.jpg', 0, 7, 0),
(8, 'Cartest''', 5, 2017, 23333, '1Engine', 0, 1, 0, 3, 0, 1, 0, 33, '123', 0, 1, 0, 0, 3, 'noimg.jpg', 0, 8, 1);

-- --------------------------------------------------------

--
-- 表的结构 `contact`
--

CREATE TABLE IF NOT EXISTS `contact` (
  `id` int(11) NOT NULL,
  `name` varchar(50) DEFAULT NULL,
  `value` varchar(200) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `contact`
--

INSERT INTO `contact` (`id`, `name`, `value`, `pid`) VALUES
(1, 'Company', 'Chengdu Ferrari Dealership', 6),
(2, 'Address', '1234 XXX Avenue Chengdu', 6),
(3, 'Tel', '123456789', 6),
(4, 'Email', 'cdFerrari@gmail.com', 6),
(5, 'WeChat', 'FerrariCD', 6),
(6, 'info', '', 0),
(7, 'time', '', 0),
(9, 'Monday', '9 am - 6 pm', 7),
(10, 'Tuesday', '9 am - 6 pm', 7),
(11, 'Wednesday', '9 am - 6 pm', 7),
(12, 'Thursday', '9 am - 6 pm', 7),
(13, 'Friday', '9 am - 6 pm', 7),
(14, 'Saturday', '10 am - 4 pm', 7),
(15, 'Sunday', 'Closed', 7);

-- --------------------------------------------------------

--
-- 表的结构 `drive`
--

CREATE TABLE IF NOT EXISTS `drive` (
  `id` int(11) NOT NULL,
  `cus_id` int(11) DEFAULT NULL,
  `car_id` int(11) NOT NULL,
  `appoint` datetime DEFAULT NULL,
  `status_id` tinyint(4) DEFAULT NULL,
  `emp_id` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=12 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `drive`
--

INSERT INTO `drive` (`id`, `cus_id`, `car_id`, `appoint`, `status_id`, `emp_id`) VALUES
(4, 8, 5, '2017-02-15 03:34:00', 1, 3),
(5, 8, 6, '2017-02-26 04:03:00', 1, 1),
(6, 3, 3, '2017-02-25 21:32:00', 1, 1),
(7, 3, 7, '2017-02-11 00:00:00', 1, 3),
(8, 1, 1, '2017-03-15 00:00:00', 1, 1),
(10, 1, 4, '2017-03-16 12:02:00', NULL, NULL),
(11, 3, 1, '2017-03-31 21:02:00', NULL, NULL);

-- --------------------------------------------------------

--
-- 表的结构 `loginlog`
--

CREATE TABLE IF NOT EXISTS `loginlog` (
  `id` int(11) NOT NULL,
  `loginip` varchar(30) DEFAULT NULL,
  `username` varchar(20) DEFAULT NULL,
  `trypwd` varchar(20) DEFAULT NULL,
  `logintime` datetime DEFAULT NULL,
  `success` tinyint(1) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=185 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `loginlog`
--

INSERT INTO `loginlog` (`id`, `loginip`, `username`, `trypwd`, `logintime`, `success`) VALUES
(1, '::1', 'admin', 'bda1630a9b49f083d784', '2017-02-17 00:45:29', 1),
(2, '192.168.99.3', 'administrator', ''' or 1=1 --+', '2017-02-17 00:46:39', 0),
(3, '192.168.99.3', ''' or 1=1 #', '1234', '2017-02-17 00:46:55', 0),
(4, '127.0.0.1', 'admin', 'bda1630a9b49f083d784', '2017-02-17 01:22:33', 1),
(30, '192.168.99.182', 'admin', '1234', '2017-02-18 03:05:01', 0),
(31, '192.168.99.182', 'admin', 'bda1630a9b49f083d784', '2017-02-18 03:05:05', 1),
(154, '::1', 'manager1', '978f145e82fee41e2bae', '2017-03-12 16:28:38', 1),
(155, '::1', 'worker1', '50903350968fbfccb515', '2017-03-12 16:32:24', 1),
(156, '::1', 'worker2', '019fd8e9f59638d77f78', '2017-03-12 16:32:30', 1),
(172, '::1', 'manager1', '978f145e82fee41e2bae', '2017-03-14 16:06:34', 1),
(175, '::1', 'admin', 'bda1630a9b49f083d784', '2017-03-14 20:32:36', 1),
(176, '::1', 'admin', '1a805c90b581f8d038e8', '2017-03-14 20:35:59', 1),
(177, '::1', 'admin', 'bda1630a9b49f083d784', '2017-03-14 20:36:16', 1),
(178, '::1', 'admin', 'bda1630a9b49f083d784', '2017-03-16 20:39:45', 1),
(179, '::1', 'admin', 'bda1630a9b49f083d784', '2017-03-16 23:36:15', 1),
(180, '::1', 'worker1', '50903350968fbfccb515', '2017-03-16 23:49:00', 1),
(181, '::1', 'manager1', '978f145e82fee41e2bae', '2017-03-16 23:49:13', 1),
(182, '::1', 'worker1', '50903350968fbfccb515', '2017-03-17 00:02:04', 1),
(183, '::1', 'test1', '7fa33cea165c6832f4a9', '2017-03-17 00:04:15', 1),
(184, '::1', 'admin', 'bda1630a9b49f083d784', '2017-03-17 00:39:14', 1);

-- --------------------------------------------------------

--
-- 表的结构 `member`
--

CREATE TABLE IF NOT EXISTS `member` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `avatar` varchar(50) NOT NULL DEFAULT 'head1.png',
  `email` varchar(50) DEFAULT NULL,
  `phone` varchar(50) DEFAULT NULL,
  `address` varchar(100) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `member`
--

INSERT INTO `member` (`id`, `username`, `pwd`, `avatar`, `email`, `phone`, `address`) VALUES
(1, 'visitor1', '81dc9bdb52d04dc20036dbd8313ed055', 'head3.png', 'visitor1@gmail.com', '1234''', '1234'),
(3, 'david', '81dc9bdb52d04dc20036dbd8313ed055', 'head4.png', '123@email.com', '1244', '123'),
(5, 'visitor3', '81dc9bdb52d04dc20036dbd8313ed055', 'head1.png', '1@com', '123', '12343'),
(8, 'visitor2', '81dc9bdb52d04dc20036dbd8313ed055', 'head1.png', '123@gmail.com', '123', '123');

-- --------------------------------------------------------

--
-- 表的结构 `role`
--

CREATE TABLE IF NOT EXISTS `role` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `role`
--

INSERT INTO `role` (`id`, `name`, `pid`) VALUES
(1, 'Super Administrator', 0),
(2, 'Manager', 1),
(3, 'Worker', 2),
(4, 'Unvalidated', 4);

-- --------------------------------------------------------

--
-- 表的结构 `site_menu`
--

CREATE TABLE IF NOT EXISTS `site_menu` (
  `id` int(11) NOT NULL,
  `name` varchar(20) DEFAULT NULL,
  `pid` int(11) DEFAULT NULL,
  `cretime` datetime DEFAULT NULL,
  `updtime` datetime DEFAULT NULL,
  `url` varchar(100) DEFAULT NULL,
  `hide` tinyint(1) DEFAULT NULL,
  `orders` int(11) DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=9 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `site_menu`
--

INSERT INTO `site_menu` (`id`, `name`, `pid`, `cretime`, `updtime`, `url`, `hide`, `orders`) VALUES
(1, 'Home', 0, '2017-02-06 17:56:30', '2017-03-09 17:01:17', 'index.php', 0, 1),
(2, 'Cars', 0, '2017-02-06 17:59:48', '0000-00-00 00:00:00', 'index.php?page=car', 0, 2),
(3, 'Article', 0, '2017-02-06 18:01:57', '2017-03-09 17:01:46', 'index.php?page=list', 0, 3),
(4, 'Contact', 0, '2017-02-06 18:02:46', '0000-00-00 00:00:00', 'index.php?page=contact', 0, 4),
(5, 'News &amp; Event', 3, '2017-02-06 18:04:52', '2017-03-09 17:05:51', 'index.php?page=list&mid=5', 0, 5),
(6, 'Brand Story', 3, '2017-02-06 18:23:42', '0000-00-00 00:00:00', 'index.php?page=list&mid=6', 0, 6),
(7, 'Aftersale', 3, '2017-02-17 00:00:00', '2017-03-09 02:12:30', 'index.php?page=list&mid=7', 0, 7),
(8, 'testMenu''', 3, '2017-02-17 01:26:42', '2017-03-14 00:44:24', 'index.php?page=list&mid=8', 1, 8);

-- --------------------------------------------------------

--
-- 表的结构 `user`
--

CREATE TABLE IF NOT EXISTS `user` (
  `id` int(11) NOT NULL,
  `username` varchar(20) DEFAULT NULL,
  `pwd` varchar(50) DEFAULT NULL,
  `salt` varchar(50) NOT NULL,
  `fname` varchar(20) DEFAULT NULL,
  `lname` varchar(20) DEFAULT NULL,
  `role_id` int(11) DEFAULT NULL,
  `tel` varchar(30) DEFAULT NULL,
  `email` varchar(30) DEFAULT NULL,
  `lastloginip` varchar(30) DEFAULT NULL,
  `lastlogindate` datetime DEFAULT NULL
) ENGINE=InnoDB AUTO_INCREMENT=6 DEFAULT CHARSET=latin1;

--
-- 转存表中的数据 `user`
--

INSERT INTO `user` (`id`, `username`, `pwd`, `salt`, `fname`, `lname`, `role_id`, `tel`, `email`, `lastloginip`, `lastlogindate`) VALUES
(1, 'admin', 'bda1630a9b49f083d784709dad92ec60', 'oKm0lY2R', 'Marshal', 'Liu''', 1, '12300444569', 'mars@gmail.com', '::1', '2017-03-16 23:36:15'),
(2, 'manager1', '978f145e82fee41e2bae6de5e97538f1', 'bxlP7a+C', 'Kev', 'He', 2, '12345', '12344@gmail.com', '::1', '2017-03-14 16:06:34'),
(3, 'worker1', '50903350968fbfccb51515c226cf9e5c', '6KlBSuTL', 'Tob', 'Mao', 3, '123455', '1324@gmail.com', '::1', '2017-03-16 23:49:00'),
(4, 'worker2', '019fd8e9f59638d77f78776c8f6d968d', '07tupg33', 'Tomas', 'Li', 3, '1', '1@e.com', '', '0000-00-00 00:00:00');

--
-- Indexes for dumped tables
--

--
-- Indexes for table `access`
--
ALTER TABLE `access`
  ADD PRIMARY KEY (`id`), ADD KEY `role_id` (`role_id`), ADD KEY `menu_id` (`menu_id`);

--
-- Indexes for table `admin_menu`
--
ALTER TABLE `admin_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `article`
--
ALTER TABLE `article`
  ADD PRIMARY KEY (`id`), ADD KEY `smenu_id` (`smenu_id`), ADD KEY `user_id` (`user_id`);

--
-- Indexes for table `article_data`
--
ALTER TABLE `article_data`
  ADD PRIMARY KEY (`id`), ADD KEY `article_id` (`article_id`);

--
-- Indexes for table `car`
--
ALTER TABLE `car`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `contact`
--
ALTER TABLE `contact`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `drive`
--
ALTER TABLE `drive`
  ADD PRIMARY KEY (`id`), ADD KEY `cus_id` (`cus_id`), ADD KEY `car_id` (`car_id`), ADD KEY `emp_id` (`emp_id`);

--
-- Indexes for table `loginlog`
--
ALTER TABLE `loginlog`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `member`
--
ALTER TABLE `member`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `role`
--
ALTER TABLE `role`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `site_menu`
--
ALTER TABLE `site_menu`
  ADD PRIMARY KEY (`id`);

--
-- Indexes for table `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`), ADD KEY `role_id` (`role_id`);

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `access`
--
ALTER TABLE `access`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=46;
--
-- AUTO_INCREMENT for table `admin_menu`
--
ALTER TABLE `admin_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=17;
--
-- AUTO_INCREMENT for table `article`
--
ALTER TABLE `article`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `article_data`
--
ALTER TABLE `article_data`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `car`
--
ALTER TABLE `car`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `contact`
--
ALTER TABLE `contact`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=16;
--
-- AUTO_INCREMENT for table `drive`
--
ALTER TABLE `drive`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=12;
--
-- AUTO_INCREMENT for table `loginlog`
--
ALTER TABLE `loginlog`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=185;
--
-- AUTO_INCREMENT for table `member`
--
ALTER TABLE `member`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `role`
--
ALTER TABLE `role`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=5;
--
-- AUTO_INCREMENT for table `site_menu`
--
ALTER TABLE `site_menu`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=9;
--
-- AUTO_INCREMENT for table `user`
--
ALTER TABLE `user`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT,AUTO_INCREMENT=6;
--
-- 限制导出的表
--

--
-- 限制表 `access`
--
ALTER TABLE `access`
ADD CONSTRAINT `access_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`),
ADD CONSTRAINT `access_ibfk_2` FOREIGN KEY (`menu_id`) REFERENCES `admin_menu` (`id`);

--
-- 限制表 `article`
--
ALTER TABLE `article`
ADD CONSTRAINT `article_ibfk_1` FOREIGN KEY (`smenu_id`) REFERENCES `site_menu` (`id`),
ADD CONSTRAINT `article_ibfk_2` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- 限制表 `article_data`
--
ALTER TABLE `article_data`
ADD CONSTRAINT `article_data_ibfk_1` FOREIGN KEY (`article_id`) REFERENCES `article` (`id`) ON DELETE CASCADE;

--
-- 限制表 `drive`
--
ALTER TABLE `drive`
ADD CONSTRAINT `drive_ibfk_1` FOREIGN KEY (`cus_id`) REFERENCES `member` (`id`) ON DELETE CASCADE,
ADD CONSTRAINT `drive_ibfk_2` FOREIGN KEY (`car_id`) REFERENCES `car` (`id`),
ADD CONSTRAINT `drive_ibfk_3` FOREIGN KEY (`emp_id`) REFERENCES `user` (`id`) ON DELETE SET NULL;

--
-- 限制表 `user`
--
ALTER TABLE `user`
ADD CONSTRAINT `user_ibfk_1` FOREIGN KEY (`role_id`) REFERENCES `role` (`id`);

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
