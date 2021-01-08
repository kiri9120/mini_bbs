-- phpMyAdmin SQL Dump
-- version 4.9.5
-- https://www.phpmyadmin.net/
--
-- ホスト: localhost:8889
-- 生成日時: 2021 年 1 月 08 日 13:36
-- サーバのバージョン： 5.7.30
-- PHP のバージョン: 7.4.9

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- データベース: `mini_bbs`
--
-- CREATE DATABASE IF NOT EXISTS `mini_bbs` DEFAULT CHARACTER SET utf8mb4 COLLATE utf8mb4_general_ci;
-- USE `mini_bbs`;

-- --------------------------------------------------------

--
-- テーブルの構造 `members`
--

CREATE TABLE `members` (
  `id` int(11) NOT NULL,
  `name` varchar(255) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(100) NOT NULL,
  `picture` varchar(255) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `members`
--

INSERT INTO `members` (`id`, `name`, `email`, `password`, `picture`, `created`, `modified`) VALUES
(1, 'aaaaaaaa', 'aaa', '70c881d4a26984ddce795f6f71817c9cf4480e79', '20201217141532ukiyoe.jpg', '2020-12-17 14:15:41', '2020-12-17 05:15:41'),
(2, 'gafdgfhf', 'ghfagdgad', '8d91d6227724d80932473bec1289add6e58dac0e', '20201217141904ukiyoe.jpg', '2020-12-17 14:19:05', '2020-12-17 05:19:05'),
(3, 'テスト太郎', 'test@gmail.com', '70c881d4a26984ddce795f6f71817c9cf4480e79', '20201217142348ukiyoe.jpg', '2020-12-17 14:23:52', '2020-12-17 05:23:52'),
(6, 'bar', 'bar@gmail.com', '70c881d4a26984ddce795f6f71817c9cf4480e79', '20201217183326ukiyoe.jpg', '2020-12-17 18:33:28', '2020-12-17 09:33:28'),
(7, 'taro', 'taro@gmail.com', '70c881d4a26984ddce795f6f71817c9cf4480e79', '20201217183618shirt red.jpg', '2020-12-17 18:36:20', '2020-12-17 09:36:20'),
(8, 'aaaa', 'a@gmail.com', '70c881d4a26984ddce795f6f71817c9cf4480e79', '20201220081138', '2020-12-20 08:11:41', '2020-12-19 23:11:41'),
(9, 'abc', 'b@gmail.com', '70c881d4a26984ddce795f6f71817c9cf4480e79', '20201221154828', '2020-12-21 15:48:30', '2020-12-21 06:48:30'),
(10, 'aaaaaa', 'c@gmail.com', '70c881d4a26984ddce795f6f71817c9cf4480e79', '20201221160408ukiyoe.jpg', '2020-12-21 16:04:24', '2020-12-21 07:04:24'),
(11, 'dd', 'd@gmail.com', '70c881d4a26984ddce795f6f71817c9cf4480e79', '', '2020-12-21 16:07:51', '2020-12-21 07:07:51');

-- --------------------------------------------------------

--
-- テーブルの構造 `posts`
--

CREATE TABLE `posts` (
  `id` int(11) NOT NULL,
  `message` text NOT NULL,
  `member_id` int(11) NOT NULL,
  `reply_message_id` int(11) NOT NULL,
  `created` datetime NOT NULL,
  `modified` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

--
-- テーブルのデータのダンプ `posts`
--

INSERT INTO `posts` (`id`, `message`, `member_id`, `reply_message_id`, `created`, `modified`) VALUES
(6, 'hogedesu', 6, 0, '2020-12-17 18:34:45', '2020-12-17 09:34:45'),
(7, 'aaa', 6, 0, '2020-12-17 18:36:38', '2020-12-17 09:36:38'),
(8, '@テスト こんにちは', 6, 0, '2020-12-17 18:57:15', '2020-12-17 09:57:15'),
(9, '@bar hogedesu  <good!', 6, 6, '2020-12-17 19:01:02', '2020-12-17 10:01:02'),
(18, 'gfga', 7, 0, '2020-12-19 08:22:32', '2020-12-18 23:22:32'),
(19, 'aba', 11, 0, '2020-12-21 16:51:16', '2020-12-21 07:51:16'),
(21, '@bar @bar hogedesu  <good! < ああああ', 11, 9, '2020-12-21 17:15:07', '2020-12-21 08:15:07'),
(22, 'っっdgdgd', 11, 0, '2020-12-21 17:15:22', '2020-12-21 08:15:22'),
(23, 'hoge', 11, 0, '2020-12-21 17:15:26', '2020-12-21 08:15:26'),
(24, 'bar', 11, 0, '2020-12-21 17:15:29', '2020-12-21 08:15:29'),
(25, 'foo', 11, 0, '2020-12-21 17:15:32', '2020-12-21 08:15:32');

--
-- ダンプしたテーブルのインデックス
--

--
-- テーブルのインデックス `members`
--
ALTER TABLE `members`
  ADD PRIMARY KEY (`id`);

--
-- テーブルのインデックス `posts`
--
ALTER TABLE `posts`
  ADD PRIMARY KEY (`id`);

--
-- ダンプしたテーブルのAUTO_INCREMENT
--

--
-- テーブルのAUTO_INCREMENT `members`
--
ALTER TABLE `members`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- テーブルのAUTO_INCREMENT `posts`
--
ALTER TABLE `posts`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=26;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
