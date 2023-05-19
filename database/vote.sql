-- phpMyAdmin SQL Dump
-- version 4.8.5
-- https://www.phpmyadmin.net/
--
-- 主机： localhost
-- 生成日期： 2023-05-19 19:11:01
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
-- 数据库： `vote`
--

-- --------------------------------------------------------

--
-- 表的结构 `photo`
--

CREATE TABLE `photo` (
  `id` int(11) NOT NULL,
  `photoName` varchar(45) COLLATE utf8_unicode_ci NOT NULL,
  `photoDesc` varchar(1000) COLLATE utf8_unicode_ci NOT NULL,
  `Pic` varchar(256) COLLATE utf8_unicode_ci NOT NULL,
  `photoNum` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `photo`
--

INSERT INTO `photo` (`id`, `photoName`, `photoDesc`, `Pic`, `photoNum`) VALUES
(2, '酷仔朋友', '酷的嘞', '646733c65fdea.jpg', 12),
(3, '我的朋友', '超级美的', '3.jpg', 23),
(4, '我的朋友', '好甜', '4.jpg', 50),
(5, '我为莎仔竖大旗', '好美好美', '5.jpg', 42),
(7, '曼曼！', '耶耶耶，超美的曼曼', '646733b9d3082.jpg', 29),
(8, '我的朋友', '我的朋友', '646733dd84e7a.jpg', 32),
(9, '我的朋友', '我的朋友', '6467341f5b5f2.jpg', 20),
(12, '我的老宝', '好美的呀！！', '12.jpg', 60),
(13, '搞笑美女', '我觉得超级搞笑的大美女', '6467584d0834c.jpg', 0);

-- --------------------------------------------------------

--
-- 表的结构 `userinfo`
--

CREATE TABLE `userinfo` (
  `id` int(11) NOT NULL,
  `username` varchar(30) NOT NULL COMMENT '用户名',
  `pw` varchar(32) NOT NULL COMMENT '密码',
  `email` varchar(255) NOT NULL COMMENT '邮箱',
  `admin` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否为管理员',
  `createTime` int(10) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- 转存表中的数据 `userinfo`
--

INSERT INTO `userinfo` (`id`, `username`, `pw`, `email`, `admin`, `createTime`) VALUES
(1, 'admin', '123456789', '111@qq.com', 1, 0),
(2, 'test', '123456', '李二', 0, 0);

-- --------------------------------------------------------

--
-- 表的结构 `votedetail`
--

CREATE TABLE `votedetail` (
  `id` int(11) NOT NULL,
  `userID` int(11) NOT NULL,
  `photoID` int(11) NOT NULL,
  `voteTime` int(11) NOT NULL,
  `ip` varchar(15) COLLATE utf8_unicode_ci NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;

--
-- 转存表中的数据 `votedetail`
--

INSERT INTO `votedetail` (`id`, `userID`, `photoID`, `voteTime`, `ip`) VALUES
(7, 1, 5, 1684455895, '127.0.0.1'),
(13, 1, 8, 1684485845, '127.0.0.1');

--
-- 转储表的索引
--

--
-- 表的索引 `photo`
--
ALTER TABLE `photo`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `userinfo`
--
ALTER TABLE `userinfo`
  ADD PRIMARY KEY (`id`);

--
-- 表的索引 `votedetail`
--
ALTER TABLE `votedetail`
  ADD PRIMARY KEY (`id`),
  ADD KEY `userID` (`userID`) USING BTREE,
  ADD KEY `photoID` (`photoID`);

--
-- 在导出的表使用AUTO_INCREMENT
--

--
-- 使用表AUTO_INCREMENT `photo`
--
ALTER TABLE `photo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 使用表AUTO_INCREMENT `userinfo`
--
ALTER TABLE `userinfo`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- 使用表AUTO_INCREMENT `votedetail`
--
ALTER TABLE `votedetail`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=14;

--
-- 限制导出的表
--

--
-- 限制表 `votedetail`
--
ALTER TABLE `votedetail`
  ADD CONSTRAINT `photoid` FOREIGN KEY (`photoID`) REFERENCES `photo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `userid` FOREIGN KEY (`userID`) REFERENCES `userinfo` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
