-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2022-04-11 16:15:48
-- 服务器版本： 5.7.26
-- PHP 版本： 7.3.4

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- 数据库： `dragon_bbs`
--

-- --------------------------------------------------------

--
-- 表的结构 `dragon_posts`
--

CREATE TABLE `dragon_posts` (
  `id` bigint(20) NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `title` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `releasetime` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `dragon_posts`
--

INSERT INTO `dragon_posts` (`id`, `email`, `title`, `content`, `releasetime`) VALUES
(427, '2148515600@qq.com', '@123@', '1 2 3 4 5 6 7 8 9 10 11 12 13 14', '2022-02-28  09:16:41'),
(428, '2967667376@qq.com', '@456@', '15 14 13 12 11 10 9 8 7 6 5 4 3 2 1', '2022-03-01  09:32:30'),
(431, '1463166966@qq.com', '叙利亚暑假工', '叙利亚招工了1一天10000！机不可失失不再来，把握好机会各位', '2022-03-02  19:48:12'),
(433, '2050016441@qq.com', '123', '大哥是我儿子', '2022-03-08  08:43:12');

-- --------------------------------------------------------

--
-- 表的结构 `dragon_postscollect`
--

CREATE TABLE `dragon_postscollect` (
  `postsid` bigint(20) NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `releasetime` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `dragon_postscollect`
--

INSERT INTO `dragon_postscollect` (`postsid`, `email`, `releasetime`) VALUES
(427, '1463166966@qq.com', '2022-03-02  20:34:50'),
(431, '1463166966@qq.com', '2022-03-02  20:35:07'),
(433, '2148515600@qq.com', '2022-03-08  08:45:23'),
(428, '2148515600@qq.com', '2022-03-02  19:42:47'),
(431, '2148515600@qq.com', '2022-03-02  19:48:37');

-- --------------------------------------------------------

--
-- 表的结构 `dragon_postslike`
--

CREATE TABLE `dragon_postslike` (
  `postsid` bigint(20) NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `releasetime` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `dragon_postslike`
--

INSERT INTO `dragon_postslike` (`postsid`, `email`, `releasetime`) VALUES
(427, '2148515600@qq.com', '2022-03-01  14:55:16'),
(427, '2967667376@qq.com', '2022-03-01  09:32:34'),
(427, '1463166966@qq.com', '2022-03-02  20:34:51'),
(433, '2148515600@qq.com', '2022-03-08  08:43:32');

-- --------------------------------------------------------

--
-- 表的结构 `dragon_reply`
--

CREATE TABLE `dragon_reply` (
  `replyid` bigint(20) NOT NULL,
  `postid` bigint(20) NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `releasetime` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `content` text COLLATE utf8_unicode_ci NOT NULL,
  `likes` bigint(20) NOT NULL,
  `replys` bigint(20) NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `dragon_reply`
--

INSERT INTO `dragon_reply` (`replyid`, `postid`, `email`, `releasetime`, `content`, `likes`, `replys`) VALUES
(81, 428, '2148515600@qq.com', '2022-03-02  19:42:53', '22222', 0, 0),
(82, 433, '2148515600@qq.com', '2022-03-08  08:45:30', 'NB666', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `dragon_replylike`
--

CREATE TABLE `dragon_replylike` (
  `postsid` bigint(20) NOT NULL,
  `replyid` bigint(20) NOT NULL,
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `releasetime` varchar(20) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

-- --------------------------------------------------------

--
-- 表的结构 `dragon_snake`
--

CREATE TABLE `dragon_snake` (
  `email` varchar(20) COLLATE utf8_unicode_ci NOT NULL,
  `score` bigint(20) NOT NULL,
  `times` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `dragon_snake`
--

INSERT INTO `dragon_snake` (`email`, `score`, `times`) VALUES
('2275242978@qq.com', 8, '2021-12-31  11:19:17'),
('2275242978@qq.com', 11, '2021-12-31  11:18:54'),
('2275242978@qq.com', 10, '2021-12-31  11:18:11'),
('2275242978@qq.com', 16, '2021-12-31  11:17:31'),
('2275242978@qq.com', 24, '2021-12-31  11:14:46'),
('2275242978@qq.com', 10, '2021-12-31  11:12:26'),
('1463166966@qq.com', 27, '2021-12-31  11:11:58'),
('2655249501@qq.com', 1, '2021-12-31  11:09:31'),
('1463166966@qq.com', 132, '2021-12-31  11:09:27'),
('2655249501@qq.com', 8, '2021-12-31  11:09:11'),
('2148515600@qq.com', 53, '2021-12-31  11:08:29'),
('2148515600@qq.com', 34, '2021-12-31  11:04:40'),
('2148515600@qq.com', 2, '2021-12-31  11:01:33'),
('2148515600@qq.com', 2, '2021-12-31  11:01:22'),
('1003614120@qq.com', 65, '2021-12-31  11:00:20'),
('1463166966@qq.com', 72, '2021-12-31  10:58:11'),
('1003614120@qq.com', 8, '2021-12-31  10:55:11'),
('1463166966@qq.com', 75, '2021-12-31  10:52:42'),
('1463166966@qq.com', 0, '2021-12-31  10:46:39'),
('1463166966@qq.com', 15, '2021-12-31  10:44:41'),
('1463166966@qq.com', 29, '2021-12-31  10:46:35'),
('1463166966@qq.com', 4, '2021-12-31  10:43:34'),
('1463166966@qq.com', 12, '2021-12-31  10:42:57'),
('1003614120@qq.com', 17, '2021-12-31  10:43:08'),
('1463166966@qq.com', 37, '2021-12-31  10:42:18'),
('1463166966@qq.com', 11, '2021-12-31  10:40:19'),
('2113733958@qq.com', 14, '2021-12-31  10:40:12'),
('2113733958@qq.com', 1, '2021-12-31  10:38:18'),
('2113733958@qq.com', 0, '2021-12-31  10:38:05'),
('2148515600@qq.com', 33, '2021-12-31  10:38:16'),
('1627159250@qq.com', 0, '2021-12-31  10:00:32'),
('2148515600@qq.com', 12, '2021-12-31  10:00:59'),
('2113733958@qq.com', 10, '2021-12-31  10:38:01'),
('2148515600@qq.com', 63, '2021-12-31  11:13:34'),
('2275242978@qq.com', 2, '2021-12-31  11:12:39'),
('1627159250@qq.com', 3, '2021-12-31  10:00:24'),
('2655249501@qq.com', 8, '2021-12-31  10:00:19'),
('2148515600@qq.com', 61, '2021-12-31  08:46:26'),
('2148515600@qq.com', 8, '2021-12-31  10:00:11'),
('1627159250@qq.com', 1, '2021-12-31  10:00:03'),
('2148515600@qq.com', 20, '2021-12-31  09:59:31'),
('1565365012@qq.com', 24, '2021-12-31  09:42:48'),
('1565365012@qq.com', 12, '2021-12-31  09:41:04'),
('1565365012@qq.com', 4, '2021-12-31  09:40:19'),
('1565365012@qq.com', 4, '2021-12-31  09:40:00'),
('2148515600@qq.com', 67, '2021-12-31  09:13:10'),
('1463166966@qq.com', 19, '2021-12-31  09:10:13'),
('2655249501@qq.com', 6, '2021-12-31  09:10:05'),
('2148515600@qq.com', 82, '2021-12-30  20:17:42'),
('2148515600@qq.com', 18, '2022-01-02  10:15:27'),
('2148515600@qq.com', 16, '2022-01-13  16:10:43'),
('2967667376@qq.com', 27, '2022-01-13  16:33:57'),
('2967667376@qq.com', 0, '2022-01-13  17:27:47'),
('2148515600@qq.com', 14, '2022-02-08  15:36:59'),
('2148515600@qq.com', 8, '2022-02-27  19:20:34'),
('2275242978@qq.com', 15, '2022-03-01  14:33:30'),
('2275242978@qq.com', 8, '2022-03-01  14:34:16'),
('2275242978@qq.com', 0, '2022-03-01  14:34:40'),
('2275242978@qq.com', 5, '2022-03-01  14:35:20'),
('2275242978@qq.com', 11, '2022-03-01  14:36:09'),
('2275242978@qq.com', 10, '2022-03-01  14:36:49'),
('2148515600@qq.com', 0, '2022-03-01  14:58:02'),
('2148515600@qq.com', 13, '2022-03-01  14:59:16');

-- --------------------------------------------------------

--
-- 表的结构 `dragon_users`
--

CREATE TABLE `dragon_users` (
  `email` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `password` varchar(8) COLLATE utf8_unicode_ci NOT NULL,
  `nickname` varchar(10) COLLATE utf8_unicode_ci NOT NULL,
  `headimg` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `birthday` date DEFAULT NULL,
  `member` tinyint(1) DEFAULT '0',
  `posts` bigint(20) DEFAULT '0'
) ENGINE=MyISAM DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `dragon_users`
--

INSERT INTO `dragon_users` (`email`, `password`, `nickname`, `headimg`, `birthday`, `member`, `posts`) VALUES
('2148515600@qq.com', '0215song', 'jiale', 'informations/2148515600@qq.com/images/headimg.jpg', '2004-04-04', 1, 1),
('2967667376@qq.com', '123456', 'TEST', 'informations/2967667376@qq.com/images/headimg.jpg', '2004-04-04', 0, 1),
('1565365012@qq.com', '123456', '暴龙战士小小娇妻', 'informations/1565365012@qq.com/images/headimg.jpg', '2021-12-31', 0, 0),
('2275242978@qq.com', '123456', 'evsdgr', 'informations/2275242978@qq.com/images/headimg.jpg', '2021-12-01', 0, 0),
('3107517215@qq.com', '123456', '暴龙战士不在低调', 'informations/3107517215@qq.com/images/headimg.jpg', '0001-01-01', 0, 0),
('3152106199@qq.com', '123456', 'qjlnrh', 'informations/3152106199@qq.com/images/headimg.jpg', '2018-06-05', 0, 0),
('3320753238@qq.com', '123456', '提尔瓦特', 'informations/3320753238@qq.com/images/headimg.jpg', '2004-02-26', 0, 0),
('1627159250@qq.com', '123456', 'admin', 'informations/1627159250@qq.com/images/headimg.jpg', '2021-12-14', 0, 0),
('2655249501@qq.com', 'nimasile', 'admin', 'informations/2655249501@qq.com/images/headimg.jpg', '2021-12-13', 0, 0),
('2113733958@qq.com', 'wynglx', '蛋蛋', 'informations/2113733958@qq.com/images/headimg.jpg', '2003-07-01', 1, 0),
('1463166966@qq.com', '123qwer', '神的裤衩', 'informations/1463166966@qq.com/images/headimg.jpg', '2021-12-14', 0, 1),
('1003614120@qq.com', '245680', '晴天', 'informations/1003614120@qq.com/images/headimg.jpg', '2004-03-14', 0, 0),
('2050016441@qq.com', '1214520', '神明', 'informations/2050016441@qq.com/images/headimg.jpg', '2161-12-14', 0, 1);

--
-- 转储表的索引
--

--
-- 表的索引 `dragon_posts`
--
ALTER TABLE `dragon_posts`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `dragon_reply`
--
ALTER TABLE `dragon_reply`
  ADD PRIMARY KEY (`replyid`);

--
-- 表的索引 `dragon_users`
--
ALTER TABLE `dragon_users`
  ADD PRIMARY KEY (`email`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `dragon_posts`
--
ALTER TABLE `dragon_posts`
  MODIFY `id` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=434;

--
-- 使用表AUTO_INCREMENT `dragon_reply`
--
ALTER TABLE `dragon_reply`
  MODIFY `replyid` bigint(20) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=83;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
