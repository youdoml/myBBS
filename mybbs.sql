-- phpMyAdmin SQL Dump
-- version 4.8.4
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Generation Time: Apr 01, 2019 at 04:26 PM
-- Server version: 10.1.37-MariaDB
-- PHP Version: 7.3.0

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
SET AUTOCOMMIT = 0;
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `mybbs`
--

-- --------------------------------------------------------

--
-- Table structure for table `ly_comments`
--

CREATE TABLE `ly_comments` (
  `cid` int(11) UNSIGNED NOT NULL COMMENT '评论id',
  `content` varchar(255) DEFAULT NULL COMMENT '评论内容',
  `uid` int(11) DEFAULT NULL COMMENT '评论人',
  `wid` int(11) UNSIGNED DEFAULT NULL COMMENT '被评论的留言id',
  `to_cid` int(11) UNSIGNED DEFAULT NULL COMMENT '被评论的评论id',
  `create_time` int(11) UNSIGNED DEFAULT NULL COMMENT '评论时间',
  `delete_time` int(11) UNSIGNED DEFAULT NULL COMMENT '删除时间',
  `star` int(11) UNSIGNED DEFAULT '0' COMMENT '点赞数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ly_comment_star`
--

CREATE TABLE `ly_comment_star` (
  `id` int(11) UNSIGNED NOT NULL,
  `cid` int(11) UNSIGNED NOT NULL COMMENT '点赞的评论',
  `uid` int(11) UNSIGNED NOT NULL COMMENT '点赞者',
  `create_time` int(11) UNSIGNED DEFAULT NULL COMMENT '点赞的时间',
  `delete_time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ly_users`
--

CREATE TABLE `ly_users` (
  `uid` int(11) UNSIGNED NOT NULL COMMENT '用户id',
  `username` varchar(255) NOT NULL COMMENT '用户名',
  `password` varchar(255) DEFAULT NULL COMMENT '密码',
  `email` varchar(255) DEFAULT NULL COMMENT 'email',
  `image` varchar(255) DEFAULT NULL COMMENT '图片文件名',
  `create_time` int(11) UNSIGNED DEFAULT NULL COMMENT '创建时间',
  `delete_time` int(11) UNSIGNED DEFAULT NULL COMMENT '删除时间'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Dumping data for table `ly_users`
--

INSERT INTO `ly_users` (`uid`, `username`, `password`, `email`, `image`, `create_time`, `delete_time`) VALUES
(1, 'domic', 'beab87b2ce4bf7b2391b5e7081bf69c0', '12@.qq.com', 'picture.png', 1553761358, NULL),
(2, 'chen', 'e0a0bee4b6417b2a2ac0adf56b279768', 'chen@qq.com', 'picture.png', 1554127273, NULL),
(3, 'li', '3c4d7c9d9a4b5f878cbda65010df8d4f', 'li@qq.com', 'picture.png', 1554128317, NULL);

-- --------------------------------------------------------

--
-- Table structure for table `ly_words`
--

CREATE TABLE `ly_words` (
  `wid` int(11) UNSIGNED NOT NULL COMMENT '留言id',
  `content` varchar(255) NOT NULL COMMENT '留言内容',
  `uid` int(11) UNSIGNED DEFAULT NULL COMMENT '留言用户',
  `create_time` int(11) UNSIGNED DEFAULT NULL COMMENT '留言时间',
  `delete_time` int(11) UNSIGNED DEFAULT NULL COMMENT '删除时间',
  `star` int(11) UNSIGNED DEFAULT '0' COMMENT '点赞数'
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

-- --------------------------------------------------------

--
-- Table structure for table `ly_word_star`
--

CREATE TABLE `ly_word_star` (
  `id` int(11) UNSIGNED NOT NULL COMMENT '点赞id',
  `wid` int(11) UNSIGNED NOT NULL COMMENT '点赞的留言',
  `uid` int(11) UNSIGNED NOT NULL COMMENT '点赞的人',
  `create_time` int(11) UNSIGNED DEFAULT NULL COMMENT '点赞的时间',
  `delete_time` int(11) UNSIGNED DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8;

--
-- Indexes for dumped tables
--

--
-- Indexes for table `ly_comments`
--
ALTER TABLE `ly_comments`
  ADD PRIMARY KEY (`cid`) USING BTREE;

--
-- Indexes for table `ly_comment_star`
--
ALTER TABLE `ly_comment_star`
  ADD PRIMARY KEY (`id`),
  ADD KEY `uid` (`uid`) COMMENT 'uid索引',
  ADD KEY `cid` (`cid`) COMMENT 'cid';

--
-- Indexes for table `ly_users`
--
ALTER TABLE `ly_users`
  ADD PRIMARY KEY (`uid`);

--
-- Indexes for table `ly_words`
--
ALTER TABLE `ly_words`
  ADD PRIMARY KEY (`wid`) USING BTREE,
  ADD KEY `uid` (`uid`);

--
-- Indexes for table `ly_word_star`
--
ALTER TABLE `ly_word_star`
  ADD PRIMARY KEY (`id`),
  ADD KEY `wid` (`wid`) USING BTREE COMMENT 'wid的索引',
  ADD KEY `uid` (`uid`) USING BTREE COMMENT 'uid的索引';

--
-- AUTO_INCREMENT for dumped tables
--

--
-- AUTO_INCREMENT for table `ly_comments`
--
ALTER TABLE `ly_comments`
  MODIFY `cid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '评论id';

--
-- AUTO_INCREMENT for table `ly_comment_star`
--
ALTER TABLE `ly_comment_star`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT for table `ly_users`
--
ALTER TABLE `ly_users`
  MODIFY `uid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '用户id', AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT for table `ly_words`
--
ALTER TABLE `ly_words`
  MODIFY `wid` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '留言id';

--
-- AUTO_INCREMENT for table `ly_word_star`
--
ALTER TABLE `ly_word_star`
  MODIFY `id` int(11) UNSIGNED NOT NULL AUTO_INCREMENT COMMENT '点赞id';

--
-- Constraints for dumped tables
--

--
-- Constraints for table `ly_comment_star`
--
ALTER TABLE `ly_comment_star`
  ADD CONSTRAINT `ly_comment_star_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ly_users` (`uid`),
  ADD CONSTRAINT `ly_comment_star_ibfk_2` FOREIGN KEY (`cid`) REFERENCES `ly_comments` (`cid`);

--
-- Constraints for table `ly_words`
--
ALTER TABLE `ly_words`
  ADD CONSTRAINT `ly_words_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ly_users` (`uid`);

--
-- Constraints for table `ly_word_star`
--
ALTER TABLE `ly_word_star`
  ADD CONSTRAINT `ly_word_star_ibfk_1` FOREIGN KEY (`uid`) REFERENCES `ly_users` (`uid`),
  ADD CONSTRAINT `ly_word_star_ibfk_2` FOREIGN KEY (`wid`) REFERENCES `ly_words` (`wid`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
